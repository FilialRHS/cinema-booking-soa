<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    public $timestamps = false;
    protected $fillable = ['user_id', 'movie_id', 'seat_id', 'status', 'created_at'];
}
