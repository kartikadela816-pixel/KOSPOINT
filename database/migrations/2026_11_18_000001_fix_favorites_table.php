<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('favorites', function (Blueprint $table) {
            if (!Schema::hasColumn('favorites', 'id_user')) $table->foreignId('id_user')->after('id')->constrained('users')->cascadeOnDelete();
            if (!Schema::hasColumn('favorites', 'id_kos')) $table->foreignId('id_kos')->after('id_user')->constrained('kos')->cascadeOnDelete();
            $table->unique(['id_user', 'id_kos'], 'favorites_user_kos_unique');
        });
    }
    public function down(): void {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropUnique('favorites_user_kos_unique');
            $table->dropConstrainedForeignId('id_kos');
            $table->dropConstrainedForeignId('id_user');
        });
    }
};
