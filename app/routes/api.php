<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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

Route::group(['prefix' => 'products'], function () {

    Route::get('/', [ProductController::class, 'index'])->name('products');
    
    Route::post('/sort', [ProductController::class, 'sort'])->name('products.sort');
    
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
    
    Route::post('/create', [ProductController::class, 'store'])->name('products.create');
    
    Route::patch('/update/{id}', [ProductController::class, 'update'])->name('products.update');
    
    Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
});

Route::group(['prefix' => 'auth'], function () {

    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::group(['middleware' => ['auth:sanctum']], function () {
    
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

        Route::get('/userProfile', [AuthController::class, 'userProfile']);

    });
    
});

Route::get('categories', [AdminController::class, 'getCategories'])->name('categories');

Route::get('collections', [AdminController::class, 'getCollections'])->name('collections');