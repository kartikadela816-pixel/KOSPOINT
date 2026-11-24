<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->foreignId('id_pencari')->constrained('users')->cascadeOnDelete();
        $table->foreignId('id_kamar')->constrained('kamar_kos')->cascadeOnDelete();
        $table->dateTime('tanggal_booking')->useCurrent();
        $table->date('tanggal_masuk_rencana');
        $table->unsignedInteger('lama_sewa_bulan');
        $table->enum('status_booking', ['menunggu', 'diterima', 'ditolak', 'dibatalkan'])->default('menunggu');
        $table->text('catatan_pencari')->nullable();
        $table->text('catatan_pemilik')->nullable();
        $table->dateTime('tanggal_ditanggapi')->nullable();
    });
}
    public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['id_pencari']);
        $table->dropForeign(['id_kamar']);
        $table->dropColumn([
            'id_pencari', 'id_kamar', 'tanggal_booking', 'tanggal_masuk_rencana',
            'lama_sewa_bulan', 'status_booking', 'catatan_pencari',
            'catatan_pemilik', 'tanggal_ditanggapi',
        ]);
    });
}
};
