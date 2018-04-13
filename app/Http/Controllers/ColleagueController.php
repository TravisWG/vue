<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;

class ColleagueController extends Controller
{
    public function index(){
    	return view('colleague');
    }

    public function search(Request $request){
    	$users = User::where('email', $request->email)
    			->orWhere('name', 'like', '%'.$request->name.'%')
    			->where('id', '!=', Auth::user()->id)
    			->get();
    	
        if(count($users) > 0){
    	   return ["status"=>"success", "users"=> $users];
        }

        return ["status"=>"failure", "message"=> "Query returned no results."];
    }
}
