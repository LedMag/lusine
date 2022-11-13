<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\App;
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

// Route::redirect('/', '/es/home');
// Route::redirect('/home', '/es/home');
// Route::redirect('/about', '/es/about');
// Route::redirect('/catalog', '/es/catalog');
// Route::redirect('/contacts', '/es/contacts');
// Route::redirect('/admin', '/es/admin/home');

// Route::get('language/{lang}', [LanguageController::class, 'change'])->name('language');

// Route::group(['prefix' => '{language}'], function () {
    
// Route::group(['prefix' => App::getLocale()], function () {

           
    // Route::get('/', [MainController::class, 'index'])->name('main');

    // Route::get('home', [HomeController::class, 'index'])->name('home');

    // Route::get('about', [AboutController::class, 'index'])->name('about');

    // Route::get('catalog', [CatalogController::class, 'index'])->name('catalog');

    // Route::get('contacts', [ContactsController::class, 'index'])->name('contacts');

    // Route::get('login', [LoginController::class, 'index'])->name('login');
    
    // Route::post('login', [LoginController::class, 'login'])->name('login.post');

    // Route::get('show/{id}', [AdminController::class, 'show'])->name('show.product');

    // Route::get('create', [AdminController::class, 'create'])->name('create.product');

    // Route::post('create', [AdminController::class, 'store'])->name('create.product.post');

    // Route::delete('delete/{id}', [AdminController::class, 'delete'])->name('delete.product');

    // Route::get('edit/{id}', [AdminController::class, 'edit'])->name('edit.product');

    // Route::patch('update/{id}', [AdminController::class, 'update'])->name('update.product');

    // Route::get('registration', [RegistrationController::class, 'index'])->name('registration');
    
    // Route::post('registration', [RegistrationController::class, 'save'])->name('registration.post');

    // Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    
        // Route::get('registration', [RegistrationController::class, 'index'])->name('registration');
    
        // Route::post('registration', [RegistrationController::class, 'save'])->name('registration.post');

    //     Route::post('addSlide', [AdminController::class, 'storeSlide'])->name('addSlide');

    //     Route::get('deleteSlide/{name}', [AdminController::class, 'deleteSlide'])->name('deleteSlide');

    //     Route::get('/logout', [LogoutController::class, 'index'])->name('logout');
    

    // });


// });
