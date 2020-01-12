<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $guarded = [];
    public function seller() {
        return $this->belongsTo('App\User', 'seller_id');
    }

    public function client() {
        return $this->belongsTo('App\Client');
    }

    public function shares() {
        return $this->hasMany('App\Share');
    }
}