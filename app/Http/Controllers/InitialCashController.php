<?php

namespace App\Http\Controllers;

use App\InitialCash;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        return view('initial_cash.create');
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
