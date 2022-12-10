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
            return redirect(route('pages.home'));
        }

        $validationFields = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'confirmEmail' => 'required|email',
            'password' => 'required',
            'confirmPass' => 'required'
        ]);

        if($validationFields['password'] !== $validationFields['confirmPass'])
        {
            return redirect(route('registration'))->withErrors([
                'confirmPassword' => 'error.password-match'
            ]);
        }

        if($validationFields['email'] !== $validationFields['confirmEmail'])
        {
            return redirect(route('registration'))->withErrors([
                'confirmEmail' => 'error.email-match'
            ]);
        }

        if(User::where('email', $validationFields['email'])->exists()) {
            return redirect(route('admin.login'))->withErrors([
                'email' => 'error.user-exists'
            ]);
        };

        $user = User::create($validationFields);
        if($user){
            Auth::login($user);
            return redirect(route('home'));
        };

        return redirect(route('registration'))->withErrors([
            'formError' => 'error.registration'
        ]);
    }
}
