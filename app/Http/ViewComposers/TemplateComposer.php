<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Auth;
use App\ColleagueRequest;

class TemplateComposer
{
    public function compose(View $view)
    {        
        if(Auth::check()) {
            $colleagueRequests = ColleagueRequest::where('colleague_id', Auth::user()->id)
                ->where('accepted', false)
                ->where('rejected', false)
                ->where('blocked', false)
                ->get();

            $notification_count = (count($colleagueRequests));
        }
        else{
            $notification_count = 0;
        }
        
        $view->with(['notification_count' => $notification_count]);
    }
}