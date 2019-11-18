<?php

namespace App\Http\Controllers;

use App\SharePayment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index() {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $users = User::all();

        return view('users.index', ['users' => $users]);
    }

    public function edit(User $user) {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user) {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        if(isset($request['password'])) {
            if($request['email'] == $user->email || $request['dni'] == $user->dni) {
                $validated = $request->validate([
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'dni' => ['required', 'integer'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
            } else {
                $validated = $request->validate([
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'dni' => ['required', 'integer', 'unique:users'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
            }

            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->dni = $validated['dni'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);

            $user->save();
            return redirect('/users');
        } else {
            if($request['email'] == $user->email || $request['dni'] == $user->dni) {
                $validated = $request->validate([
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'dni' => ['required', 'integer'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                ]);
            }
            else {
                $validated = $request->validate([
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'dni' => ['required', 'integer', 'unique:users'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                ]);
            }

            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->dni = $validated['dni'];
            $user->email = $validated['email'];

            $user->save();
            return redirect('/users');
        }
    }

    public function disable(User $user) {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $user->role = 'disabled';
        $user->save();

        return redirect('/users');
    }

    public function enable(User $user) {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $user->role = 'seller';
        $user->save();

        return redirect('/disabled-users');
    }

    public function disabledUsers()
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $users = User::where('role', 'disabled')->get();

        return view('users.disabledUsers', ['users' => $users]);
    }

    public function resume(User $user)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        return view('users.resume', ['user' => $user]);
    }

    public function sellersReport()
    {
        return view('users.sellersReport');
    }

    public function findReport(Request $request)
    {
        $validated = $request->validate([
            'from' => ['required', 'date'],
            'until' => ['required', 'date']
        ]);

        $from = new Carbon($validated['from']);
        $until = new Carbon($validated['until']);

        $payments = SharePayment::whereBetween('created_at', [$from, $until])->get();

        if(empty($payments->first())) {
            return redirect()->back()->withInput();
        }

        $sellers = [];

        foreach($payments as $payment) {
            if(array_key_exists($payment->share->credit->seller->id, $sellers)) {
                $array = [
                    'payed' => $payment->payment_amount,
                    'share' => $payment->share,
                ];

                array_push($sellers[$payment->share->credit->seller->id]['credits'], $array);
            } else {
                $sellers[$payment->share->credit->seller->id] = [
                    'seller' => $payment->share->credit->seller,
                    'credits' => [
                        [
                            'payed' => $payment->payment_amount,
                            'share' => $payment->share,
                        ]
                    ],
                ];
            }
        }

        return view('users.sellersReport', ['sellers' => $sellers]);
    }

    public function search(Request $request)
    {
        if(isset($request->first_name)) {
            $validated = $request->validate([
                'first_name' => ['string', 'max:255']
            ]);

            $sellers = User::where('first_name', $validated['first_name'])->get();
            return view('initial_cash.results', ['sellers' => $sellers]);
        } elseif(isset($request->last_name)) {
            $validated = $request->validate([
                'last_name' => ['string', 'max:255']
            ]);

            $sellers = User::where('last_name', $validated['last_name'])->get();
            return view('initial_cash.results', ['sellers' => $sellers]);
        } elseif(isset($request->dni)) {
            $validated = $request->validate([
                'dni' => ['integer']
            ]);

            $sellers = User::where('dni', $validated['dni'])->first();
        }

        return view('initial_cash.index', ['sellers' => $sellers]);
    }
}