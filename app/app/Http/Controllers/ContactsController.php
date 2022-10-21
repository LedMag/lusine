<?php

namespace App\Http\Controllers;

use App\Mail\ClientMessage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactsController extends Controller
{
    static function index()
    {
        return view('pages.contacts');
    }

    public static function send()
    {
        $data = [
            'subject' => 'Holalalala',
            'message' => 'lalalalala'
        ];
        $email = 'ledmaggazin@gmail.com';

        // mail(
        //     $email,
        //     $data['subject'],
        //     $data['message']
        // );

        try{
            Mail::to('ledmaggazin@gmail.com')->queue(new ClientMessage($email, $data));
            return new ClientMessage($email, $data);
            // return response()->json(['Great!']);
        } catch (Exception $error)
        {
            return response()->json(['Bad: ' . $error]);
        }
    }
}
