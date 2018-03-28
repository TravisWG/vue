<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
