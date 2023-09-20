<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class designated_parents extends Model
{
    //
    protected $table="designated_parents";

    protected $fillable=['school_id','parent_id','student_id'];

    public function schools() {
    	return $this->belongsTo('App\Schools');
    }

    public function classrooms() {
    	return $this->belongsTo('App\classrooms');
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }


    public function students() {
    	return $this->hasOne('App\Students','student_id');
    }

}
