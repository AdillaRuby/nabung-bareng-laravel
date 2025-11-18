<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_name' => 'required|in:Kasya,Casa',
        ]);

        // Set a shared session for both users (joint account)
        Session::put('user_name', $request->user_name);
        Session::put('is_logged_in', true);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Session::forget('user_name');
        return redirect()->route('login');
    }
}
