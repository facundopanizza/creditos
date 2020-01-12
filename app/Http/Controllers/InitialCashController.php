<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\InitialCash;
use App\CashEntry;
use App\Credit;
use App\Expense;
use App\SharePayment;
use App\User;
use App\CloseDay;
use App\ExpensesBox;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InitialCashController extends Controller
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

        $initialCash = InitialCash::all()->last();

		if(!empty($initialCash)) {
			if($initialCash->active === 0) {
				$initialCash = null;
			}
		}

        return view('initial_cash.index')->withInitialCash($initialCash);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $validated = $request->validate([
            'entry_money' => ['required', 'numeric']
        ]);

        InitialCash::create([
            'user_id' => auth()->user()->id,
            'entry_money' => $validated['entry_money'],
            'money' => $validated['entry_money'],
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InitialCash  $initialCash
     * @return \Illuminate\Http\Response
     */
    public function show(InitialCash $initialCash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InitialCash  $initialCash
     * @return \Illuminate\Http\Response
     */
    public function edit(InitialCash $initialCash)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InitialCash  $initialCash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InitialCash $initialCash)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InitialCash  $initialCash
     * @return \Illuminate\Http\Response
     */
    public function destroy(InitialCash $initialCash)
    {
        //
    }

    public function cashEntry() {
        $users = User::all();
        $sellers = collect();

        foreach($users as $user) {
            if($user->wallet != 0) {
                $sellers->add($user);
            }
        }

        return view('initial_cash.cashEntry')->withSellers($sellers);
    }

    public function cashEntryStore(Request $request) {
		$initialCash = InitialCash::all()->last();

        foreach($request->sellers as $seller) {
            $user = User::find($seller);
            $initialCash = InitialCash::all()->last();

            $cash_entry = CashEntry::create([
                'seller_id' => $user->id,
                'initialCash_id' => $initialCash->id,
                'money' => $user->wallet,
            ]);

            $user->wallet = 0;
            $user->save();

            $lastCash = InitialCash::where('active', '=', 1)->get()->last();
            $expense = ExpensesBox::create([
                'seller_id' => $user->id,
                'cashEntries_id' => $cash_entry->id,
                'money' => $cash_entry->money
            ]);
            $lastCash->money += $expense->money;

            $initialCash->money += $cash_entry->money;
            $initialCash->save();
        }

        return redirect('/');
    }

	public function individualCashEntryStore(User $user)
	{
		if($user->wallet == 0) {
			return redirect()->back();
        }

		$initialCash = InitialCash::all()->last();

		$cash_entry = CashEntry::create([
			'seller_id' => $user->id,
			'initialCash_id' => $initialCash->id,
			'money' => $user->wallet,
        ]);

        $expense = ExpensesBox::create([
            'seller_id' => $user->id,
            'cashEntries_id' => $cash_entry->id,
            'money' => $cash_entry->money
        ]);

		$user->wallet = 0;
		$user->save();

		$initialCash->money += $cash_entry->money;
		$initialCash->save();

		return redirect('/cash_entries');
	}
    
    public function closeDay() {
        $users = User::all();

        $lastDay = InitialCash::all()->last();
        if($lastDay === null || $lastDay->active === 0) {
            return redirect()->back();
        }

        foreach($users as $user) {
            if($user->wallet != 0) {
                $validator = Validator::make([], []);
                $validator->getMessageBag()->add('cerrar', 'No puedes cerrar la caja sin terminar de recibir el dinero pendiente');
                return redirect('cash_entries')->withErrors($validator);
            }
        }

        $initialCash = InitialCash::all()->last();
        $credits = Credit::whereDate('created_at', Carbon::today())->get();
        $payments = SharePayment::whereDate('created_at', Carbon::today())->get();
        $exps = Expense::whereDate('created_at', Carbon::today())->get();
        
        $expenses = 0;
        foreach($exps as $exp) {
            if($exp->description !== null) {
                $expenses += $exp->money;
            }
        }

        $moneyFromPayments = 0;
        foreach($payments as $payment) {
            $moneyFromPayments += $payment->payment_amount;
        }

        $moneyFromCredits = 0;
        foreach($credits as $credit) {
            $moneyFromCredits += $credit->money;
        }

        return view('initial_cash.closeDay', [
            'moneyFromCredits' => $moneyFromCredits,
            'moneyFromPayments' => $moneyFromPayments,
            'initialCash' => $initialCash,
            'expenses' => $expenses,
        ]);
    }

    public function closeDayStore()
    {
        $lastDay = InitialCash::all()->last();
        if($lastDay === null || $lastDay->active === 0) {
            return redirect()->back();
        }

        $closeDay = CloseDay::create([
            'initialCash_id' => $lastDay->id,
            'money' => $lastDay->money,
        ]);

        $lastDay->closeDay_id = $closeDay->id;
        $lastDay->active = 0;
        $lastDay->save();

        return redirect('/');
    }

    public function closedDays()
    {
        $closed_days = CloseDay::all();

        return view('initial_cash.closed_days', ['closed_days' => $closed_days]);
    }

    public function addMoney()
    {
        return view('initial_cash.add_money');
    }

	public function addMoneyStore(Request $request)
	{
        $validated = $request->validate([
            'money' => ['required', 'integer']
        ]);


        $initialCash = InitialCash::all()->last();
        
        $user = Auth::user();

		$cash_entry = CashEntry::create([
			'seller_id' => $user->id,
			'initialCash_id' => $initialCash->id,
			'money' => $validated['money'],
        ]);

        $expense = ExpensesBox::create([
            'seller_id' => $user->id,
            'cashEntries_id' => $cash_entry->id,
            'money' => $cash_entry->money,
            'description' => 'Plata agregada a caja',
        ]);

		$initialCash->money += $cash_entry->money;
		$initialCash->save();

		return redirect('/initial_cash');
	}
}
