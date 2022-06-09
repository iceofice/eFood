<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    MenuController,
    UserController,
    CategoryController,
    CustomerController,
    FrontController,
    OrderController,
    TableController,
    Auth\CustomerLoginController
};

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

Route::get('/', [FrontController::class, 'index'])->name('front');

Auth::routes();

Route::post('customer/login', [CustomerLoginController::class, 'login'])->name('customer.login');
Route::post('customer/register', [FrontController::class, 'register'])->name('customer.register');

Route::group([
    'middleware'    => 'auth:web',
    'prefix'        => 'admin',
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

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

    // Customers
    Route::resource('customers', CustomerController::class)->except('show')->middleware('can:manage customers');

    // Tables
    Route::resource('tables', TableController::class)->except('show')->middleware('can:manage tables');

    // Orders
    Route::resource('orders', OrderController::class)->except('show')->middleware('can:manage orders');
    Route::get('orders/check_time', [OrderController::class, 'checkTime'])->name('orders.checkTime')->middleware('can:manage orders');
    Route::post('orders/{order}/add_menu', [OrderController::class, 'addMenu'])->name('orders.addMenu')->middleware('can:manage orders');
    Route::put('orders/{order}/update_menu/{menu_id}', [OrderController::class, 'updateMenu'])->name('orders.updateMenu')->middleware('can:manage orders');
    Route::post('orders/{order}/remove_menu/{menu_id}', [OrderController::class, 'removeMenu'])->name('orders.removeMenu')->middleware('can:manage orders');
});

Route::post('order', [FrontController::class, 'findCustomer'])->name('front.findCustomer');
Route::get('order', [FrontController::class, 'order'])->name('front.order');
Route::get('check_table', [FrontController::class, 'checkTable'])->name('front.checkTable');
Route::post('reserve', [FrontController::class, 'reserve'])->name('front.reserve');
Route::get('profile', [FrontController::class, 'profile'])->middleware('auth:customer')->name('front.profile');
Route::get('logout', [FrontController::class, 'logout'])->name('front.logout');
