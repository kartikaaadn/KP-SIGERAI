<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_arsip_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('laporan_periode_id')
                ->constrained('laporan_periodes')
                ->cascadeOnDelete();

            $table->string('file_path'); // storage path
            $table->string('file_type'); // pdf / xlsx
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            $table->index(['file_type', 'generated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_arsip_files');
    }
};
