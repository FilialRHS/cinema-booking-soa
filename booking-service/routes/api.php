<?php

use Illuminate\Support\Facades\Route;

Route::get('/bookings', function () {
    return response()->json([
        'message' => 'API booking jalan'
    ]);
});
// Route::get('/bookings', [BookingController::class, 'index']);
// Route::post('/bookings', [BookingController::class, 'store']);
