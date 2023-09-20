<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School_registration_requests extends Model
{
    //
        protected $fillable=['request_id','name','email','phone_number','school_name','scale'];

        public static function delete_request($request_id)
        {
        	# code...
        	$RegistrationRequests=School_registration_requests::where('request_id',$request_id);
            $RegistrationRequests->delete();
            return true;
        }

}
