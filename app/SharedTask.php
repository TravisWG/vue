<?php

namespace App;

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
}
