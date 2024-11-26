<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthenticationController extends Controller
{
    //
    public function signup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required|string|unique:users',
            'email' => 'required|unique:users,email',
            'password' => [
                'required', 'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->symbols(),
            ],
            'confirmPassword' => 'required|same:password'
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

    public function signin(Request $request)
    {
        $validated = $request->validate([
            'user_email' => 'required|email',
            'user_password' => 'required',
        ]);

        if (Auth::attempt(['email' => $validated['user_email'], 'password' => $validated['user_password']])) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'user') {
                return redirect()->route('Userdashboard');
            }

            if (in_array($user->role, ['admin', 'superadmin'])) {
                return redirect()->route('Admindashboard');
            }
        }

        return back()->withErrors(['login' => 'Invalid email or password.']);
    }


    //profile
    public function profilePage()
    {
        return view('profile');
    }
}
