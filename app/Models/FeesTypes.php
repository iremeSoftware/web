<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeesTypes extends Model
{
    //
    protected $fillable=[
        'school_id','class_id','fees_id','fees_name'];

    public function schools()
    {
    	$this->belongTo('App\Schools');
    }

    public function classrooms()
    {
    	$this->belongTo('App\classrooms');
    }
}
