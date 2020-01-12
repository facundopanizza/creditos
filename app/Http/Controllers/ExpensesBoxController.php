<?php

namespace App\Http\Controllers;

use App\ExpensesBox;
use App\InitialCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpensesBoxController extends Controller
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

        $lastCash = InitialCash::where('active', '=', 1)->get()->last();
        if(empty($lastCash)) {
            return redirect()->back();
        }

        $expensesBox = ExpensesBox::where('created_at', '>', $lastCash->created_at)->get();

        return view('expenses_box.index')->withExpensesBox($expensesBox);
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

        return view('expenses_box.create');
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
            'description' => ['required', 'string'],
            'money' => ['required', 'numeric'],
        ]);

        $lastCash = InitialCash::where('active', '=', 1)->get()->last();
        if(empty($lastCash)) {
            return redirect()->back();
        }

        if($validated['money'] > $lastCash->money) {
            $validator = Validator::make([], []);
            $validator->getMessageBag()->add('money', 'La caja no tiene dinero suficiente');
            return redirect()->back()->withInput()->withErrors($validator);
        }

        ExpensesBox::create([
            'seller_id' => Auth::user()->id,
            'description' => $validated['description'],
            'money' => $validated['money'],
        ]);

        $lastCash->money -= $validated['money'];
        $lastCash->save();

        return redirect('/expenses_box');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpensesBox  $expensesBox
     * @return \Illuminate\Http\Response
     */
    public function show(ExpensesBox $expensesBox)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        return view('expenses_box.show')->withExpensesBox($expensesBox);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpensesBox  $expensesBox
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpensesBox $expensesBox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpensesBox  $expensesBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpensesBox $expensesBox)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpensesBox  $expensesBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpensesBox $expensesBox)
    {
        //
    }
}
