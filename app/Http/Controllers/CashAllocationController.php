<?php

namespace App\Http\Controllers;

use App\CashAllocation;
use App\User;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'money' => ['required', 'numeric']
        ]);

        CashAllocation::create([
            'user_id' => auth()->user()->id,
            'seller_id' => $user->id,
            'money' => $validated['money']
        ]);

        return redirect('/users');
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
