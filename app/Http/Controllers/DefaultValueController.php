<?php

namespace App\Http\Controllers;

use App\DefaultValue;
use Illuminate\Http\Request;

class DefaultValueController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DefaultValue  $defaultValue
     * @return \Illuminate\Http\Response
     */
    public function show(DefaultValue $defaultValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DefaultValue  $defaultValue
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $maximum_credit = DefaultValue::where('column_name', 'maximum_credit')->first();
        return view('default_values.edit')->withMaximumCredit($maximum_credit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DefaultValue  $defaultValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'value' => ['required', 'string'],
        ]);

        $maximum_credit = DefaultValue::where('column_name', 'maximum_credit')->first();
        $maximum_credit->value = $validated['value'];
        $maximum_credit->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DefaultValue  $defaultValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(DefaultValue $defaultValue)
    {
        //
    }
}
