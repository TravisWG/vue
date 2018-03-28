<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasklist extends Model
{
    protected $table = "tasklists";

    protected $fillable = [
        'user_id',
        'tasklist_id'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function tasks() {
    	return $this->hasMany('App\Task');
    }

}
