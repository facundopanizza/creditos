<?php

namespace App\Http\Controllers;

use App\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::whereDate('created_at', Carbon::today())->get();
        $expenses = $expenses->where('seller_id', Auth::user()->id);
        $expenses = $expenses->sortByDesc('created_at');

        return view('expenses.index')->withExpenses($expenses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');
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
            'description' => ['required', 'string'],
            'money' => ['required', 'numeric'],
            'picture' => ['required', 'image']
        ]);

        if($validated['money'] > Auth::user()->wallet) {
            $validator = Validator::make([], []);
            $validator->getMessageBag()->add('money', 'No tienes saldo suficiente.');
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $path = $request->file('picture')->store('public/expenses');
        $path = str_replace('public/', 'storage/', $path);

        Expense::create([
            'seller_id' => Auth::user()->id,
            'description' => $validated['description'],
            'money' => $validated['money'],
            'picture' => $path,
        ]);

        Auth::user()->wallet -= $validated['money'];
        Auth::user()->save();

        return redirect('/expenses');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return view('expenses.show')->withExpense($expense);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
