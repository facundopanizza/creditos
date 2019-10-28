<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Share;
use App\SharePayment;

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
            'share_id' => ['unique:share_payments']
        ]);
        if($share->money - $validated['payment_amount'] !== 0.0) {
            SharePayment::create([
                'share_id' => $share->id,
                'fee_cancelled' => false,
                'payment_amount' => $validated['payment_amount']
            ]);
        } else {
            SharePayment::create([
                'share_id' => $share->id,
                'fee_cancelled' => true,
                'payment_amount' => $validated['payment_amount']
            ]);
        }
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
