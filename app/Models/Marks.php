<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    //
    protected $fillable=['academic_year','school_id','student_id','course_id','teacher_id','class_id','term1_quiz','term1_exam','term1_total_marks','term2_quiz','term2_exam','term2_total_marks','term3_quiz','term3_exam','term3_total_marks'];

    public function schools() {
    	return $this->belongsTo('App\Schools');
    }

    public function classrooms() {
    	return $this->belongsTo('App\classrooms');
    }

    public function courses() {
    	return $this->belongsTo('App\Courses');
    }

    public function students() {
    	return $this->belongsTo('App\Students');
    }

    public function designated_teachers() {
    	return $this->belongsTo('App\Designated_teachers');
    }
}
