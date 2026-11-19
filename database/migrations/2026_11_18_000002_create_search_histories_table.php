<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('search_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('kata_kunci', 120)->nullable();
            $table->string('jenis_kos', 20)->nullable();
            $table->decimal('harga_min', 12, 2)->nullable();
            $table->decimal('harga_max', 12, 2)->nullable();
            $table->unsignedInteger('jumlah_hasil')->default(0);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->index('created_at');
        });
    }
    public function down(): void 
    { 
        Schema::dropIfExists('search_histories'); 
    }
};
