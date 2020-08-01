<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Based on this project's scope and seeded user data
     * Assigned a default integer value of 1 to be the default user ID
     * 
     * @var integer
     */
    const DEFAULT_USER_ID = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email_verified_at', 'password', 'remember_token', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * This returns DEFAULT_USER_ID
     *
     * @var integer
     */
    public static function getDefaultUserId()
    {
        return User::DEFAULT_USER_ID;
    }

}
