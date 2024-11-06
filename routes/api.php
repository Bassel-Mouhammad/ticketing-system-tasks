<?php

use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:api')->get('tickets', [TicketController::class, 'index']);
Route::post('tickets', [TicketController::class, 'store']);
Route::get('tickets/{id}', [TicketController::class, 'show']);
Route::put('tickets/{id}', [TicketController::class, 'update']);
Route::delete('tickets/{id}', [TicketController::class, 'destroy']);

Route::prefix("auth")->group(function () {
    Route::post("signup", [AuthController::class, "signup"])->name("signup");
    Route::post("login", [AuthController::class, "login"])->name("login");
    Route::middleware("auth:sanctum")->post("/logout", [AuthController::class, 'logout']);
});
