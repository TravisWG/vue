<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tasklist() {
        return $this->hasOne('App\Tasklist');
    }

    public function tasks() {
        return $this->hasManyThrough('App\Task', 'App\Tasklist');
    }

    public function colleagueRelationships() {
        return $this->hasMany('App\Colleague', 'user_id', 'id');
    }

    public function colleagues() {
        return $this->hasManyThrough('App\User', 'App\Colleague','id', 'id', 'id', 'colleague_id');
    }
}
