<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $table = "tasks";

    protected $fillable = [
        'completed',
        'task',
        'tasklist_id'
    ];

    public function tasklist() {
    	return $this->belongsTo('App\Tasklist');
    }

    public function formatCompletedAtDate(){
        return Carbon::parse($this->completed_at)->format('m/d/Y h:i:s A');
    }
}
