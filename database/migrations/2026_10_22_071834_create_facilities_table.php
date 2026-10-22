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
    Schema::create('facilities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_kamar')
              ->constrained('kamar_kos')
              ->cascadeOnUpdate()
              ->cascadeOnDelete();

        $table->string('nama_fasilitas');
        $table->string('keterangan')->nullable();

        $table->timestamps();

        $table->unique(['id_kamar', 'nama_fasilitas']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
