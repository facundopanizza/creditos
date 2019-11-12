<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $dates = ['expiration_date'];

    public function credit() {
        return $this->belongsTo('App\Credit');
    }

    public function payments() {
        return $this->hasMany('App\SharePayment');
    }
}
