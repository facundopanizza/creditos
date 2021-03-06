<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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

    public function credits() {
        return $this->hasMany('App\Credit', 'seller_id');
    }

    public function cash_allocation() {
        return $this->hasMany('App\CashAllocation');
    }

    public function expenses() {
        return $this->hasMany('App\Expense', 'seller_id');
    }

    public function clients() {
        return $this->hasMany('App\Client', 'seller_id');
    }
}
