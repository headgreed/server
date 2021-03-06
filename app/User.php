<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'ori_name', 'name', 'email', 'password', 'gender', 'avatar', 'api_token', 'location', 'about'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'ori_name'
    ];

    public function facebook()
    {
        return $this->hasOne(\App\SocialAccount::class)->where('provider', 'facebook');
    }

    public function posts()
    {
        return $this->hasMany(\App\Post::class);
    }
}
