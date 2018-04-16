<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use App\ColleagueRequest;

class NotificationController extends Controller
{
    public function index(){
    	
        return view('notifications');
    }
}
