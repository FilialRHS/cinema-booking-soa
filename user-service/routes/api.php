<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}/bookings', [UserController::class, 'bookingHistory']);

Route::get('/test', function () {
    return response()->json(['message' => 'API works']);
});