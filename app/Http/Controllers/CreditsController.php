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
            'daily' => ['required', 'regex:/21|28|42|56/'],
            'period' => ['required', 'regex:/1|7|14|28/'],
        ]);

        $expiration_date = Carbon::now();

        $credit = new Credit;

        $credit->client_id = $validated['client_id'];
        $credit->seller_id = auth()->user()->id;
        $credit->money = $validated['money'];
        $credit->interest_rate = ($validated['interest_rate'] / 28) * $request['daily'];
        $credit->period = $validated['period'] == 1 ? $validated['daily'] : $validated['period'];
        $credit->profit = ($validated['money'] * $credit->interest_rate) / 100;
        $credit->expiration_date = $expiration_date->addDays($validated['daily']);

        $credit->save();
        
        if($validated['period'] == 1) {
            switch($validated['daily']) {
                case 21:
                    $shares = 21 - 6;
                    break;
                case 28:
                    $shares = 28 - 8;
                    break;
                case 42:
                    $shares = 42 - 12;
                    break;
                case 56:
                    $shares = 56 - 16;
            }
        } else {
            $shares = $validated['daily'] / $credit->period;
        }

            $share_expiration =  Carbon::now();
            $today = Carbon::now();
        for($i = 0; $i < $shares; $i++) {
            if($i == 0) {
                if($today->isoFormat('dddd') == 'Saturday' || $today->isoFormat('dddd') == 'Sunday') {
                    while($share_expiration->isoFormat('dddd') == 'Saturday' || $share_expiration->isoFormat('dddd') == 'Sunday') {
                        $share_expiration->addDays($validated['period']);
                    }
                }
            } else {
                do {
                    $share_expiration->addDays($validated['period']);
                } while($share_expiration->isoFormat('dddd') == 'Saturday' || $share_expiration->isoFormat('dddd') == 'Sunday');
            }

            $share = new Share();
            $share->credit_id = $credit->id;
            $share->money = ceil(($credit->money + $credit->profit) / $shares);
            $share->expiration_date = $share_expiration;
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
