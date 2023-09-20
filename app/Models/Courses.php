<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    //
    protected $fillable=['school_id','course_name','course_id'];

    public function schools() {
    	return $this->belongsTo('App\Schools');
    }

    public function classrooms() {
    	return $this->belongsTo('App\classrooms');
    }

    public function marks() {
    	return $this->hasMany('App\Marks','course_id');
    }

    public function out_of_marks() {
    	return $this->hasMany('App\Out_of_marks','course_id');
    }

    public function designated_teachers() {
    	return $this->hasMany('App\designated_teachers');
    }


}
