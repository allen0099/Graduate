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


// helper function
Route::get('/test', fn() => Inertia::render('HelloWorld'));
Route::get('/about', fn() => Inertia::render('About'));

Route::middleware(['auth:sanctum', 'verified'])->get('/meow', function () {
    return Inertia::render('Test', ['name' => 'Test meow']);
})->name('meow');

Route::middleware(['auth:sanctum', 'verified'])->get('/admin/setting', function () {
    return Inertia::render('Admin/Setting/Show');
})->name('admin.setting');

Route::middleware(['auth:sanctum', 'verified'])->get('/student/meow', function () {
    return Inertia::render('Student/meow/Show');
})->name('student.meow');

Route::middleware(['auth:sanctum', 'verified'])->get('/order/all', function () {
    return Inertia::render('Student/MyOrder/Show');
})->name('order.all');