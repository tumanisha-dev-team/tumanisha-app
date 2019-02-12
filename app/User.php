<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Yadahan\AuthenticationLog\AuthenticationLogable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TaylorNetwork\UsernameGenerator\Generator;

class User extends Authenticatable
{
    use Notifiable, AuthenticationLogable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'user_role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAvatarAttribute(){
        return '/dashboard/img/profile-photos/2.png';
    }
}
