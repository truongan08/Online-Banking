<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * Thuoc tinh co the duoc gan
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','image','username',
    ];

    /**
     * Thuoc tinh bi an
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
