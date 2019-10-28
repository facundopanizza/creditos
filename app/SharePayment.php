<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharePayment extends Model
{
    protected $guarded = [];

    public function share() {
        return $this->belongsTo('App\Share');
    }
}
