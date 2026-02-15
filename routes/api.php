<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\UserController;

// Public API routes
Route::post('/login', [LoginController::class, 'login']);
 // Logout
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('throttle:5,1');
Route::post('/password/reset', [ResetPasswordController::class, 'reset']);

// Protected API routes (Sanctum auth)
Route::middleware(['auth:sanctum'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard']);

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::apiResource('users', UserController::class);
    });

   
});
