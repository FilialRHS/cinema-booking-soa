<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

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
            'seat_id' => 'required|integer',
        ]);

        // Check UserService (expects plain user object)
        try {
            $userRes = Http::get("http://localhost:8001/api/users/{$data['user_id']}");
        } catch (ConnectionException $e) {
            return response()->json(['error' => 'User service unavailable'], 503);
        }
        if (!$userRes->ok()) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check MovieService (movie-service exposes GET /api/movies returning {status,data})
        try {
            $movieRes = Http::get("http://localhost:8002/api/movies");
        } catch (ConnectionException $e) {
            return response()->json(['error' => 'Movie service unavailable'], 503);
        }
        if (!$movieRes->ok()) {
            return response()->json(['error' => 'Movie service error'], 502);
        }
        $movieJson = $movieRes->json();
        $movies = isset($movieJson['data']) ? $movieJson['data'] : $movieJson;
        $movie = null;
        foreach ($movies as $m) {
            if (isset($m['id']) && $m['id'] == $data['movie_id']) {
                $movie = $m;
                break;
            }
        }
        if (!$movie) {
            return response()->json(['error' => 'Movie not found'], 404);
        }

        // Check SeatService (seat-service returns seat model; seats are identified by numeric id)
        try {
            $seatRes = Http::get("http://localhost:8003/api/seats/{$data['seat_id']}");
        } catch (ConnectionException $e) {
            return response()->json(['error' => 'Seat service unavailable'], 503);
        }
        if (!$seatRes->ok()) {
            return response()->json(['error' => 'Seat not found'], 404);
        }
        $seat = $seatRes->json();
        // seat model uses 'status' and 'seat_number'
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
        try {
            $updateRes = Http::put("http://localhost:8003/api/seats/{$data['seat_id']}", [
                'status' => 'booked',
                'booking_id' => $booking->id,
            ]);
        } catch (ConnectionException $e) {
            $booking->delete();
            return response()->json(['error' => 'Seat service unavailable'], 503);
        }

        if (!$updateRes->ok()) {
            $booking->delete();
            return response()->json(['error' => 'Failed to update seat status'], 500);
        }

        return $this->successResponse($booking);
    }

    private function successResponse($data)
    {
        return response()->json([
            'message' => 'berhasil',
            'data' => $data
        ], 201);
    }
}
