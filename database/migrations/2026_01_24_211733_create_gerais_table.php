<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gerais', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gerai');
            $table->string('instansi')->nullable();
            $table->string('lokasi_counter')->nullable();
            $table->string('pic_nama')->nullable();
            $table->string('pic_kontak')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();

            $table->index(['nama_gerai', 'status_aktif']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gerais');
    }
};
