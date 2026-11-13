
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('id_sewa')
                ->after('id')
                ->constrained('rentals')
                ->cascadeOnDelete();

            $table->foreignId('id_pencari')
                ->after('id_sewa')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('jumlah_bayar', 12, 2);
            $table->string('metode_pembayaran', 50);
            $table->string('bukti_pembayaran')->nullable();
            $table->dateTime('tanggal_bayar')->nullable();

            $table->enum('status_pembayaran', [
                'menunggu',
                'berhasil',
                'ditolak'
            ])->default('menunggu');

            $table->text('catatan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['id_sewa']);
            $table->dropForeign(['id_pencari']);

            $table->dropColumn([
                'id_sewa',
                'id_pencari',
                'jumlah_bayar',
                'metode_pembayaran',
                'bukti_pembayaran',
                'tanggal_bayar',
                'status_pembayaran',
                'catatan',
            ]);
        });
    }
};
