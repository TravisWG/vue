<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Task;

class TasklistController extends Controller
{
    public function index(){
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
}
