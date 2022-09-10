<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect('pages.admin.home');
        }
        return view('pages.admin.login');
    }

    public function login(Request $request)
    {
        $formFields = $request->only(['email', 'password']);

        if(Auth::attempt($formFields)){
            return redirect()->intended(route('admin.home', app()->getLocale()));
        }
        
        return redirect(route('admin.login', app()->getLocale() ))->withErrors([
            'email' => 'error.login'
        ]);
    }
}
