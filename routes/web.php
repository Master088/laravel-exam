<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public route
// Route::get('/', fn() => view('welcome'));

// Auth routes
Auth::routes();

// Throttle forgot password request (5 per minute per IP)
Route::post('/password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email')
    ->middleware('throttle:5,1'); // 5 requests per 1 minute

// Protected routes
Route::middleware('auth')->group(function() {

    // Dashboard (any authenticated user)
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    // User management (admin only + optional rate limiting)
    Route::middleware(['admin', ])->group(function() {
        Route::resource('users', UserController::class);
    });

});
