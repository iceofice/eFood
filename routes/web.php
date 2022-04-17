<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
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

Route::group([
    'middleware'    => 'auth',
    'prefix'        => 'admin',
], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

    // Users
    Route::resource('users', UserController::class)->except('show')->middleware('can:manage users');
    Route::post('/users/filter', [UserController::class, 'filter'])->name('users.filter');

    //TODO: Group properly

    // Categories
    Route::resource('categories', CategoryController::class)->except('show')->middleware('can:manage menus');
    Route::get('categories/check_slug', [CategoryController::class, 'checkSlug'])->name('categories.checkSlug')->middleware('can:manage menus');

    // Menus
    Route::resource('menus', MenuController::class)->except('show')->middleware('can:manage menus');
    Route::get('menus/check_slug', [MenuController::class, 'checkSlug'])->name('menus.checkSlug')->middleware('can:manage menus');
});
