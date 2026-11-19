<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained('bookings')->cascadeOnDelete();
            $table->string('kode_pembayaran')->unique();
            $table->decimal('jumlah', 12, 2);
            $table->string('metode_pembayaran')->nullable();
            $table->dateTime('tanggal_pembayaran')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', [
                'menunggu', 'dibayar', 'ditolak', 'dikembalikan'
            ])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
