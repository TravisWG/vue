<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colleague extends Model
{
    protected $table = "colleagues";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'colleague_id',
        'blocked'
    ];

    public function colleague_user(){
    	return $this->hasOne('App\User', 'id', 'colleague_id');
    }
}
