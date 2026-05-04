<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('seats', function (Blueprint $table) {
            $table->unsignedBigInteger('movie_id');
        });
    }
    $response = Http::put("$seatService/api/seats/" . $request->seat_id, [
    'status' => 'booked'
]);

dd($response->json());

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seats', function (Blueprint $table) {
            //
        });
    }
};
