<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_role extends Model
{
    //
    protected $fillable=['school_id','account_id','user_role'];

    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function schools()
    {
        $this->belongsTo('App\Schools');
    }
}
