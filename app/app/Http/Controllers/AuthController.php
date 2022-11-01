<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validationFields = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::create($validationFields);

        $user->save();
        return response()->json([
            'state' => 1,
            'msg' => 'Registration is succesfull'
        ]);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $user = User::where('email', '=', $request->email)->first();

        if(isset($user->id) ){
            if(Hash::check($request->password, $user->password) ){

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'state' => 1,
                    'msg' => 'Login is succesfull',
                    'access_token' => $token
                ]);
            } else {
                return response()->json([
                    'state' => 0,
                    'msg' => 'Password is incorrect'
                ], 404);
            }
        } else {
            return response()->json([
                'state' => 1,
                'msg' => 'User is not registrated'
            ], 404);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'state' => 1,
            'msg' => 'Session is closed',
        ]);
    }

    public function userProfile()
    {
        return response()->json([
            'state' => 1,
            'msg' => 'User profile',
            'data' => auth()->user()
        ]);
    }
}
