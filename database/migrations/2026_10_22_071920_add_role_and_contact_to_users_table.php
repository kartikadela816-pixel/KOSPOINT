<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nomor_hp')->nullable()->after('password');
            $table->enum('role', ['pencari', 'pemilik', 'admin'])->default('pencari')->after('nomor_hp');
            $table->enum('status_akun', ['aktif', 'nonaktif'])->default('aktif')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nomor_hp', 'role', 'status_akun']);
        });
    }
};