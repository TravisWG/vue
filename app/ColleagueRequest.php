<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

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

    public function sendingUser() {
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function receivingUser() {
    	return $this->hasOne('App\User', 'id', 'colleague_id');
    }
}
