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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand');          // Merek mobil, contoh: Toyota
            $table->string('model');          // Model mobil, contoh: Avanza
            $table->integer('year');          // Tahun produksi
            $table->enum('status', ['available', 'unavailable'])->default('available'); // Status mobil
            $table->decimal('rental_price', 10, 2);  // Harga sewa per hari
            $table->text('description')->nullable(); // Deskripsi opsional
            $table->string('image')->nullable();     // Path gambar mobil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
