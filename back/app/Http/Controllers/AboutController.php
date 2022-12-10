<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    static function index(){
        return view('pages.about');
    }
}
