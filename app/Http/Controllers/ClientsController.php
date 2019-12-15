<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(Auth::user()->role == 'admin') {
			$clients = Client::all();
		} else {
			$clients = Auth::user()->clients;
		}

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
            'dni' => ['required', 'string', 'unique:clients'],
        ]);

		Client::create([
			'first_name' => $validated['first_name'],
			'last_name' => $validated['last_name'],
			'phone' => $validated['phone'],
			'cell_phone' => $validated['cell_phone'],
			'activity' => $validated['activity'],
			'business_address' => $validated['business_address'],
			'home_address' => $validated['home_address'],
			'dni' => $validated['dni'],
			'seller_id' => Auth::user()->id,
		]);

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
		if(Auth::user()->id != $client->seller_id && Auth::user()->role != 'admin') {
			return redirect()->back();
		}

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
		if(Auth::user()->id != $client->seller_id && Auth::user()->role != 'admin') {
			return redirect()->back();
		}

		$sellers = User::where('role', '!=', 'disabled')->get();

        return view('clients.edit', ['client' => $client, 'sellers' => $sellers]);
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
		if(Auth::user()->id != $client->seller_id && Auth::user()->role != 'admin') {
			return redirect()->back();
		}

		$validated = $request->validate([ 'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'cell_phone' => ['required', 'string', 'max:255'],
            'activity' => ['required', 'string', 'max:255'],
            'business_address' => ['required', 'string', 'max:255'],
            'home_address' => ['required', 'string', 'max:255'],
            'maximum_credit' => ['integer'],
            'dni' => ['required', 'string'],
			'seller_id' => ['required', 'integer'],
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
        $client->dni = $validated['dni'];
		if(Auth::user()->role == 'admin') {
			$client->maximum_credit = $validated['maximum_credit'];
			$client->seller_id = $validated['seller_id'];
		}

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
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $client->delete();

        return redirect('/clients');
    }

    public function search(Request $request)
    {
		if(Auth::user()->role == 'admin') {
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
					'dni' => ['string']
				]);

				$client = Client::where('dni', $validated['dni'])->first();
			}
		} else {
			$clients = Auth::user()->clients;

			if(isset($request->first_name)) {
				$validated = $request->validate([
					'first_name' => ['string', 'max:255']
				]);

				$clients = $clients->where('first_name', $validated['first_name']);
				return view('search.results', ['clients' => $clients]);
			} elseif(isset($request->last_name)) {
				$validated = $request->validate([
					'last_name' => ['string', 'max:255']
				]);

				$clients = $clients->where('last_name', $validated['last_name']);
				return view('search.results', ['clients' => $clients]);
			} elseif(isset($request->dni)) {
				$validated = $request->validate([
					'dni' => ['string']
				]);

				$client = Auth::user()->clients->where('dni', $validated['dni']);
				if(!isset($client)) {
					$client = $client[0];
				}
			}
		}

		return view('credits.create', ['client' => $client]);
    }
}
