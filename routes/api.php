<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['lang'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });
    
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
