<?php

use App\Http\Controllers\Api\LookupController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


Route::middleware(['lang'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::prefix('lookup')->group(function () {
        Route::get('/{slug?}', [LookupController::class, 'index']);
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('update/{slug}/price', [ProductController::class, 'updatePrice']);
    });
});
