<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    static function index(){
        $products = Product::all();
        return view('pages.catalog', compact('products'));
    }
}
