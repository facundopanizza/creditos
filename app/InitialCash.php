<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InitialCash extends Model
{
    protected $guarded = [];

    public function closeDay() {
        return $this->has('App\CloseDay', 'closeDay_id');
    }
}
