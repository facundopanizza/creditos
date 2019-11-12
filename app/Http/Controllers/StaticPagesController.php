<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
}
