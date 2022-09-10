<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('pages.registration');
    }

    public function save(Request $request)
    {
        if(Auth::check()){
            return redirect(route('admin.home', app()->getLocale() ));
        }

        $validationFields = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(User::where('email', $validationFields['email'])->exists()) {
            return redirect(route('admin.login', app()->getLocale() ))->withErrors([
                'email' => 'error.user-exists'
            ]);
        };

        $user = User::create($validationFields);
        if($user){
            Auth::login($user);
            return redirect(route('admin.home', app()->getLocale() ));
        };

        return redirect(route('admin.login', app()->getLocale() ))->withErrors([
            'formError' => 'error.registration'
        ]);
    }
}
