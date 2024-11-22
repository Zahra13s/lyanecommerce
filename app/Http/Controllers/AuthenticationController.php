<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;



class AuthenticationController extends Controller
{
    //
    function signup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => [
        'required',
        'string',
        new Lowercase(),
        'unique:users,username',
    ],
            'email' => 'required|unique:users,email',
            'password' => [
                'required','string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->symbols()
            ],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        Auth::login($user);
        return redirect()->route('Userdashboard');


    }


    function signin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();
        if ($user && Hash::check($validated['password'], $user->password)) {
            Auth::login($user);

            if (Auth::user()->role === 'user') {
                return redirect()->route('Userdashboard');
            }

            if (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin') {
                return redirect()->route('Admindashboard');
            }

        }else{
            return "something wrong";
        }
    }


}
