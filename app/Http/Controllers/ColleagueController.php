<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ColleagueRequest;
use App\User;
use Auth;


class ColleagueController extends Controller
{
    public function index(){
    	return view('colleague');
    }

    public function search(Request $request){

    	if($request->name){
            $users = User::where('email', $request->email)
    			->orWhere('name', 'like', '%'.$request->name.'%')
    			->where('id', '!=', Auth::user()->id)
    			->get();
        }else{
            $users = User::where('email', $request->email)
                ->where('id', '!=', Auth::user()->id)
                ->get();
        }
    	
        if(count($users) > 0){
    	   return ["status"=>"success", "users"=> $users];
        }

        return ["status"=>"failure", "message"=> "Query returned no results."];
    }

    public function requestAdd(Request $request){
        $colleagueId = $request->id;

        $colleagueAddRequest = ColleagueRequest::create([
            "user_id" => Auth::user()->id,
            "colleague_id" => $colleagueId,            
        ]);

        return ["status" => "success"];
    }
}
