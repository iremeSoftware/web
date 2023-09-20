<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens; // include this


class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table="users";
    protected $primarykey="account_id";



    protected $fillable = [
        'user_type','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function designated_parents()
    {
        return $this->hasMany('App\designated_parents');
    }

    public function designated_teachers()
    {
        return $this->hasMany('App\Designated_teachers');
    }

   

    public function user_authentications()
    {
        return $this->hasMany('App\User_authentications');
    }

    public function user_role()
    {
        return $this->hasMany('App\user_role');
    }

    public function usertrackers()
    {
        return $this->hasOne('App\UserTrackers');
    }

     public function verificationcodes()
    {
        return $this->hasOne('App\VerificationCodes');
    }
}
