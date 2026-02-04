<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanan_harian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_harian_id')
                ->constrained('layanan_harians')
                ->cascadeOnDelete();

            $table->string('jenis_layanan', 150);
            $table->unsignedInteger('jumlah_pengguna')->default(0);
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();

            $table->index(['layanan_harian_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_harian_details');
    }
};
