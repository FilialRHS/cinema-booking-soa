<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        return response()->json(Booking::all());
    }

    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'user_id' => 'required',
            'movie_id' => 'required',
            'seat_id' => 'required'
        ]);

        $userService = env('USER_SERVICE_URL');
        $movieService = env('MOVIE_SERVICE_URL');
        $seatService = env('SEAT_SERVICE_URL');

        // CEK USER
        $user = Http::get("$userService/api/users/" . $request->user_id);
        if ($user->failed()) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // CEK MOVIE
        $movie = Http::get("$movieService/api/movies/" . $request->movie_id);
        if ($movie->failed()) {
            return response()->json(['message' => 'Movie tidak ditemukan'], 404);
        }

        // CEK SEAT
        $seat = Http::get("$seatService/api/seats/" . $request->seat_id);
        if ($seat->failed()) {
            return response()->json(['message' => 'Seat tidak ditemukan'], 404);
        }

        // 🔥 CEK STATUS SEAT (INI PENTING)
        if ($seat->json()['status'] === 'booked') {
            return response()->json([
                'message' => 'Seat sudah dibooking'
            ], 400);
        }

        // UPDATE SEAT
        Http::put("$seatService/api/seats/" . $request->seat_id, [
            'status' => 'booked'
        ]);

        // SIMPAN BOOKING
        $booking = Booking::create([
            'user_id' => $request->user_id,
            'movie_id' => $request->movie_id,
            'seat_id' => $request->seat_id,
            'status' => 'success'
        ]);

        return response()->json([
            'message' => 'Booking berhasil',
            'data' => $booking
        ]);
    }
}
