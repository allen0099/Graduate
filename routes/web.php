<?php


use App\Http\Controllers\EditSetPriceController;
use App\Http\Controllers\PDFController;

//test

use App\Http\Controllers\AdminStampChangeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationUpdateController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PreserveOrderController;
use App\Http\Controllers\RedirectAfterLoginController;
use App\Http\Controllers\ReturnOrderController;
use App\Http\Controllers\AdminShowOrderController;
use App\Http\Controllers\SearchOrderController;
use App\Http\Controllers\SearchUserController;
use App\Http\Controllers\TimeRangeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect('/login');
})->name('root');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// middleware is registered in \App\Http\Kernel.php
// Gate is registered in \App\Providers\AuthServiceProvider.php
// Global Inertia shared data is in \app\Providers\AppServiceProvider.php

// return use helper function below, backend test data in this route
Route::get('/test', fn() => Inertia::render('HelloWorld', ['name' => 'bro, this is not cool']))
    ->name('test');

// HTTP status, ... , name
// check routes `php artisan route:list --columns=method,uri,name --path=user`
Route::group([
    'middleware' => ['auth:sanctum'],
    'prefix' => 'user', // route prefix, all routes in this group is prefix by 'user'
    'as' => 'user.' // for naming routes, all routes name in this group is prefix by 'user.'
], function () {
    // stamp update
    Route::post('/stamp', [AdminStampChangeController::class, 'update'])
        ->name('admin-stamp.update')
        ->middleware('can:admin');
});

Route::get('/search_user', SearchUserController::class)
    ->middleware(['auth:sanctum'])
    ->name('search_user');

Route::get('order-pdf', [PDFController::class, 'OrderPdf'])
    ->middleware(['auth:sanctum'])
    ->name('order-pdf');

Route::post('/preserve_order', PreserveOrderController::class)
    ->middleware(['auth:sanctum'])
    ->name('preserve_order');

Route::apiResource('order', OrderController::class, ['only' => ['index', 'store', 'update']])
    ->middleware(['auth:sanctum']);

Route::apiResource('item', ItemController::class, ['only' => ['index']])
    ->middleware(['auth:sanctum']);

// Admin routes group
Route::group([
//    'prefix' => 'admin', // if enable, will prefix route with it
    'middleware' => ['auth:sanctum', 'can:admin'],
    'as' => 'admin.'
], function () {
    Route::get('/return_order', ReturnOrderController::class)
        ->name('return_order');

    Route::get('/search_order', SearchOrderController::class)
        ->name('search_order');

    Route::post('/edit_set_price', EditSetPriceController::class)
        ->name('edit_set_price');

    Route::get('/meow', fn() => Inertia::render('Test', ['name' => 'Test meow']))
        ->name('meow'); // routes name as 'admin.meow'

    Route::get('/admin/home', fn() => Inertia::render('Admin/Home/Show'))
        ->name('home');

    Route::get('/admin/order', AdminShowOrderController::class)
        ->name('order'); // routes name as 'admin.setting'

    Route::get('/admin/return', fn() => Inertia::render('Admin/Return/Show'))
        ->name('return');

    Route::get('/admin/receive', fn() => Inertia::render('Admin/Receive/Show'))
        ->name('receive');

    Route::get('/admin/setting', fn() => Inertia::render('Admin/Setting/Show'))
        ->name('setting'); // routes name as 'admin.setting'

    Route::apiResource('order', OrderController::class, ['except' => ['index', 'store', 'update']]);

    Route::apiResource('item', ItemController::class, ['except' => ['index']]);

    Route::apiResource('time', TimeRangeController::class,
        ['except' => ['index', 'show', 'destroy', 'store']]);

    Route::post('/location', LocationUpdateController::class)
        ->name('location');
});

// Student routes group
Route::group([
//    'prefix' => 'student', // if enable, will prefix route with it
    'middleware' => ['auth:sanctum', 'can:student'],
    'as' => 'student.'
], function () {
    Route::get('/student/order', fn() => Inertia::render('Student/Order/Show'))
        ->name('order');
    Route::get('/student/myorder', fn() => Inertia::render('Student/MyOrder/Show'))
        ->name('myorder');
});

Route::middleware(['auth:sanctum'])->get('/meow', function () {
    return Inertia::render('Test', ['name' => 'Test meow']);
})->name('meow'); // new dashboard

Route::middleware(['auth:sanctum'])->get('index', RedirectAfterLoginController::class);
