<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    // GET all
    public function index()
    {
        return response()->json(Movie::all());
    }

    // GET by id
    public function show($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie tidak ditemukan'], 404);
        }

        return response()->json($movie);
    }

    // POST (upload)
    public function store(Request $request)
    {
        $movie = Movie::create([
            'title' => $request->title,
            'price' => $request->price
        ]);

        return response()->json($movie, 201);
    }

    // PUT (update)
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie tidak ditemukan'], 404);
        }

        $movie->update([
            'title' => $request->title,
            'price' => $request->price
        ]);

        return response()->json($movie);
    }

    // DELETE
    public function destroy($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie tidak ditemukan'], 404);
        }

        $movie->delete();

        return response()->json(['message' => 'Movie berhasil dihapus']);
    }
}
