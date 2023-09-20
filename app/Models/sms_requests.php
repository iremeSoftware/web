<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sms_requests extends Model
{
    //
    protected $fillable=['school_id','request_id','number_of_sms','price','phone_number','account_id','activated'];

    public function schools() {
    	return $this->belongsTo('App\Schools');
    }

}
