<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColleagueRequest extends Model
{
    use SoftDeletes;

    protected $table = "colleague_requests";

    protected $fillable = [
        'user_id',
        'colleague_id',
        'accepted',
        'rejected',
        'blocked',
    ];
}
