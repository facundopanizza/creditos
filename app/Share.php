<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    public function credit() {
        return $this->belongsTo('App\Credit');
    }

    public function payments() {
        return $this->hasMany('App\SharePayment');
    }
}
