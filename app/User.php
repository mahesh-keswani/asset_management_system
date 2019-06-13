<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'role','company','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function assets()
    {
       return $this->hasMany('App\Asset'); 
    }
    public function stocks()
    {
       return $this->hasMany('App\Stock'); 
    }
    public function inventories()
    {
       return $this->hasMany('App\Inventory'); 
    }
    
}
