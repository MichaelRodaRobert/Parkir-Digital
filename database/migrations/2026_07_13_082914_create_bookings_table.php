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
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('parking_slot_id')->constrained()->onDelete('cascade');
        $table->dateTime('waktu_mulai');
        $table->dateTime('waktu_selesai');
        $table->integer('total_harga')->default(0);

        // <-- TAMBAHKAN BARIS INI JIKA BELUM ADA
        $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->default('pending');

        $table->timestamps();
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
