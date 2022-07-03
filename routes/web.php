<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AttendanceController,
    HomeController,
    MenuController,
    UserController,
    CategoryController,
    CustomerController,
    FrontController,
    OrderController,
    TableController,
    PaymentController,
    InventoryController,
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
    Route::post('menus/{menu}/add_inventories', [MenuController::class, 'addInventory'])->name('menus.addInventory')->middleware('can:manage menus');
    Route::put('menus/{menu}/update_inventories/{inventory_id}', [MenuController::class, 'updateInventory'])->name('menus.updateInventory')->middleware('can:manage menus');
    Route::post('menus/{menu}/remove_inventory/{inventory_id}', [MenuController::class, 'removeInventory'])->name('menus.removeInventory')->middleware('can:manage menus');

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

    // Attendance
    Route::resource('attendances', AttendanceController::class)->except('show')->middleware('can:manage attendances');
    Route::get('attendances/code', [AttendanceController::class, 'code'])->name('attendances.code');
    Route::get('staff/attendance', [AttendanceController::class, 'staff'])->name('attendances.staff');
    Route::post('staff/attendance/clockin', [AttendanceController::class, 'clockin'])->name('attendances.staff.clockin');
    Route::post('staff/attendance/clockout', [AttendanceController::class, 'clockout'])->name('attendances.staff.clockout');

    // Payment
    Route::resource('payments', PaymentController::class)->except('show');

    // Inventory
    Route::resource('inventories', InventoryController::class)->except('show');
});

Route::post('book', [FrontController::class, 'findCustomer'])->name('front.findCustomer');
Route::get('book', [FrontController::class, 'book'])->middleware('auth:customer')->name('front.book');
Route::get('check_table', [FrontController::class, 'checkTable'])->name('front.checkTable');
Route::post('reserve', [FrontController::class, 'reserve'])->name('front.reserve');
Route::get('profile', [FrontController::class, 'profile'])->middleware('auth:customer')->name('front.profile');
Route::get('logout', [FrontController::class, 'logout'])->name('front.logout');
Route::post('order', [FrontController::class, 'order'])->name('front.order');
Route::post('add-order-item', [FrontController::class, 'addOrderItem'])->name('front.order.add');
Route::post('remove-order-item', [FrontController::class, 'removeOrderItem'])->name('front.order.remove');
Route::post('thankyou', [FrontController::class, 'finishOrder'])->name('front.order.finish');
