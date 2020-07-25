<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Please add this line JWT
use Tymon\JWTAuth\Contracts\JWTSubject;

// Please implement JWTSubject interface
class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name', 'email', 'password', 'role_id'
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

    /**
     * Add This Method for JWT
     *
     * @var JWT
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Add This Method for JWT
     *
     * @var JWT
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
