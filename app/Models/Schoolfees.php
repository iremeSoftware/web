<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schoolfees extends Model
{
    //
    protected $fillable=['academic_year','school_id','class_id','student_id','to_be_paid1','amount_term1','status1','to_be_paid2','amount_term2','status2','to_be_paid3','amount_term3','status3'];

    public function schools() {
    	return $this->belongsTo('App\Schools');
    }

    public function classrooms() {
    	return $this->belongsTo('App\classrooms');
    }

    public function students() {
    	return $this->hasOne('App\Students','student_id');
    }

}
