<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Models\Movie;

// Halaman utama (UI)
Route::get('/', function () {
    $movies = Movie::all();
    return view('movies', compact('movies'));
});

// API - ambil semua movie
Route::get('/movies', [MovieController::class, 'index']);

// API - ambil 1 movie
Route::get('/movies/{id}', [MovieController::class, 'show']);
