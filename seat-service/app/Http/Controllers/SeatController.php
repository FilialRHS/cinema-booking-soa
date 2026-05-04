<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index(Request $request)
    {
        $movieId = $request->movie_id;

        return Seat::where('movie_id', $movieId)->get();
    }

    public function show($id)
    {
        return Seat::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $seat = Seat::find($id);

        if (!$seat) {
            return response()->json(['message' => 'Seat not found'], 404);
        }

        $seat->status = $request->status ?? 'booked';
        $seat->save();

        return response()->json($seat);
    }

    public function store(Request $request)
    {
        $seat = Seat::create([
            'seat_number' => $request->seat_number,
            'status' => 'available'
        ]);

        return response()->json($seat);
    }
}
