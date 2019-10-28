<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    public function credits() {
        return $this->hasMany('App\Credit');
    }
}
