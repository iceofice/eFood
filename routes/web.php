<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// TODO: Move to group
Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware('auth')->group(function () {
    //TODO: Check how to make every resource exclude show method
    Route::resource('users', UserController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except('show');

    Route::get('categories/check_slug', [CategoryController::class, 'checkSlug'])->name('categories.checkSlug');
});
