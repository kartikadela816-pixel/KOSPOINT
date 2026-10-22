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
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['pencari', 'pemilik', 'admin'])
              ->default('pencari')
              ->after('password');

        $table->string('nomor_hp', 20)
              ->nullable()
              ->after('role');

        $table->enum('status_akun', ['aktif', 'nonaktif'])
              ->default('aktif')
              ->after('nomor_hp');
    });
}

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role', 'nomor_hp', 'status_akun']);
    });
}
};
