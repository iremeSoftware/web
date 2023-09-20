<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    //
    protected $fillable=['account_id','token','token_expiry'];

    public function user()
    {
    	$this->belongsTo('App\User');
    }
}
