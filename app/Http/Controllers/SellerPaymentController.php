<?php

namespace App\Http\Controllers;

use App\User;
use App\SharePayment;
use App\SellerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $payments = SellerPayment::all();

        return view('seller_payment.index')->withPayments($payments->reverse());
    }

    public function payToUsers()
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $users = User::all();

        foreach($users as $user)  {
            $lastSellerPayment = SellerPayment::where('seller_id', $user->id)->get()->last();

            if(empty($lastSellerPayment)) {
                $payments = SharePayment::all();
            } else {
                $payments = SharePayment::where('created_at', '>', $lastSellerPayment->created_at)->get();
            }

            if(empty($payments)) {
                return redirect()->back();
            }

            foreach($payments as $payment)
            {
                $user->payment += $payment->payment_amount;
            }

            $user->payment = $user->payment * $user->commission / 100;
        }

        $users->sortByDesc('payment');

        return view('seller_payment.pay_to_users')->withSellers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $lastSellerPayment = SellerPayment::where('seller_id', $user->id)->get()->last();

        if(empty($lastSellerPayment)) {
            $payments = SharePayment::all();
        } else {
            $payments = SharePayment::where('created_at', '>', $lastSellerPayment->created_at)->get();
        }

        if(empty($payments)) {
            return redirect()->back();
        }

        foreach($payments as $payment)
        {
            $user->payment += $payment->payment_amount;
        }

        $user->payment = $user->payment * $user->commission / 100;

        $user->payments = $payments;

        return view('seller_payment.create')->withSeller($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $lastSellerPayment = SellerPayment::where('seller_id', $user->id)->get()->last();

        if(empty($lastSellerPayment)) {
            $payments = SharePayment::all();
        } else {
            $payments = SharePayment::where('created_at', '>', $lastSellerPayment->created_at)->get();
        }

        if(empty($payments->first())) {
            return redirect()->back();
        }

        foreach($payments as $payment)
        {
            $user->payment += $payment->payment_amount;
        }

        $user->payment = $user->payment * $user->commission / 100;

        $sellerPayment = SellerPayment::create([
            'seller_id' => $user->id,
            'money' => $user->payment,
        ]);

        return view('seller_payment.payed')->withSeller($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SellerPayment  $sellerPayment
     * @return \Illuminate\Http\Response
     */
    public function show(SellerPayment $sellerPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SellerPayment  $sellerPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(SellerPayment $sellerPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SellerPayment  $sellerPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SellerPayment $sellerPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SellerPayment  $sellerPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SellerPayment $sellerPayment)
    {
        //
    }
}
