<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    static function index(){
        return view('pages.contacts');
    }
}
