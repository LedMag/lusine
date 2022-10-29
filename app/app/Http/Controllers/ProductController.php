<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')
            ->select(['products.id',
                    'products.name',
                    'products.url',
                    'categories.name AS category',
                    'collections.name AS collection',
                    'products.description_en',
                    'products.description_es',
                    'products.description_ru',
                    'products.price',])
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('collections', 'products.collection_id', '=', 'collections.id')
            ->get(); 
        return response()->json($products);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        return response()->status(200);
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
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        return response()->status(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        Storage::disk('public')->deleteDirectory('products/' . $product->name);
        Product::destroy($id);
        return response()->status(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        $bodyContent = $request->getContent();

        $data = json_decode($bodyContent);

        $name = $data->name;
        $category = $data->category;
        $collection = $data->collection;
        $minPrice = $data->minPrice;
        $maxPrice = $data->maxPrice;
        $order = $data->order; // desc

        $conditions = [];

        if($name){
            array_push($conditions, ['products.name', 'LIKE', $name]);
        };
        if($category){
            array_push($conditions, ['products.category_id', '=', $category]);
        };
        if($collection){
            array_push($conditions, ['products.collection_id', '=', $collection]);
        };

        $products = DB::table('products')
            ->select(['products.id',
                    'products.name',
                    'products.url',
                    'categories.name AS category',
                    'collections.name AS collection',
                    'products.description_en',
                    'products.description_es',
                    'products.description_ru',
                    'products.price',])
            ->where($conditions)
            ->whereBetween('products.price', [$minPrice, $maxPrice])
            ->orderBy('products.name', $order)
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('collections', 'products.collection_id', '=', 'collections.id')
            ->get(); 

        return response()->json($products);
    }
}
