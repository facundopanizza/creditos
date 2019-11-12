<?php

namespace App\Http\Controllers;

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
            $share->share_cancelled = true;
            $share->save();
            SharePayment::create([
                'share_id' => $share->id,
                'payment_amount' => $validated['payment_amount']
            ]);
        } else {
            SharePayment::create([
                'share_id' => $share->id,
                'payment_amount' => $validated['payment_amount']
            ]);
        }

        $id = $share->credit->id;
        
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
