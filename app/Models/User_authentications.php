<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_authentications extends Model
{
    //
    protected $table="user_authentications";
    protected $primarykey="account_id";



    protected $fillable=['account_id','school_id','authentications'];


    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function schools()
    {
        $this->belongsTo('App\Schools');
    }

}
