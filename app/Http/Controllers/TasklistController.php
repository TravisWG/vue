<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TasklistController extends Controller
{
    public function index(){
    	return view('tasklist');
    }
}
