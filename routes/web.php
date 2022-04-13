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

Route::group([
    'middleware'    => 'auth',
    'prefix'        => 'admin',
], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

    Route::resources([
        'users'         => UserController::class,
        'categories'    => CategoryController::class,
    ], [
        'except' => ['show']
    ]);

    Route::get('categories/check_slug', [CategoryController::class, 'checkSlug'])->name('categories.checkSlug');
});
