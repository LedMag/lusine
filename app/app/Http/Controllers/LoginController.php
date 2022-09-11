<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect('home');
        }
        return view('pages.login');
    }

    public function login(Request $request)
    {

        $formFields = $request->only(['email', 'password']);

        if(Auth::attempt($formFields)){
            return redirect()->route('home');
        }
        
        return redirect()->route('login' )->withErrors([
            'email' => 'error.login'
        ]);
    }
}
