<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SharedTask extends Model
{
    use SoftDeletes;

    protected $table = "shared_tasks";

    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'user_id',
    	'parent_task_id',
    ];

    public function parentTask() {
        return $this->hasOne('App\Task', 'id', 'parent_task_id');
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function checkOwnership() {
        if($this->user == Auth::user()) {
            return true;
        }
        return false;
    }
}
