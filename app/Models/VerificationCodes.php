<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCodes extends Model
{
    //
    protected $fillable=['account_id','verification_code'];

    public function user()
    {
        $this->belongsTo('App\User');
    }
}
