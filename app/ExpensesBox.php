<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpensesBox extends Model
{
    protected $guarded = [];

    public function seller() {
        return $this->belongsTo('App\User', 'seller_id');
    }
    public function cashEntry() {
        return $this->belongsTo('App\CashEntry', 'cashEntries_id');
    }

    public function cashAllocation() {
        return $this->belongsTo('App\cashAllocation', 'cashAllocation_id');
    }
}
