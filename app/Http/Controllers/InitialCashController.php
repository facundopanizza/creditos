<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\InitialCash;
use App\CashAllocation;
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

        $initialCash = InitialCash::whereDate('created_at', Carbon::today())->get()->first();
        $allocateds = CashAllocation::whereDate('created_at', Carbon::today())->get();
        
        $money = 0;
        foreach($allocateds as $allocated) {
            $money += $allocated->money;
        }
        $money = $initialCash->entry_money - $money;

        return view('initial_cash.index', ['initialCash' => $initialCash, 'money' => $money]);
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
            'entry_money' => $validated['entry_money']
        ]);

        return redirect('/users');
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
}
