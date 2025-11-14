<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    // mostly unchanged from project template
    // changed the return function to cause a page refresh
    // this is needed to properly reload the page's props
    // there is probably a cleaner way of doing this so I
    // would be interested in learning how to optimise this

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|unique:users,name',
            'password' => 'required|string|confirmed|min:1',
        ]);
        $user = User::create([
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'password' => $validatedData['password'],
        ]);
        auth()->login($user);
        return Inertia::location(route('home'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = filter_var($credentials['login_id'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (auth()->attempt([$loginField => $credentials['login_id'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            return Inertia::location(route('home'));
        }

        return back()->withErrors([
            'login_id' => 'login credentials are incorrect.',
        ])->onlyInput('login_id');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Inertia::location(route('home'));
    }
}
