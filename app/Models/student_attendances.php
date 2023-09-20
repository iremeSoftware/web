<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student_attendances extends Model
{
    //
    protected $fillable=['school_id','class_id','student_id','year','month','status'];

    public function student_attendances()
    {
    	$this->belongsTo('App\Students');
    }
}
