<?php

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
    return view('welcome');
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

Route::resource('time', 'App\Http\Controllers\TimeRangeController',
    ['except' => ['index', 'create', 'edit', 'show']]);

Route::post('/location', 'App\Http\Controllers\ReturnLocationController@update')
    ->name('location')
    ->middleware('can:admin');


// HTTP status, ... , name
// check routes `php artisan route:list --columns=method,uri,name --path=user`
Route::group([
    'middleware' => ['auth:sanctum'],
    'prefix' => 'user', // route prefix, all routes in this group is prefix by 'user'
    'as' => 'user.' // for naming routes, all routes name in this group is prefix by 'user.'
], function () {
    // stamp update
    Route::post('/stamp', 'App\Http\Controllers\AdminStampChangeController@update')
        ->name('admin-stamp.update')
        ->middleware('can:admin');
});

Route::group([
    'middleware' => ['auth:sanctum', 'can:admin'],
    'as' => 'admin.'
], function () {
    Route::get('/meow', fn() => Inertia::render('Test', ['name' => 'Test meow']))
        ->name('meow'); // routes name as 'admin.meow'
});

Route::group([
    'middleware' => ['auth:sanctum', 'can:student'],
    'as' => 'student.'
], function () {

});
