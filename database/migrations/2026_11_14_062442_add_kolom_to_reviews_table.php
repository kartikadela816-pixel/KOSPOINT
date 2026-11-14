<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('id_sewa')
                ->unique()
                ->constrained('rentals')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('rating');
            $table->text('komentar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['id_sewa']);
            $table->dropUnique(['id_sewa']);
            $table->dropColumn(['id_sewa', 'rating', 'komentar']);
        });
    }
};
