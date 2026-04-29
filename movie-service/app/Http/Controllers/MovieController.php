<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        return response()->json([
            "status" => "success",
            "data" => Movie::all()
        ]);
    }

    public function show($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                "status" => "error",
                "message" => "Movie not found"
            ], 404);
        }

        return response()->json([
            "status" => "success",
            "data" => $movie
        ]);
    }
}
