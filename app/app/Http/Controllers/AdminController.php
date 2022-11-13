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
        $product->price = $request->price;
        $product->category_id = $request->category;
        $product->collection_id = $request->collection;
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

        $request->all();

        $product = Product::find($id);

        if($product->name !== $request->name){
            $fileName = pathinfo($product->url, PATHINFO_FILENAME);
            $extension = pathinfo($product->url, PATHINFO_EXTENSION);
            $fileName = $fileName . '.' . $extension;
            // Storage::disk('public')->delete('products/' . $request->name . '/' . $fileName);
            $dir = 'products/' . $request->name . '/' . $fileName;
            Storage::disk('public')->move('products/' . $product->name, 'products/' . $request->name);
            $product->name = $request->name;
            $product->url = $dir;
        }
        if($request->file('image')){
            // $fileName = pathinfo($product->url, PATHINFO_FILENAME);
            // $extension = pathinfo($product->url, PATHINFO_EXTENSION);
            // $fileName = $fileName . '.' . $extension;
            // Storage::disk('public')->delete('products/' . $request->name . '/' . $fileName);
            $dir = 'products/' . $request->name . '/';
            $image = $request->file('image')->store($dir, 'public');
            $product->url = $image;
        }
        $product->description_en = $request->description_en;
        $product->description_es = $request->description_es;
        $product->description_ru = $request->description_ru;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->collection_id = $request->collection_id;

        $product->save();

        return redirect(route('catalog'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
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

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function getCollections()
    {
        $collections = Collection::all();        
        return response()->json($collections);
    }

    public function postCollections(Request $request)
    {
        $collections = Collection::all();        
        return response()->json($collections);
    }

}
