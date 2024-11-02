<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signupView()
    {
        return view("auth.signup");
    }

    public function signup(Request $request)
    {
        try {
            $data = $request->all();
            $user = new user();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();
            return redirect()->route("auth.login")->with("message", "Account Created");
        } catch (Exception $e) {
            return back()->with("message", $e->getMessage());
        }
    }

    public function loginView()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // Redirect to the tickets.index route if login is successful
            return redirect()->intended('/tickets');
        }

        // If login fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('message', 'Logged out successfully');
    }


    public function resetPassword()
    {
        //
    }
}
