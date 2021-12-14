<?php

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
Route::get('/', [App\Http\Controllers\ManagerController::class, 'index'])->middleware('auth')->name('top');
Route::get('/createitem', [App\Http\Controllers\ManagerController::class, 'index'])->middleware('auth')->name('top');
Route::get('/categorylist', [App\Http\Controllers\ManagerController::class, 'index'])->middleware('auth')->name('top');
Route::get('/createcategory', [App\Http\Controllers\ManagerController::class, 'index'])->middleware('auth')->name('top');
Route::get('/example', [App\Http\Controllers\ManagerController::class, 'index'])->name('top');
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
