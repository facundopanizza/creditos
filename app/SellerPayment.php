<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerPayment extends Model
{
    protected $guarded = [];

    public function seller() {
        return $this->belongsTo('App\User', 'seller_id');
    }
}
