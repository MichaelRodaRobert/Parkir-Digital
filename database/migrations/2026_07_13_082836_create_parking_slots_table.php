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
        Schema::create('parking_slots', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_slot')->unique(); // Contoh: A-01, A-02, B-01
            $table->integer('lantai')->default(1);  // Contoh: 1, 2, 3

            // Menggunakan string agar lebih fleksibel (bisa 'tersedia', 'available', 'terisi', 'booked', dll)
            $table->string('status')->default('tersedia');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_slots');
    }
};
