<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index()
    {
        return Seat::all();
    }

    public function show($id)
    {
        return Seat::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $seat = Seat::findOrFail($id);
        $seat->status = $request->status;
        $seat->save();

        return $seat;
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
