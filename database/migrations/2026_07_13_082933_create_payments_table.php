<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
        $table->integer('jumlah_bayar');

        // 💡 Tambahkan kolom ini
        $table->string('metode_pembayaran')->nullable();
        $table->string('bukti_pembayaran')->nullable(); // nullable agar bisa kosong saat tombol konfirmasi ditekan

        $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
