<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::get("tickets", [TicketController::class, "index"])->name('tickets.index');
Route::resource('tickets', TicketController::class);
Route::get('/tickets/{id}', [TicketController::class, 'show']);


// Route::get('tickets/{id}',TicketController::class,'show');
