<?php

namespace App\Http\Controllers;

use App\Credit;
use Carbon\Carbon;
use App\InitialCash;
use App\SharePayment;
use App\CashAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticPagesController extends Controller
{
    public function home()
    {
        $seller = Auth::user();
        $credits = $seller->credits;
        $todayShares = collect();
        $expiredShares = collect();

        foreach($credits as $credit) {
            foreach($credit->shares as $share) {
                if($share->expiration_date->isToday()) {
                    $todayShares->push($share);
                } elseif(Carbon::now()->diffInDays($share->expiration_date, false) < 0 && $share->share_cancelled === 0) {
                    $expiredShares->push($share);
                }
            }
        }

        return view('static_pages.home')->withTodayShares($todayShares)->withExpiredShares($expiredShares);
    }

    public function closeDay()
    {
        $today = Carbon::today();

        $initial_cash = InitialCash::whereDate('created_at', $today)->first();
        $share_payments = SharePayment::whereDate('created_at', $today)->get();
        $credits = Credit::whereDate('created_at', $today)->get();

        $payed = 0;
        foreach($share_payments as $share_payment) {
            $payed += $share_payment->payment_amount;
        }

        $borrowed = 0;        
        foreach($credits as $credit) {
            $borrowed += $credit->money;
        }

        return view('static_pages.closeDay', [
            'initial_cash' => $initial_cash,
            'payed' => $payed,
            'borrowed' => $borrowed,
        ]);
    }
}
