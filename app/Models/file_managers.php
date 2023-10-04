<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class file_managers extends Model
{
    //
    protected $fillable=['academic_year','school_id','department','term','class_id','student_id','file_id','file_type','file_name'];

    public function schools()
    {
    	$this->belongTo('App\Schools');
    }

    public function classrooms()
    {
    	$this->belongTo('App\classrooms');
    }

    
}
