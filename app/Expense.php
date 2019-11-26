<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $guarded = [];

    public function seller() {
        return $this->belongsTo('App\User', 'seller_id');
    }
    public function credit() {
        return $this->belongsTo('App\Credit');
    }

    public function payment() {
        return $this->belongsTo('App\SharePayment', 'sharePayment_id');
    }

    public function allocation() {
        return $this->belongsTo('App\CashAllocation', 'cashAllocation_id');
    }
}