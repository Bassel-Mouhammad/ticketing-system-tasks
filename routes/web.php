<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});


// Protected ticket routes: Only accessible by authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/tickets', [TicketController::class, "index"])->name('tickets.index');
    Route::resource('tickets', TicketController::class)->except(['index']);
});

// Authentication routes (public)
Route::prefix('auth')->group(function () {
    Route::get('signup', [AuthController::class, "signupView"]);
    Route::post("/signup", [AuthController::class, "signup"])->name("auth.signup");

    Route::get('login', [AuthController::class, 'loginView'])->name('auth.login');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login-submit');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});
