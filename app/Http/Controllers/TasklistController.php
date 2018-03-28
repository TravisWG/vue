<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Task;
use App\Tasklist;

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
        $tasks = Task::where('completed', 0)->get()->toArray();
        return $tasks;
    }

    public function getCompletedTasklist(){
        $completedTasks = Task::where('completed', 1)->get()->toArray();
        return $completedTasks;
    }

    public function addNewTask(Request $request) {
        $return = ['status' => 'error'];
        $userId = Auth::user()->tasklist->id;
        if ($request->task != null){
            $task = Task::create([
                'task' => $request->task,
                'tasklist_id' => $userId,
                'completed' => false
            ]);
            $return = $task;
        }

        return $return;
    }

    public function removeTask(Request $request) {
        $return = ['status' => 'error'];
        $task = Task::where('id', $request->task['id'])->first();
        if($task){
            $task->delete();
            $return = ['status' => 'success'];
        }
        return $return;
    }

    public function toggleTaskCompletionStatus(Request $request) {
        $return = ['status' => 'error'];
        $task = Task::where('id', $request->task['id'])->first();
        if($task){
            $task->completed = !$task->completed;
            $task->save();
            $return = ['status' => 'success'];
        }
        return $return;
    }
}
