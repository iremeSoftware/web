<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Students extends Model
{
    //
    protected $table="students";

    protected $fillable=['school_id','student_id','name','student_sex','classroom','fathers_name','mothers_name','mothers_phone','fathers_phone','priority_phone','parent_email','fathers_ID','mothers_ID','location_district','location_sector','location_cell','location_village','sms_credits','deleted','registered_by'];

    protected $hidden = [
        'deleted', 'registered_by',
    ];


    public function schools()
    {
    	$this->belongsTo('App\Schools');
    }

    public function bank_slips()
    {
    	$this->hasMany('App\bank_slips','student_id');
    }


    public function classrooms()
    {
    	$this->belongsTo('App\classrooms');
    }

    public function designated_parents()
    {
    	$this->hasOne('App\designated_parents','student_id');
    }

    public function discipline()
    {
    	$this->hasOne('App\Discipline');
    }

    public function marks()
    {
    	$this->hasMany('App\Marks');
    }

    public function schoolfees()
    {
    	$this->hasOne('App\Schoolfees');
    }

    public function student_attendances()
    {
        $this->hasMany('App\student_attendances');
    }
}
