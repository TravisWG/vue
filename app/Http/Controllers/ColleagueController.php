<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Colleague;
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

     public function getColleagues(){
        $colleagues = Colleague::where('user_id', Auth::user()->id)
            ->where('blocked', false)
            ->with('colleague_user')
            ->get();

        return $colleagues;
    }

    public function getColleagueRequests(){
        $colleagueRequests = ColleagueRequest::with('sendingUser')
            ->where('colleague_id', Auth::user()->id)
            ->where('accepted', false) 
            ->where('rejected', false) 
            ->where('blocked', false) 
            ->get();

        return $colleagueRequests;
    }

    public function postRequestResponse(Request $request) {
        $colleagueRequest = ColleagueRequest::find($request->id);

        if($request->response == 'accept'){
            $colleagueRequest->accepted = true;

            $colleagueRelationship = Colleague::firstOrcreate([
                "user_id" => $colleagueRequest->sendingUser()->id,
                "colleague_id" => $colleagueRequest->receivingUser()->id,            
            ]);

            $inverseColleagueRelationship = Colleague::firstOrCreate([
                "user_id" => $colleagueRequest->receivingUser()->id,
                "colleague_id" => $colleagueRequest->sendingUser()->id,            
            ]);

        }else if ($request->response == 'deny') {
            $colleagueRequest->rejected = true;
        }else if ($request->response == 'block') {
            $colleagueRequest->blocked = true;

            //create a Colleague Relationship for the blocking user
            $colleagueRelationship = Colleague::firstOrcreate([
                "user_id" => $colleagueRequest->Auth::user()->id,
                "colleague_id" => $colleagueRequest->sendingUser()->id,
                "blocked" => true,            
            ]);
        } else{
            return["status" => "failure", "message" => "Unknown response value"];
        }
        $colleagueRequest->save();
        $colleagueRequest->delete();

        return ["status" => "success"];        
    }
}
