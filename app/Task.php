<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks";

    protected $fillable = [
        'completed',
        'task',
    ];

    public function tasklist() {
    	return $this->hasOne('App\Tasklist');
    }

    public function user() {
    	return $this->tasklist()->user();
    }
}
