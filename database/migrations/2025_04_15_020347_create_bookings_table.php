<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');   // yang menyewa
            $table->unsignedBigInteger('car_id');    // mobil yang disewa
            $table->date('start_date');              // tanggal mulai sewa
            $table->date('end_date');                // tanggal selesai sewa
            $table->integer('total_days');           // total hari
            $table->decimal('total_price', 10, 2);   // total harga
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending'); // status pemesanan
            $table->timestamps();
    
            // Relasi ke tabel users dan cars
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
