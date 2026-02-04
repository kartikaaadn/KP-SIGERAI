<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_periodes', function (Blueprint $table) {
            $table->id();

            // harian / mingguan / bulanan
            $table->string('periode_tipe');

            $table->date('periode_mulai');
            $table->date('periode_selesai');

            $table->foreignId('dibuat_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['periode_tipe', 'periode_mulai', 'periode_selesai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_periodes');
    }
};
