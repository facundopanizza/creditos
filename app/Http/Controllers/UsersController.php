<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index() {
        $users = User::all();

        return view('users.index', ['users' => $users]);
    }

    public function edit(User $user) {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user) {
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
        $user->role = 'disabled';
        $user->save();

        return redirect('/users');
    }

    public function resume(User $user) {
        return view('users.resume', ['user' => $user]);
    }
}