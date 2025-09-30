<?php

use App\Http\Controllers\Category\CollectCategoriesController;
use App\Http\Controllers\Product\CollectProductsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginUserController;
use App\Http\Controllers\User\RegisterUserController;
use App\Http\Controllers\Product\UpdateProductController;
use App\Http\Controllers\Product\ImportProductsController;

// Authentication routes
Route::get('up', function () {
    return response()->json(['message' => 'API is working']);
});

Route::post('register', RegisterUserController::class);
Route::post('login', LoginUserController::class);

// Protected routes
Route::prefix('products')->group(function () {
    Route::get('/', CollectProductsController::class);
    Route::get('/categories', CollectCategoriesController::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/import', ImportProductsController::class);
        Route::put('/{id}', UpdateProductController::class);
    });
});

