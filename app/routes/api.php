<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [ProductController::class, 'index'])->name('products');

Route::post('products/sort', [ProductController::class, 'sort'])->name('products.sort');

Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::post('products/create', [ProductController::class, 'store'])->name('products.create');

Route::patch('products/update/{id}', [ProductController::class, 'update'])->name('products.update');

Route::delete('products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
