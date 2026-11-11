<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kos')
                  ->constrained('kos')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->string('nama_file');
            $table->string('url_foto');
            $table->unsignedInteger('urutan')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_kos');
    }
};