<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = "tasks";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'completed',
        'task',
        'tasklist_id',
        'edit'
    ];

    public function tasklist() {
    	return $this->belongsTo('App\Tasklist');
    }

    public function formatDate($date){
        return Carbon::parse($date)->format('m/d/Y h:i:s A');
    }
}
