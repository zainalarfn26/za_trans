<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum status pada kolom status
        DB::statement("ALTER TABLE cars MODIFY status ENUM('available', 'rented', 'maintenance') DEFAULT 'available'");
    }

    public function down(): void
    {
        // Kembalikan ke enum sebelumnya jika dibutuhkan rollback
        DB::statement("ALTER TABLE cars MODIFY status ENUM('available', 'unavailable') DEFAULT 'available'");
    }
};
