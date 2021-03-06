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
        'name', 'email', 'password',
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

    // public function isAdmin()
    // {
    //     if ($this->role == 1) return true;
    //     return false;
    // }

    // public function isUser()
    // {
    //     if ($this->role == 2) return true;
    //     return false;
    // }

    public function role(){
        return $this->belongsTo(Role::class,'id');
    }
    public function hasRole($role){
        if($this->role->nama_role == $role){
            return true;
        }
    }
}
