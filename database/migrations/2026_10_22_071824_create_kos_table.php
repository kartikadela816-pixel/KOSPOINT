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
        Schema::create('kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pemilik')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->string('nama_kos');
            $table->enum('jenis_kos', ['putra', 'putri', 'campur']);
            $table->text('alamat');
            $table->text('deskripsi')->nullable();
            $table->text('aturan_kos')->nullable();
            $table->string('nomor_whatsapp', 20)->nullable();
            $table->string('nomor_telepon', 20)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('status_kos', ['draft', 'aktif', 'nonaktif'])
                  ->default('draft');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kos');
    }
};
