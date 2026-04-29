<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run()
    {
        Movie::insert([
            [
                'title' => 'Avengers',
                'time' => '19:00',
                'studio' => 'Studio 1',
                'price' => 50000,
            ],
            [
                'title' => 'Spiderman',
                'time' => '21:00',
                'studio' => 'Studio 2',
                'price' => 45000,
            ],
            [
                'title' => 'Batman',
                'time' => '18:00',
                'studio' => 'Studio 3',
                'price' => 55000,
            ],
            [
                'title' => 'Joker',
                'time' => '20:00',
                'studio' => 'Studio 4',
                'price' => 60000,
            ]

        ]);
    }
}
