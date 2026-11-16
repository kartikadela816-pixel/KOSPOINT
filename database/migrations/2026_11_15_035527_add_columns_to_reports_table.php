<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->foreignId('id_pelapor')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('judul');
            $table->text('isi_laporan');
            $table->string('status')->default('menunggu');
            $table->text('tanggapan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['id_pelapor']);
            $table->dropColumn([
                'id_pelapor',
                'judul',
                'isi_laporan',
                'status',
                'tanggapan',
            ]);
        });
    }
};
