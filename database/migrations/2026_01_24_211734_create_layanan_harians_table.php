<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanan_harians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gerai_id')
                ->constrained('gerais')
                ->cascadeOnDelete();

            $table->date('tanggal');
            $table->unsignedInteger('total_layanan')->default(0);
            $table->text('keterangan')->nullable();

            // draft, submitted, verified, rejected
            $table->string('status_verifikasi')->default('draft');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('verified_at')->nullable();
            $table->text('reject_reason')->nullable();

            $table->timestamps();

            $table->unique(['gerai_id', 'tanggal']); // 1 input per hari per gerai
            $table->index(['tanggal', 'status_verifikasi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_harians');
    }
};
