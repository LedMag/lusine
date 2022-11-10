<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validationFields = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'roles' => 'required',
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

        if($user){
            if(Hash::check($request->password, $user->password) ){

                $token = $user->createToken('auth_token')->plainTextToken;

                $cookie = cookie('cookie_token', $token, 15);

                return response(['user' => $user], Response::HTTP_OK)->cookie($cookie);
            } else {
                return response(['message' => 'Password is incorrect'], Response::HTTP_FORBIDDEN);
            }
        } else {
            return response(['message' => 'User is unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request)
    {
        
        try{
            $cookie = Cookie::forget('cookie_token');

            return response(['message' => 'Session was closed'], Response::HTTP_OK)->withoutCookie($cookie);
        }catch(Exception $err) {
            return response(['message' => $err], Response::HTTP_UNAUTHORIZED);
        }
        
    }

    public function profiles()
    {
        $users = User::all();

        if($users){
            return response(['users' => $users], Response::HTTP_OK);
        } else {
            return response(['message' => 'Error 404'], Response::HTTP_NOT_FOUND);
        }

    }
}
