<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function viewTimelogs($id){
    	$task = Task::where('id', $id)->with('timelogs')->first();

    	if($task && $task->checkOwnership()){
    		return view('timelogs')->with(compact('task'));
    	}

    	return redirect()->back();
    }
}
