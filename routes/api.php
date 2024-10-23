<?php

use App\Http\Controllers\API\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('tickets', [TicketController::class, 'index']);
Route::post('tickets', [TicketController::class, 'store']);

Route::get('tickets/{id}', [TicketController::class, 'show']);
Route::post('tickets', [TicketController::class, 'store']);
Route::put('tickets/{id}', [TicketController::class, 'update']);
