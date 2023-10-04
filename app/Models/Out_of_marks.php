<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Out_of_marks extends Model
{
    //
    protected $fillable=['academic_year','school_id','teacher_id','course_id','class_id','term1_quiz','term1_exam','term1_total_marks','term2_quiz','term2_exam','term2_total_marks','term3_quiz','term3_exam','term3_total_marks'];

    public function schools() {
    	return $this->belongsTo('App\Schools');
    }

    public function classrooms() {
    	return $this->belongsTo('App\classrooms');
    }

    public function courses() {
    	return $this->belongsTo('App\Courses');
    }


    public function designated_teachers() {
    	return $this->hasOne('App\Designated_teachers','teacher_id');
    }
}
