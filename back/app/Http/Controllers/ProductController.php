<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function saveImage ($name, $base64str) 
    {
        $image_64 = $base64str; //your base64 encoded data

        // $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
      
        $ext = explode(';base64',$image_64);
        $ext = explode('/',$ext[0]);
        $ext = $ext[1];	

        $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
      
      // find substring fro replace here eg: data:image/png;base64,
      
        $image = str_replace($replace, '', $image_64); 
      
        $image = str_replace(' ', '+', $image); 
      
        $imageName = Str::random(10).'.'.$ext;

        $imageDir = 'products/' . $name . '/' . $imageName;
      
        Storage::disk('public')->put($imageDir, base64_decode($image));

        Log::info('Product: ' . $imageDir);

        return "public/" . $imageDir;
    }

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
        foreach($products as $product){
            $image64 = Storage::get($product->url);
            $product->url = "data:image/jpg;base64," . base64_encode($image64);
        };
        // Storage::disk('public')->get($imageDir, base64_decode($image));

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
        // $request->json()->all();

        $request = $request->instance();
        $content = $request->getContent();
        $array = json_decode($content);

        foreach( $array as $obj ){
            $product = new Product();

            $base_64_image_string = $obj->image;

            if($base_64_image_string){
                $url_image = $this->saveImage($obj->name, $base_64_image_string);
                $product->url = $url_image;
            }
    
            // $image = $request->file('image')->store($dir, 'public');
     
            $product->name = $obj->name;
            $product->description_en = $obj->description_en;
            $product->description_es = $obj->description_es;
            $product->description_ru = $obj->description_ru;
            $product->price = $obj->price;
            $product->category_id = $obj->category;
            $product->collection_id = $obj->collection;
            $product->save();
        };
        

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
            foreach($products as $product){
                $image64 = Storage::get($product->url);
                $product->url = "data:image/jpg;base64," . base64_encode($image64);
            };

        return response()->json($products);
    }
}
