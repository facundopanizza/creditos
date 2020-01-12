<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use App\Credit;
use App\CashEntry;
use Carbon\Carbon;
use App\InitialCash;
use App\SharePayment;
use App\SellerPayment;
use App\CashAllocation;
use App\CloseDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

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

    public function consult()
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $sellers = User::all();

        $clients = Client::all();

        return view('consult.index')->withSellers($sellers)->withClients($clients);
    }

    public function sellerConsult(Request $request)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $validated = $request->validate([
            'seller_id' => ['required', 'integer'],
            'search_type' => ['required', 'regex:/credits|share_payments|payments_to_seller|money_received_from_seller/'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
        ]);

        $from = Carbon::create($validated['from']);
        $to = Carbon::create($validated['to']);

        if($from > $to)
        {
			$validator = Validator::make([], []);
            $validator->getMessageBag()->add('from', 'La fecha "Desde" tiene que ser antes que "Hasta"');
			return redirect()->back()->withErrors($validator)->withInput();
        }

        switch($validated['search_type'])
        {
            case 'credits':
                $results = Credit::where('seller_id', $validated['seller_id'])->whereBetween('created_at', [$from->subdDay(), $to->addDay()])->get();
            break;
            case 'share_payments':
                $results = SharePayment::where('seller_id', $validated['seller_id'])->whereBetween('created_at', [$from->subDay(), $to->addDay()])->get();
            break;
            case 'payments_to_seller':
                $results = SellerPayment::where('seller_id', $validated['seller_id'])->whereBetween('created_at', [$from->subDay(), $to->addDay()])->get();
            break;
            case 'money_received_from_seller':
                $results = CashEntry::where('seller_id', $validated['seller_id'])->whereBetween('created_at', [$from->subDay(), $to->addDay()])->get();
            break;
        }

        return view('consult.seller')->withResults($results)->withSearchType($validated['search_type']);
    }

    public function clientConsult(Request $request)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $validated = $request->validate([
            'client_id' => ['required', 'integer'],
            'search_type' => ['required', 'regex:/credits|share_payments/'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
        ]);

        $from = Carbon::create($validated['from']);
        $to = Carbon::create($validated['to']);

        if($from > $to)
        {
			$validator = Validator::make([], []);
            $validator->getMessageBag()->add('from', 'La fecha "Desde" tiene que ser antes que "Hasta"');
			return redirect()->back()->withErrors($validator)->withInput();
        }

        switch($validated['search_type'])
        {
            case 'credits':
                $results = Credit::where('client_id', $validated['client_id'])->whereBetween('created_at', [$from->subDay(), $to->addDay()])->get();
            break;
            case 'share_payments':
                $payments = SharePayment::whereBetween('created_at', [$from->subDay(), $to->addDay()])->get();
                $results = collect();

                foreach($payments as $payment)
                {
                    if($payment->share->credit->client_id == $validated['client_id'])
                    {
                        $results->add($payment);
                    }
                }
            break;
        }

        return view('consult.seller')->withResults($results)->withSearchType($validated['search_type']);
    }

    public function closeDayConsult(Request $request)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $validated = $request->validate([
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
        ]);

        $from = Carbon::create($validated['from']);
        $to = Carbon::create($validated['to']);

        if($from > $to)
        {
			$validator = Validator::make([], []);
            $validator->getMessageBag()->add('from', 'La fecha "Desde" tiene que ser antes que "Hasta"');
			return redirect()->back()->withErrors($validator)->withInput();
        }

        $results = CloseDay::whereBetween('created_at', [$from->subDay(), $to->addDay()])->get();

        return view('consult.closed_days')->withResults($results);
    }
}