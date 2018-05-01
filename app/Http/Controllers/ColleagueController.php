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
            $sentColleagueRequests = ColleagueRequest::where('user_id', Auth::user()->id)
                ->where('accepted', false) 
                ->where('rejected', false)
                ->get();

            $receivedColleagueRequests = ColleagueRequest::where('colleague_id', Auth::user()->id)
                ->where('accepted', false) 
                ->where('rejected', false)
                ->get();

            foreach($users as $user){
                $user->requestStatus = 'notColleague';
                $user->requestMessage = null;

                if(count($sentColleagueRequests) > 0){
                    foreach($sentColleagueRequests as $sentColleagueRequest){
                        if($sentColleagueRequest->colleague_id == $user->id){
                            $user->requestStatus = 'requestPending';
                            break;
                        }
                    }
                }
                if(count($receivedColleagueRequests) > 0){
                    foreach($receivedColleagueRequests as $receivedColleagueRequest){
                        if($receivedColleagueRequest->user_id == $user->id){
                            $user->requestStatus = 'requested';
                            break;
                        }
                    }
                }
                
                foreach(Auth::user()->colleagueRelationships as $colleague){
                    if($colleague->colleague_id == $user->id && $colleague->blocked == true){
                        $user->requestStatus = 'blocked';
                        break;
                    }
                    if($colleague->colleague_id == $user->id && $colleague->blocked == false){
                        $user->requestStatus = 'currentColleague';
                        break;
                    }
                }
            }    	   
        
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

    public function requestCancel(Request $request){
        $colleagueId = $request->id;

        $colleagueRequest = ColleagueRequest::where('user_id', Auth::user()->id)
            ->where('colleague_id', $colleagueId)
            ->firstOrFail();

        $colleagueRequest->delete();

        return ["status" => "success"];
    }

    public function unblockColleague(Request $request){
        $colleagueId = $request->colleagueId;

        $colleagueRelationship = Colleague::where('user_id', Auth::user()->id)
            ->where('colleague_id', $colleagueId)
            ->firstOrFail();

        $colleagueRelationship->delete();

        return ["status" => "success"];
    }

    public function removeColleague(Request $request){
        $colleagueId = $request->colleagueId;

        $colleagueRelationships = Colleague::where('user_id', Auth::user()->id)
            ->where('colleague_id', $colleagueId)
            ->orWhere('user_id', $colleagueId)
            ->where('colleague_id', Auth::user()->id)
            ->get();

        foreach($colleagueRelationships as $colleagueRelationship){            
            $colleagueRelationship->delete();
        }

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

        if($request->colleague) {
            $colleagueRequest = ColleagueRequest::where('user_id', $request->userId)
                ->where('colleague_id', Auth::user()->id)
                ->first();
        } elseif($request->colleagueRequest) {
            $colleagueRequest = ColleagueRequest::find($request->id);
        }

        if($request->reply == 'accept'){
            $colleagueRequest->accepted = true;

            $colleagueRelationship = Colleague::firstOrcreate([
                "user_id" => $colleagueRequest->sendingUser->id,
                "colleague_id" => $colleagueRequest->receivingUser->id,            
            ]);

            $inverseColleagueRelationship = Colleague::firstOrCreate([
                "user_id" => $colleagueRequest->receivingUser->id,
                "colleague_id" => $colleagueRequest->sendingUser->id,            
            ]);

        } elseif ($request->reply == 'deny') {
            $colleagueRequest->rejected = true;
        } elseif ($request->reply == 'block') {
            $colleagueRequest->blocked = true;
            //create a Colleague Relationship for the blocking user
            $colleagueRelationship = Colleague::firstOrcreate([
                "user_id" => Auth::user()->id,
                "colleague_id" => $colleagueRequest->sendingUser->id,
            ]);
            $colleagueRelationship->blocked = true;
            $colleagueRelationship->save();
        } else{
            return["status" => "failure", "message" => "Unknown response value"];
        }
        $colleagueRequest->save();
        $colleagueRequest->delete();

        return ["status" => "success"];        
    }
}
