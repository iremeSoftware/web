<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    //
    protected $fillable=['school_name','school_id','school_representative','school_email','school_phone_number','school_district','school_sector','enabled','license_key_activated','logo','school_motto'];

    public function bank_slips() {
    	return $this->hasMany('App\bank_slips','school_id');
    }

    public function classrooms() {
    	return $this->hasMany('App\classrooms','school_id');
    }

    public function courses() {
    	return $this->hasMany('App\Courses','school_id');
    }

    public function designated_parents() {
    	return $this->hasMany('App\designated_parents','school_id');
    }

    public function designated_teachers() {
    	return $this->hasMany('App\Designated_teachers','school_id');
    }

    public function discipline() {
    	return $this->hasMany('App\Descipline','school_id');
    }

    public function file_managers() {
    	return $this->hasMany('App\file_managers','school_id');
    }

    public function license_keys() {
    	return $this->hasOne('App\license_keys','school_id');
    }

    public function license_requests() {
    	return $this->hasMany('App\license_requests','school_id');
    }

    public function marks() {
    	return $this->hasMany('App\Marks','school_id');
    }

    public function out_of_marks() {
    	return $this->hasMany('App\Out_of_marks','school_id');
    }

    public function schoolfees() {
    	return $this->hasMany('App\Schoolfees','school_id');
    }

    public function sms_requests() {
    	return $this->hasMany('App\sms_requests','school_id');
    }

    public function students() {
    	return $this->hasMany('App\Students','school_id');
    }

    public function user_authentications() {
    	return $this->hasMany('App\User_authentications','school_id');
    }


    public function user_role() {
    	return $this->hasMany('App\user_role','school_id');
    }
}
