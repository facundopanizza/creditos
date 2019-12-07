<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloseDay extends Model
{
    protected $guarded = [];

    public function initialCash() {
        return $this->belongsTo('App\InitialCash', 'initialCash_id');
    }
}
