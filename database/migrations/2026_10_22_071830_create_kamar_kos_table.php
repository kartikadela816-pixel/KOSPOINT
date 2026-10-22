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
    Schema::create('kamar_kos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_kos')
              ->constrained('kos')
              ->cascadeOnUpdate()
              ->cascadeOnDelete();

        $table->string('nomor_kamar', 30);
        $table->string('nama_kamar')->nullable();
        $table->decimal('harga_per_bulan', 12, 2);
        $table->decimal('uang_jaminan', 12, 2)->default(0);
        $table->enum('jenis_kamar_mandi', ['dalam', 'luar'])
              ->default('luar');
        $table->enum('status_kamar', ['tersedia', 'dipesan', 'terisi', 'nonaktif'])
              ->default('tersedia');
        $table->text('deskripsi')->nullable();

        $table->timestamps();

        $table->unique(['id_kos', 'nomor_kamar']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar_kos');
    }
};
