<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    //
    protected $fillable=['academic_year','school_id','class_id','student_id','first_term','second_term','third_term'];


    public function schools()
    {
    	$this->belongTo('App\Schools');
    }

    public function classrooms()
    {
    	$this->belongTo('App\classrooms');
    }

    public function students() {
    	return $this->hasOne('App\Students','student_id');
    }
}
