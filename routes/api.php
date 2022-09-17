<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;


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
Route::post('/merchant/create',[RegisterController::class,'registerMerchant']);
Route::post('/customer/create',[RegisterController::class,'registerCustomer']);
//Route::middleware('auth:sanctum' )->group(function () {
    Route::post('/store/{merchant}/create',[StoreController::class,'create']);
    Route::post('/product/{store}/add',[StoreController::class,'addProduct']);
    Route::post('/cart/{customer}/add',[CartController::class,'addProduct']);
    Route::post('/cart/{cart}/invoice',[CartController::class,'createInvoice']);

//});


