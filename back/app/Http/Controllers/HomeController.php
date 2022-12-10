<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    static function index(){
        $urls = Storage::files('public/slider/');
        $files = [];
        foreach( $urls as $name ){
            array_push($files, basename($name) );
        };
        return view('pages.home', ['files' => $files]);
    }
}
