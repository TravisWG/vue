<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskComments extends Model
{
    use SoftDeletes;

    protected $table = "task_comments";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
        'is_edited'
    ];
}
