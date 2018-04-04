<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Task;
use App\Tasklist;
use App\Timelog;
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
        $tasks = Task::where('tasklist_id', $tasklist_id)->get()->toArray();

        return $tasks;
    }

    public function getArchivedTasks(){        
        $tasklist_id = Auth::user()->tasklist->id;
        $tasks = Task::onlyTrashed()->where('tasklist_id', $tasklist_id)->get();

        return view('archives')->with(compact('tasks'));
    }

    public function addNewTask(Request $request) {
        $return = ['status' => 'error'];
        $tasklistId = Auth::user()->tasklist->id;
        if ($request->task != null){
            $task = Task::create([
                'task' => $request->task,
                'tasklist_id' => $tasklistId,
                'completed' => false,
                'edit' => false,
                'timer_active' => false,
                'work_duration' => 0
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
            $return = ['status' => 'success', 'task' => $task];
        }
        return $return;
    }

    public function removeTask(Request $request) {
        $return = ['status' => 'error'];
        $task = Task::where('id', $request->task['id'])->first();
        if($task && $this->checkTaskOwnership($task)){
            $task->delete();
            $return = ['status' => 'success', 'task' => $task];
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
            $return = ['status' => 'success', 'task' => $task];
        }
        return $return;
    }

    public function startTimer(Request $request) {
        $return = ['status' => 'error'];
        $task = Task::where('id', $request->task['id'])->first();
        if($task && $this->checkTaskOwnership($task)){
            
            $timelog = Timelog::create([
                'task_id' => $task->id,
                'start_time' => Carbon::now()
            ]);

            $task->timer_active = true;
            $task->timer_start = Carbon::now();
            $task->save();
            $return = ['status' => 'success', 'task' => $task];
        }
        return $return;
    }

    public function stopTimer(Request $request) {
        $return = ['status' => 'error'];
        $task = Task::where('id', $request->task['id'])->first();
        if($task && $this->checkTaskOwnership($task)){
            $timelog = Timelog::where('task_id', $task->id)->where('active', true)->firstOrFail();
            $timelog->completeTimelog();

            $task->timer_active = false;
            $task->work_duration = $task->calculateWorkDuration();
            $task->save();
            $return = ['status' => 'success', 'task' => $task];
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
