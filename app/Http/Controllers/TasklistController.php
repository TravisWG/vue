<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Task;
use App\Tasklist;
use Carbon\Carbon;

class TasklistController extends Controller
{
    public function __construct(){
    $this->middleware('auth');
    }

    public function index(){
        $tasklist = Tasklist::firstOrCreate([
            'user_id' => Auth::user()->id
        ]);
        return view('tasklist');
    }

    public function getTasklist(){        
        $tasklist_id = Auth::user()->tasklist->id;
        $tasks = Task::where('completed', 0)->where('tasklist_id', $tasklist_id)->get()->toArray();

        return $tasks;
    }

    public function getArchivedTasks(){        
        $tasklist_id = Auth::user()->tasklist->id;
        $tasks = Task::onlyTrashed()->where('tasklist_id', $tasklist_id)->get();

        return view('archives')->with(compact('tasks'));
    }

    public function getCompletedTasklist(){
        $tasklist_id = Auth::user()->tasklist->id;
        $completedTasks = Task::where('completed', 1)->where('tasklist_id', $tasklist_id)->get();
        foreach($completedTasks as $task){
            $task->completed_at = $task->formatCompletedAtDate();
        }
        return $completedTasks->toArray();
    }

    public function addNewTask(Request $request) {
        $return = ['status' => 'error'];
        $tasklistId = Auth::user()->tasklist->id;
        if ($request->task != null){
            $task = Task::create([
                'task' => $request->task,
                'tasklist_id' => $tasklistId,
                'completed' => false,
                'edit' => false
            ]);
            $return = $task;
        }

        return $return;
    }

    public function editTask(Request $request) {

        $task = Task::find($request->task['id']);
        $return = ['status' => 'error', 'task' => $task->task];
        if ($request->task['task'] != null){
            $task->task = $request->task['task'];
            $task->save();
            $return = ['status' => 'success', 'task' => $task->task];
        }
        return $return;
    }

    public function removeTask(Request $request) {
        $return = ['status' => 'error'];
        $task = Task::where('id', $request->task['id'])->first();
        if($task && $this->checkTaskOwnership($task)){
            $task->delete();
            $return = ['status' => 'success'];
        }
        return $return;
    }

    public function toggleTaskCompletionStatus(Request $request) {
        $return = ['status' => 'error'];
        $task = Task::where('id', $request->task['id'])->first();
        if($task && $this->checkTaskOwnership($task)){
            $task->completed = !$task->completed;
            $task->completed_at = Carbon::now();
            $task->save();
            $return = ['status' => 'success'];
        }
        return $return;
    }

    public function checkTaskOwnership($task) {
        if($task->tasklist->user == Auth::user()) {
            return true;
        }
        return false;
    }
}
