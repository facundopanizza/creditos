<?php


namespace App\Http\Controllers;

use App\Expense;
use App\Share;
use App\SharePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SharePaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Share $share)
    {
		if(Auth::user()->id != $share->credit->client->seller_id && Auth::user()->role != 'admin') {
			return redirect()->back();
		}

        if($share->share_cancelled == 1) {
            return redirect()->back();
        }

        return view('share_payments.create', ['share' => $share]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Share $share, Request $request)
    {
		if(Auth::user()->id != $share->credit->client->seller_id && Auth::user()->role != 'admin') {
			return redirect()->back();
		}

        $validated = $request->validate([
            'payment_amount' => ['required'],
        ]);

        $id = $share->credit->id;

        if($share->share_cancelled == 1) {
            return redirect("/credits/$id");
        }

        if($share->payments->count() != 0) {
            $payed = 0;

            foreach($share->payments as $payment) {
                $payed += $payment->payment_amount;
            }
        } else {
            $payed = 0;
        }

        if(($share->money) - ($validated['payment_amount'] + $payed) == 0) {
            $sharePayment = SharePayment::create([
                'share_id' => $share->id,
                'seller_id' => Auth::user()->id,
                'payment_amount' => $validated['payment_amount']
            ]);
            $share->share_cancelled = true;
            $share->save();
        } else {
            $sharePayment = SharePayment::create([
                'share_id' => $share->id,
                'seller_id' => Auth::user()->id,
                'payment_amount' => $validated['payment_amount']
            ]);
        }

        $cancelled = true;
        foreach($share->credit->shares as $share_each) {
            if($share_each->share_cancelled == 0) {
                $cancelled = false;
            }
        }

        if($cancelled === true) {
            $share->credit->credit_cancelled = 1;
            $share->credit->save();
        }

        $id = $share->credit->id;

        Expense::create([
            'seller_id' => Auth::user()->id,
            'sharePayment_id' => $sharePayment->id,
            'money' => $sharePayment->payment_amount,
        ]);
        Auth::user()->wallet += $sharePayment->payment_amount;
        Auth::user()->save();
        
        return redirect("/credits/$id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
