<?php

namespace App\Http\Controllers;

use App\Share;
use App\Client;
use App\Credit;
use App\Expense;
use App\SharePayment;
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
		if(Auth::user()->id != $client->seller_id && Auth::user()->role != 'admin') {
			return redirect()->back();
        }
        
        if(!empty($client->credits->first()) && $client->cancel_with_other_credit == 1)
        {
            $credits = collect();

            foreach($client->credits as $credit)
            {
                if($credit->credit_cancelled == 0)
                {
                    $credits->add($credit);
                }
            }

            return view('credits.create', ['client' => $client, 'credits' => $credits]);
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
        ]);

        $client = Client::find($validated['client_id']);

        if(Auth::user()->wallet < $validated['money']) {
			$validator = Validator::make([], []);
			$validator->getMessageBag()->add('money', 'El vendedor no tiene saldo suficiente para realizar este credito');
			return redirect()->back()->withErrors($validator)->withInput();
        }

		if($client->maximum_credit < $validated['money']) {
			$validator = Validator::make([], []);
			$validator->getMessageBag()->add('money', 'El monto maximo de credito autorizado para este cliente es de ' . $client->maximum_credit);
			return redirect()->back()->withErrors($validator)->withInput();
		}

		if(Auth::user()->id != $client->seller_id && Auth::user()->role != 'admin') {
			return redirect()->back();
		}

        $activeCredits = $client->credits->where('credit_cancelled', 0);
        
        /* $numberOfCredits = 0; */
        /* $credits = collect(); */

        /* foreach($client->credits as $credit) { */
        /*     if($credit->credit_cancelled === 0) { */
        /*         $credits->add($credit); */
        /*         $numberOfCredits += 1; */
        /*     } */
        /* } */

        /* if($validated['money'] > $client->maximum_credit) { */
        /*     $validator = Validator::make([], []); */
        /*     $validator->getMessageBag()->add('money', 'El monto maximo de credito autorizado para este cliente es de ' . $client->maximum_credit); */
        /*     return redirect()->back()->withErrors($validator)->withInput(); */
        /* } */

        /* if(Auth::user()->wallet < $validated['money']) { */
        /*         $message = 'No tienes dinero disponible para realizar este prestamo.'; */
        /*         $validator = Validator::make([], []); */
        /*         $validator->getMessageBag()->add('money', $message); */
        /*         return redirect()->back()->withErrors($validator)->withInput()->withCredits($credits); */
        /* } */

        /* if(isset($validated['credit_to_cancel'])) { */
        /*     $debtCredit = Credit::find($validated['credit_to_cancel']); */
        /*     $debt = 0; */
        /*     foreach($debtCredit->shares as $share) { */
        /*         if($share->share_cancelled !== 1) { */
        /*             $payed = 0; */
        /*             foreach($share->payments as $payment) { */
        /*                 $payed += $payment->payment_amount; */
        /*             } */
        /*             $debt += $share->money - $payed; */
        /*         } */
        /*     } */

        /*     if($validated['money'] <= $debt) { */
        /*         $message = 'El monto a prestar es menor que la deuda del cliente.'; */
        /*         $validator = Validator::make([], []); */
        /*         $validator->getMessageBag()->add('credit_to_cancel', $message); */
        /*         return redirect()->back()->withErrors($validator)->withInput()->withCredits($credits); */
        /*     }else { */
        /*         foreach($debtCredit->shares as $share) { */
        /*             if(empty($share->payments->first())) { */
        /*                 $share->share_cancelled = 1; */
        /*                 $share->save(); */

        /*                 $sharePayment = SharePayment::create([ */
        /*                     'seller_id' => Auth::user()->id, */
        /*                     'share_id' => $share->id, */
        /*                     'payment_amount' => $share->money, */
        /*                 ]); */

        /*                 Expense::create([ */
        /*                     'seller_id' => Auth::user()->id, */
        /*                     'sharePayment_id' => $sharePayment->id, */
        /*                     'money' => $sharePayment->payment_amount, */
        /*                 ]); */

        /*                 Auth::user()->wallet += $sharePayment->payment_amount; */
        /*                 Auth::user()->save(); */
        /*             } else { */
        /*                 $payed = 0; */
        /*                 foreach($share->payments as $payment) { */
        /*                     $payed += $payment->payment_amount; */
        /*                 } */

        /*                 $debt_of_payment = $share->money - $payed; */

        /*                 $sharePayment = SharePayment::create([ */
        /*                     'seller_id' => Auth::user()->id, */
        /*                     'share_id' => $share->id, */
        /*                     'payment_amount' => $debt, */
        /*                 ]); */

        /*                 Expense::create([ */
        /*                     'seller_id' => Auth::user()->id, */
        /*                     'sharePayment_id' => $sharePayment->id, */
        /*                     'money' => $debt_of_payment, */
        /*                 ]); */

        /*                 Auth::user()->wallet += $debt_of_payment; */
        /*                 Auth::user()->save(); */
        /*             } */
        /*         } */

        /*         $credit->credit_cancelled = 1; */
        /*         $credit->save(); */
        /*     } */
        /* }else { */
        /*     if($numberOfCredits >= $client->max_simultaneous_credits) { */
        /*         $message = 'El cliente tiene  ' . $numberOfCredits . ' creditos sin terminar de pagar y no puede crear un nuevo credito.'; */
        /*         $validator = Validator::make([], []); */
        /*         $validator->getMessageBag()->add('money', $message); */
        /*         return redirect()->back()->withErrors($validator)->withInput()->withCredits($credits); */
        /*     } */
        /* } */

        $expiration_date = Carbon::now();

        $credit = new Credit;

        $credit->client_id = $validated['client_id'];
        $credit->seller_id = auth()->user()->id;
        $credit->money = $validated['money'];
        $credit->interest_rate = ($validated['interest_rate'] / 28) * $request['daily'];
        $credit->period = $validated['period'] == 1 ? $validated['daily'] : $validated['period'];
        $credit->seller_profit = (Auth::user()->commission * $credit->money) / 100;
        $credit->profit = (($validated['money'] * $credit->interest_rate) / 100) - $credit->seller_profit;
        $credit->expiration_date = $expiration_date->addDays($validated['daily']);

        $moneyCancel = 0;
        $payedCancel = 0;

        if($client->cancel_with_other_credit == 1 && $validated['cancel_credit'] != 'null')
        {
            $creditToCancel = Credit::findOrFail($validated['cancel_credit']);

            if($activeCredits->count() > 0) {
                $payed = 0;
                $creditMoney = 0;

                foreach($activeCredits as $activeCredit) {

                    foreach($activeCredit->shares as $share) {
                        $creditMoney += $share->money;

                        foreach($share->payments as $payment) {
                            $payed += $payment->payment_amount;

                            if($activeCredit->id == $validated['cancel_credit'])
                            {
                                $payedCancel += $payment->payment_amount;
                            }
                        }

                        if($activeCredit->id == $validated['cancel_credit'])
                        {
                            $moneyCancel += $share->money;
                        }
                    }
                }

                $cancel = $moneyCancel - $payedCancel;
                $debt = $creditMoney - $payed;
                $debt -= $cancel;

                if($cancel > $validated['money'])
                {
                    $validator = Validator::make([], []);
                    $validator->getMessageBag()->add('money', 'El monto prestado debe ser mayor a la deuda del credito a cancelar');
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                if(($debt + $validated['money'] + $credit->seller_profit + $credit->profit) > $client->maximum_credit) {
                    $validator = Validator::make([], []);
                    $validator->getMessageBag()->add('money', 'Ingrese un Monto menor a Prestar o aumente el limite total del cliente.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

            foreach($creditToCancel->shares as $share)
            {
                $share->share_cancelled = 1;
                $share->save();

                if(empty($share->payments->first()))
                {
                    SharePayment::create([
                        'share_id' => $share->id,
                        'seller_id' => Auth::user()->id,
                        'payment_amount' => $share->money,
                    ]);
                } else {
                    $payed = 0;

                    foreach($share->payments as $payment)
                    {
                        $payed += $payment->payment_amount;
                    }

                    if($payed < $share->money)
                    {
                        SharePayment::create([
                            'share_id' => $share->id,
                            'seller_id' => Auth::user()->id,
                            'payment_amount' => $share->money - $payed,
                        ]);
                    }
                }
            }

            $creditToCancel->credit_cancelled = 1;
            $creditToCancel->save();

            $share_expiration =  Carbon::now();
            if($validated['period'] == 1) {
                $shares = $validated['daily'];
                $share_expiration->addDays(1);
                /* switch($validated['daily']) { */
                /*     case 21: */
                /*         $shares = 21 - 6; */
                /*         break; */
                /*     case 28: */
                /*         $shares = 28 - 8; */
                /*         break; */
                /*     case 42: */
                /*         $shares = 42 - 12; */
                /*         break; */
                /*     case 56: */
                /*         $shares = 56 - 16; */
                /* } */
            } else {
                $shares = $validated['daily'] / $credit->period;

                switch($validated['period']) {
                    case 7:
                        $share_expiration->addDays(7);
                    break;
                    case 14:
                        $share_expiration->addDays(14);
                    break;
                    case 28:
                        $share_expiration->addDays(28);
                    break;
                }
            }

            $credit->shares_numbers = $shares;
            $credit->save();

            $today =  Carbon::now();
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
                $share->money = ceil(($credit->money + $credit->profit + $credit->seller_profit) / $shares);
                $share->expiration_date = $share_expiration;
                $share->share_number = $i + 1;
                $share->save();
            }

            $credit->expiration_date = $credit->shares->last()->expiration_date;
            $credit->money_to_give = $validated['money'] - $cancel;
            $credit->save();

            Auth::user()->wallet -= $credit->money;
            Expense::create([
                'seller_id' => Auth::user()->id,
                'credit_id' => $credit->id,
                'money' => $credit->money
            ]);
            Auth::user()->save();

            return redirect("/credits/$credit->id");
        }

        if($client->multi_credit == 0)
        {
            if(!empty($client->credits->first()))
            {
                foreach($client->credits as $credit)
                {
                    if($credit->credit_cancelled == 0)
                    {
                        $validator = Validator::make([], []);
                        $validator->getMessageBag()->add('money', 'Este cliente no puede tener multiples creditos activos, pedir a un admin habilitacion.');
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                }
            }
        }

		if($activeCredits->count() > 0) {
			$payed = 0;
			$creditMoney = 0;

			foreach($activeCredits as $activeCredit) {
				$creditMoney += $activeCredit->money;
				$creditMoney += $activeCredit->profit + $activeCredit->seller_profit;

				foreach($activeCredit->shares as $share) {
					foreach($share->payments as $payment) {
						$payed += $payment->payment_amount;
					}
				}
			}

			$debt = $creditMoney - $payed;

			if(($debt + $validated['money']) > $client->maximum_credit) {
				$validator = Validator::make([], []);
				$validator->getMessageBag()->add('money', 'El cliente ya tiene otros creditos activos y la suma total de los creditos supera el limite de prestamo de este cliente.');
				return redirect()->back()->withErrors($validator)->withInput();
			}
		}


        $share_expiration =  Carbon::now();
        if($validated['period'] == 1) {
			$shares = $validated['daily'];
            $share_expiration->addDays(1);
            /* switch($validated['daily']) { */
            /*     case 21: */
            /*         $shares = 21 - 6; */
            /*         break; */
            /*     case 28: */
            /*         $shares = 28 - 8; */
            /*         break; */
            /*     case 42: */
            /*         $shares = 42 - 12; */
            /*         break; */
            /*     case 56: */
            /*         $shares = 56 - 16; */
            /* } */
        } else {
            $shares = $validated['daily'] / $credit->period;

            switch($validated['period']) {
                case 7:
                    $share_expiration->addDays(7);
                break;
                case 14:
                    $share_expiration->addDays(14);
                break;
                case 28:
                    $share_expiration->addDays(28);
                break;
            }
        }

        $credit->shares_numbers = $shares;
        $credit->save();

        $today =  Carbon::now();
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
            $share->money = ceil(($credit->money + $credit->profit + $credit->seller_profit) / $shares);
            $share->expiration_date = $share_expiration;
            $share->share_number = $i + 1;
            $share->save();
        }

        $credit->expiration_date = $credit->shares->last()->expiration_date;
        $credit->save();

        Auth::user()->wallet -= $credit->money;
        Expense::create([
            'seller_id' => Auth::user()->id,
            'credit_id' => $credit->id,
            'money' => $credit->money
        ]);
        Auth::user()->save();

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
		if(Auth::user()->id != $credit->client->seller_id && Auth::user()->role != 'admin') {
			return redirect()->back();
        }
        
        $payed = 0;
        if($credit->credit_cancelled == 0) {
            foreach($credit->shares as $share) {
                foreach($share->payments as $payments) {
                    $payed += $payments->payment_amount;
                }
            }
        }
        $debt = ($credit->money + $credit->profit + $credit->seller_profit) - $payed;

        return view('credits.show', ['credit' => $credit, 'debt' => $debt]);
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
