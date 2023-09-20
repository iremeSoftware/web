<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class classrooms extends Model
{
    //
    protected $table="classrooms";
    
    protected $fillable=['school_id','class_id','classroom_representative','classroom_name'];



    public function schools() {
    	return $this->belongsTo('App\Schools');
    }

    public function displine() {
    	return $this->hasMany('App\Displine','class_id');
    }

    public function file_managers() {
    	return $this->hasMany('App\file_managers','class_id');
    }

    public function marks() {
    	return $this->hasMany('App\Marks','class_id');
    }

    public function out_of_marks() {
    	return $this->hasMany('App\Out_of_marks','class_id');
    }

    public function schoolfees() {
    	return $this->hasMany('App\Schoolfees','class_id');
    }

    public function students() {
    	return $this->hasMany('App\Students');
    }
}
