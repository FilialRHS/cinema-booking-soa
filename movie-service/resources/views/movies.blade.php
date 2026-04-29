<!DOCTYPE html>
<html>
<head>
    <title>Movie List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #0b0b0b;
            color: white;
        }

        .movie-row {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding-bottom: 10px;
        }

        .movie-card {
            min-width: 180px;
            transition: transform 0.3s;
        }

        .movie-card:hover {
            transform: scale(1.05);
        }

        .movie-img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            border-radius: 10px;
        }

        .movie-title {
            margin-top: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        .movie-info {
            font-size: 12px;
            color: #bbb;
            line-height: 1.4;
        }
    </style>
</head>

<body>

<div class="container mt-5">

    <h4 class="mb-3">🎬 Now Showing</h4>

    <div class="movie-row">

        @foreach($movies as $movie)
        <div class="movie-card">

            <img src="{{ $movie->image }}" class="movie-img">

            <div class="movie-title">
                {{ $movie->title }}
            </div>

            <div class="movie-info">
                ⏰ {{ $movie->time }} <br>
                🎟 {{ $movie->studio }} <br>
                💰 Rp {{ number_format($movie->price) }}
            </div>

        </div>
        @endforeach

    </div>

</div>

</body>
</html>
