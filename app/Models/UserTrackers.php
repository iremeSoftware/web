<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTrackers extends Model
{
    //
    protected $fillable=['account_id','ip_address','logged_in','active_time'];

    public function user()
    {
        $this->belongsTo('App\User');
    }

}
