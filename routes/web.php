<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', function () {
    return csrf_token(); 
});

Route::group(['prefix' => 'quotes'], function () {
    Route::get('/', [QuoteController::class, 'index']);
    Route::get('/{quote_id}', [QuoteController::class, 'show']);
    Route::post('/', [QuoteController::class, 'store']);
});

Route::group(['prefix' => 'product'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product_id}/{language?}', [ProductController::class, 'show']);
});
