<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timelog extends Model
{
    use SoftDeletes;

    protected $table = "timelogs";
    protected $dates = [
    	'start_time',
    	'end_time'						
		];

    protected $fillable = [
    	'task_id',
        'start_time',
        'end_time'
    ];

    public function task() {
    	return $this->belongsTo('App\Task');
    }

    public function completeTimelog() {
    	$this->end_time = Carbon::now();
        $this->total_time = $this->calculateSingleLogTime();
        $this->active = false;
        $this->save();
    }

    public function calculateSingleLogTime() {
    	return $this->start_time->diffInSeconds($this->end_time);
    }

    public function formattedStartDate(){
        return $this->formatDate($this->start_time);
    }

    public function formattedEndDate(){
        if($this->end_time != null){
            return $this->formatDate($this->end_time);
        }

        return null;
    }

    public function formatDate($date){
        return $date->format('m/d/Y h:i:s A');
    }
}
