<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = "tasks";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'completed',
        'task',
        'tasklist_id',
        'edit',
        'timer_start',
        'timer_active',
        'work_duration'
    ];

    public function tasklist() {
    	return $this->belongsTo('App\Tasklist');
    }

    public function timelogs() {
        return $this->hasMany('App\Timelog');
    }

    public function formatDate($date){
        return Carbon::parse($date)->format('m/d/Y h:i:s A');
    }

    public function calculateWorkDuration() {
        $totalTime = 0;
        foreach($this->timelogs as $timelog){
            $totalTime = $totalTime + $timelog->total_time;
        }
        return $totalTime;
    }

    public function secondsToHrsMinSecString($seconds) {
        $totalSeconds = $seconds;

        $hours = floor($totalSeconds / 3600);
        $totalSeconds = $totalSeconds % 3600;
        $minutes = floor($totalSeconds / 60);
        $seconds = $totalSeconds % 60;

        $HrMinSecString = $hours . ' hrs, ' . $minutes . ' min ' . $seconds . ' sec';
        return $HrMinSecString; 
    }

    public function currentTimerInSeconds() {
        if($this->timer_active){
            return Carbon::now()->diffInSeconds($this->timer_start);
        }
        else{
            return 0;
        }
    }

    public function totalTimeInSeconds() {
        return $this->work_duration + $this->currentTimerInSeconds();
    }

    public function checkOwnership() {
        if($this->tasklist->user == Auth::user()) {
            return true;
        }
        return false;
    }
}
