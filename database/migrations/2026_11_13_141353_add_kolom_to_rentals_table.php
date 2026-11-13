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
    Schema::table('rentals', function (Blueprint $table) {
        $table->foreignId('id_booking')->constrained('bookings')->cascadeOnDelete();
        $table->foreignId('id_pencari')->constrained('users')->cascadeOnDelete();
        $table->foreignId('id_kamar')->constrained('kamar_kos')->cascadeOnDelete();
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->decimal('harga_per_bulan', 12, 2);
        $table->decimal('uang_jaminan', 12, 2)->default(0);
        $table->enum('status_sewa', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
        $table->enum('status_perpanjangan', ['tidak_ada', 'diajukan', 'disetujui', 'ditolak'])->default('tidak_ada');
        $table->date('tanggal_selesai_diminta')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('rentals', function (Blueprint $table) {
        $table->dropForeign(['id_booking']);
        $table->dropForeign(['id_pencari']);
        $table->dropForeign(['id_kamar']);
        $table->dropColumn([
            'id_booking', 'id_pencari', 'id_kamar', 'tanggal_mulai', 'tanggal_selesai',
            'harga_per_bulan', 'uang_jaminan', 'status_sewa',
            'status_perpanjangan', 'tanggal_selesai_diminta',
        ]);
    });
}
};
