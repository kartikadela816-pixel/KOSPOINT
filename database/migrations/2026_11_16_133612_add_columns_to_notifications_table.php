<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('id_user')
                ->after('id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('judul')->after('id_user');
            $table->text('pesan')->after('judul');
            $table->string('tipe')->after('pesan');
            $table->boolean('dibaca')->default(false)->after('tipe');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropColumn([
                'id_user',
                'judul',
                'pesan',
                'tipe',
                'dibaca',
            ]);
        });
    }
};
