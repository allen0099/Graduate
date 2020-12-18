<?php

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
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// middleware is registered in \App\Http\Kernel.php
// Gate is registered in \App\Providers\AuthServiceProvider.php
// Global Inertia shared data is in \app\Providers\AppServiceProvider.php

// return use helper function below
Route::get('/test', fn() => Inertia::render('HelloWorld', ['name' => 'bro, this is not cool']));

// HTTP status, ... , name
Route::group([
    'middleware' => ['auth:sanctum', 'can:admin'],
    'as' => 'admin.' // for naming routes, so in this group, all routes name is prefix by 'admin.'
], function () {
    Route::get('/meow', fn() => Inertia::render('Test', ['name' => 'Test meow']))
        ->name('meow'); // routes name as 'admin.meow'
});

Route::group([
    'middleware' => ['auth:sanctum', 'can:student'],
    'as' => 'student.'
], function () {

});
