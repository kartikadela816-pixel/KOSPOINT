<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kamar_kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kos_id')->constrained('kos')->cascadeOnDelete();
            $table->string('nomor_kamar');
            $table->string('tipe_kamar')->nullable();
            $table->decimal('harga', 12, 2);
            $table->string('ukuran')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia', 'terisi', 'perbaikan'])
                ->default('tersedia');
            $table->timestamps();

            $table->unique(['kos_id', 'nomor_kamar']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamar_kos');
    }
};
