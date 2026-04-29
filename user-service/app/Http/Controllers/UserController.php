<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json($user);
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return response()->json($user, 201);
    }

    public function bookingHistory($id)
{
    $response = Http::get("http://localhost:8004/api/bookings?user_id=$id");

    return response()->json([
        'user_id' => $id,
        'bookings' => $response->json()
    ]);
}
}