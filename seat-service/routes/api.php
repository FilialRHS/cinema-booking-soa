<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeatController;

Route::get('/seats', [SeatController::class, 'index']);
Route::get('/seats/{id}', [SeatController::class, 'show']);
Route::put('/seats/{id}', [SeatController::class, 'update']);
Route::post('/seats', [SeatController::class, 'store']);
