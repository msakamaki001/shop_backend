<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/item_list',[App\Http\Controllers\ManagerController::class, 'item_list']);
Route::get('/category_list',[App\Http\Controllers\ManagerController::class, 'category_list']);
Route::get('/category_list_paginate',[App\Http\Controllers\ManagerController::class, 'category_list_paginate']);
Route::post('/create_item',[App\Http\Controllers\ManagerController::class, 'create_item']);
Route::post('/create_category',[App\Http\Controllers\ManagerController::class, 'create_category']);
Route::post('/change_item_name',[App\Http\Controllers\ManagerController::class, 'change_item_name']);
Route::post('/change_item_price',[App\Http\Controllers\ManagerController::class, 'change_item_price']);
Route::post('/change_item_num',[App\Http\Controllers\ManagerController::class, 'change_item_num']);
Route::post('/change_item_category',[App\Http\Controllers\ManagerController::class, 'change_item_category']);
Route::post('/change_item_image',[App\Http\Controllers\ManagerController::class, 'change_item_image']);
Route::post('/remove_item',[App\Http\Controllers\ManagerController::class, 'remove_item']);
Route::post('/change_category_name',[App\Http\Controllers\ManagerController::class, 'change_category_name']);
Route::post('/remove_category',[App\Http\Controllers\ManagerController::class, 'remove_category']);
Route::post('/login',[App\Http\Controllers\ManagerController::class, 'login']);
Route::post('/fetch_categories',[App\Http\Controllers\ManagerController::class, 'fetch_categories']);
Route::post('/fetch_items',[App\Http\Controllers\ManagerController::class, 'fetch_items']);
Route::post('/fetch_cart_items',[App\Http\Controllers\ManagerController::class, 'fetch_cart_items']);
Route::post('/buy_cart_items',[App\Http\Controllers\ManagerController::class, 'buy_cart_items']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
