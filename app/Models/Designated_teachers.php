<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designated_teachers extends Model
{
    //
    protected $fillable=['school_id','teacher_id','classroom_name','course_name'];

    public function schools() {
    	return $this->belongsTo('App\Schools');
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function courses() {
    	return $this->hasMany('App\Courses','course_id');
    }

    public function classrooms() {
    	return $this->hasMany('App\classrooms','class_id');
    }
}
