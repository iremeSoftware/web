<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class license_requests extends Model
{
    //
    protected $fillable=['school_id','request_id','days','price','done_by','phone_number','activated','license_key'];


    public function schools()
    {
        $this->belongTo('App\Schools');
    }


}
