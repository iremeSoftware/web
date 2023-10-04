<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bank_slips extends Model
{
    //
    protected $fillable=['school_id','account_id','student_id','bank_slip_photo','seen'];

    public function schools() {
    	return $this->belongsTo('App\Schools');
    }

    public function classrooms() {
    	return $this->belongsTo('App\classrooms');
    }


    public function students() {
    	return $this->belongsTo('App\Students');
    }

    public function designated_parents() {
    	return $this->belongsTo('App\designated_parents');
    }
}
