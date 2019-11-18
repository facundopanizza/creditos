<?php

namespace App\Http\Controllers;

use App\Share;
use App\Client;
use App\Credit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $numberOfCredits = 0;
        $credits = collect();

        foreach($client->credits as $credit) {
            if($credit->credit_cancelled === 0) {
                $credits->add($credit);
                $numberOfCredits += 1;
            }
        }

        if($numberOfCredits >= $client->max_simultaneous_credits && $client->max_simultaneous_credits !== null) {
            $message = 'El cliente tiene  ' . $numberOfCredits . ' creditos sin terminar de pagar y no puede crear un nuevo credito.';
            return view('credits.create', ['client' => $client, 'credits' => $credits, 'errorMessage' => $message]);
        }

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
            'credit_to_cancel' => ['integer'],
        ]);

        $client = Client::find($validated['client_id']);

        $numberOfCredits = 0;
        $credits = collect();

        foreach($client->credits as $credit) {
            if($credit->credit_cancelled === 0) {
                $credits->add($credit);
                $numberOfCredits += 1;
            }
        }

        if($validated['money'] > $client->maximum_credit) {
            $validator = Validator::make([], []);
            $validator->getMessageBag()->add('money', 'El monto maximo de credito autorizado para este cliente es de ' . $client->maximum_credit);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if(isset($validated['credit_to_cancel'])) {
            $debtCredit = Credit::find($validated['credit_to_cancel']);
            $debt = 0;
            foreach($debtCredit->shares as $share) {
                if($share->share_cancelled !== 1) {
                    $payed = 0;
                    foreach($share->payments as $payment) {
                        $payed += $payment->payment_amount;
                    }
                    $debt += $share->money - $payed;
                }
            }

            if($validated['money'] <= $debt) {
                $message = 'El monto a prestar es menor que la deuda del cliente.';
                $validator = Validator::make([], []);
                $validator->getMessageBag()->add('credit_to_cancel', $message);
                return redirect()->back()->withErrors($validator)->withInput()->withCredits($credits);
            }else {
                foreach($debtCredit->shares as $share) {
                    $share->share_cancelled = 1;
                    $share->save();
                }

                $credit->credit_cancelled = 1;
                $credit->save();
            }
        }else {
            if($numberOfCredits >= $client->max_simultaneous_credits) {
                $message = 'El cliente tiene  ' . $numberOfCredits . ' creditos sin terminar de pagar y no puede crear un nuevo credito.';
                $validator = Validator::make([], []);
                $validator->getMessageBag()->add('credit_limit', $message);
                return redirect()->back()->withErrors($validator)->withInput()->withCredits($credits);
            }
        }

        $expiration_date = Carbon::now();

        $credit = new Credit;

        $credit->client_id = $validated['client_id'];
        $credit->seller_id = auth()->user()->id;
        $credit->money = $validated['money'];
        $credit->interest_rate = ($validated['interest_rate'] / 28) * $request['daily'];
        $credit->period = $validated['period'] == 1 ? $validated['daily'] : $validated['period'];
        $credit->profit = ($validated['money'] * $credit->interest_rate) / 100;
        $credit->expiration_date = $expiration_date->addDays($validated['daily']);

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

        $credit->shares_numbers = $shares;
        $credit->save();

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
            $share->share_number = $i + 1;
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
