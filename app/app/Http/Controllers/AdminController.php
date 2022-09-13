<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin');
    }

    public function home()
    {
        $urls = Storage::files('public/slider/');
        $files = [];
        foreach( $urls as $name ){
            array_push($files, basename($name) );
        };
        return view('home', ['files' => $files]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $collections = Collection::all();
        return view('pages.create', compact('categories', 'collections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->all();

        $dir = 'products/' . $request->name . '/';

        $image = $request->file('image')->store($dir, 'public');

        $product = new Product();
 
        $product->name = $request->name;
        $product->url = $image;
        $product->description_en = $request->description_en;
        $product->description_es = $request->description_es;
        $product->description_ru = $request->description_ru;
        $product->category_id = $request->category;
        $product->collection_id = $request->collection;
        // dd($product);
        $product->save();
        return redirect(route('catalog'));
    }

    public function storeSlide(Request $request)
    {
        $request->file('image')->store('slider', 'public');
        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        $product->price = 999;
        return view('pages.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Product::edit()->where('id', $id);
        return redirect(route('catalog'));
    }

    public function edit_page($id)
    {
        $categories = Category::all();
        $collections = Collection::all();
        $product = Product::where('id', $id)->first();
        return view('pages.edit', compact('product', 'categories', 'collections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // dd($id);
        $product = Product::where('id', $id)->first();
        Storage::disk('public')->deleteDirectory('products/' . $product->name);
        Product::destroy($id);
        return redirect(route('catalog'));
    }

    public function deleteSlide($name)
    {

        Storage::disk('public')->delete('slider/' . $name);
        return redirect(route('home'));
    }

}
