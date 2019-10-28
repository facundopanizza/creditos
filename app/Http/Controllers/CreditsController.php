<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Client;
use App\Share;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CreditsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $credits = Credit::all();

        return view('credits.index', ['credits' => $credits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {
        return view('credits.create', ['client' => $client]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'integer'],
            'money' => ['required', 'numeric'],
            'interest_rate' => ['required', 'numeric'],
            'period' => ['required', 'regex:/30|4|2|1/'],
        ]);

        $expiration_date = Carbon::now();

        $credit = new Credit;

        $credit->client_id = $validated['client_id'];
        $credit->seller_id = auth()->user()->id;
        $credit->money = $validated['money'];
        $credit->interest_rate = $validated['interest_rate'];
        $credit->period = $validated['period'];
        $credit->profit = ($validated['money'] * $validated['interest_rate']) / 100;
        $credit->expiration_date = $expiration_date->addDays(30);

        $credit->save();

        for($i = 0; $i < $credit->period; $i++) {
            $share = new Share();
            $share->credit_id = $credit->id;
            $share->money = ($credit->money + $credit->profit) / $credit->period;
            $share->save();
        }

        return redirect("/credits/$credit->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function show(Credit $credit)
    {
        return view('credits.show', ['credit' => $credit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function edit(Credit $credit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Credit $credit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Credit  $credit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Credit $credit)
    {
        //
    }
}
