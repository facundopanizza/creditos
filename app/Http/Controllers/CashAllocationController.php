<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\InitialCash;
use App\CashAllocation;
use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CashAllocationController extends Controller
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
    public function create(User $user)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        return view('cash_allocation.create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $validated = $request->validate([
            'money' => ['required', 'numeric']
        ]);

        $allocateds = CashAllocation::whereDate('created_at', Carbon::today())->get();
        $initial_cash = InitialCash::all()->last();
        
        $cash = $initial_cash->money - $validated['money'];

        if(!empty($initial_cash)) {
            if($cash < 0) {
                $validator = Validator::make([], []);
                $validator->getMessageBag()->add('money', 'No tienes saldo suficiente.');
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }

        $cashAllocation = CashAllocation::create([
            'user_id' => auth()->user()->id,
            'seller_id' => $user->id,
            'money' => $validated['money']
        ]);

        $user->wallet += $validated['money'];
        Expense::create([
            'seller_id' => $user->id,
            'cashAllocation_id' => $cashAllocation->id,
            'money' => $cashAllocation->money
        ]);
        $user->save();
        
        $initial_cash = InitialCash::all()->last();
        $initial_cash->money -= $cashAllocation->money;
        $initial_cash->save();

        return redirect('/initial_cash');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CashAllocation  $cashAllocation
     * @return \Illuminate\Http\Response
     */
    public function show(CashAllocation $cashAllocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CashAllocation  $cashAllocation
     * @return \Illuminate\Http\Response
     */
    public function edit(CashAllocation $cashAllocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CashAllocation  $cashAllocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CashAllocation $cashAllocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CashAllocation  $cashAllocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashAllocation $cashAllocation)
    {
        //
    }
}
