<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/es/home');
Route::redirect('/home', '/es/home');
Route::redirect('/about', '/es/about');
Route::redirect('/catalog', '/es/catalog');
Route::redirect('/contacts', '/es/contacts');
Route::redirect('/admin', '/es/admin/home');

Route::group(['prefix' => '{language}'], function () {
           
    Route::get('/', [MainController::class, 'index'])->name('main');

    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::get('about', [AboutController::class, 'index'])->name('about');

    Route::get('catalog', [CatalogController::class, 'index'])->name('catalog');

    Route::get('contacts', [ContactsController::class, 'index'])->name('contacts');

    Route::get('admin/login', [LoginController::class, 'index'])->name('admin.login');
    
    Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login.post');

    Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    
        Route::get('/', [AdminController::class, 'index'])->name('admin');
    
        Route::get('home', [AdminController::class, 'home'])->name('admin.home');
    
        Route::get('about', [AdminController::class, 'about'])->name('admin.about');
    
        Route::get('catalog', [AdminController::class, 'catalog'])->name('admin.catalog');
    
        Route::get('contacts', [AdminController::class, 'contacts'])->name('admin.contacts');
    
        // Route::get('/login', [LoginController::class, 'index'])->name('admin.login');
    
        // Route::post('/login', [LoginController::class, 'post'])->name('admin.login.post');
    
        Route::get('/logout', [LogoutController::class, 'index'])->name('admin.logout');
    
        Route::get('/registration', [RegistrationController::class, 'index'])->name('admin.registration');
    
        Route::post('/registration', [RegistrationController::class, 'save'])->name('admin.registration.post');

    });


});
