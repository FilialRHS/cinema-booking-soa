<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    public function index()
    {
        return response()->json(Booking::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'movie_id' => 'required|integer',
            'seat_id' => 'required|string',
        ]);

        // Check UserService
        $userRes = Http::get("http://localhost:8001/api/users/{$data['user_id']}");
        if ($userRes->failed()) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check MovieService
        $movieRes = Http::get("http://localhost:8002/api/movies/{$data['movie_id']}");
        if ($movieRes->failed()) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        // Check SeatService
        $seatRes = Http::get("http://localhost:8003/api/seats/{$data['seat_id']}");
        if ($seatRes->failed()) {
            return response()->json(['error' => 'Seat not found'], 404);
        }
        $seat = $seatRes->json();
        if (isset($seat['status']) && $seat['status'] === 'booked') {
            return response()->json(['error' => 'Seat already booked'], 422);
        }

        // Create booking
        $booking = Booking::create([
            'user_id' => $data['user_id'],
            'movie_id' => $data['movie_id'],
            'seat_id' => $data['seat_id'],
            'status' => 'booked',
            'created_at' => now(),
        ]);

        // Update seat status to booked
        $updateRes = Http::put("http://localhost:8003/api/seats/{$data['seat_id']}", [
            'status' => 'booked',
            'booking_id' => $booking->id,
        ]);

        if ($updateRes->failed()) {
            $booking->delete();
            return response()->json(['error' => 'Failed to update seat status'], 500);
        }

        return response()->json($booking, 201);
    }
}
