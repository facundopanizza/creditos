<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();

        return view('clients.index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'cell_phone' => ['required', 'string', 'max:255'],
            'activity' => ['required', 'string', 'max:255'],
            'business_address' => ['required', 'string', 'max:255'],
            'home_address' => ['required', 'string', 'max:255'],
            'maximum_credit' => ['required', 'integer'],
            'dni' => ['required', 'string', 'unique:clients']
        ]);

        Client::create($validated);

        return redirect('/clients');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('clients.show')->withClient($client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clients.edit', ['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'cell_phone' => ['required', 'string', 'max:255'],
            'activity' => ['required', 'string', 'max:255'],
            'business_address' => ['required', 'string', 'max:255'],
            'home_address' => ['required', 'string', 'max:255'],
            'maximum_credit' => ['integer'],
            'max_simultaneous_credits' => ['integer'],
            'dni' => ['required', 'string']
        ]);

        $checkDni = User::where('dni', $validated['dni'])->get();
        if(!isset($checkDni)) {
            if($checkDni->first()->id !== $client->id && $checkDni->count() > 1) {
                return redirect()->back();
            }
        }

        $client->first_name = $validated['first_name'];
        $client->last_name = $validated['last_name'];
        $client->phone = $validated['phone'];
        $client->cell_phone = $validated['cell_phone'];
        $client->activity = $validated['activity'];
        $client->business_address = $validated['business_address'];
        $client->home_address = $validated['home_address'];
        $client->maximum_credit = $validated['maximum_credit'];
        $client->max_simultaneous_credits = $validated['maximum_credit'];
        $client->dni = $validated['dni'];

        $client->save();

        return redirect('/clients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect('/clients');
    }

    public function search(Request $request)
    {
        if(isset($request->first_name)) {
            $validated = $request->validate([
                'first_name' => ['string', 'max:255']
            ]);

            $clients = Client::where('first_name', $validated['first_name'])->get();
            return view('search.results', ['clients' => $clients]);
        } elseif(isset($request->last_name)) {
            $validated = $request->validate([
                'last_name' => ['string', 'max:255']
            ]);

            $clients = Client::where('last_name', $validated['last_name'])->get();
            return view('search.results', ['clients' => $clients]);
        } elseif(isset($request->dni)) {
            $validated = $request->validate([
                'dni' => ['integer']
            ]);

            $client = Client::where('dni', $validated['dni'])->first();
        }

        return view('credits.create', ['client' => $client]);
    }
}
