<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    static function index(){
        return view('pages.catalog');
    }
}
