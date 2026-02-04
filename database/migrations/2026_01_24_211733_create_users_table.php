<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // nama penanggung jawab / admin
            $table->string('name')->nullable();

            // username untuk login (GERAI & ADMIN)
            $table->string('username')->unique();

            // password terenkripsi
            $table->string('password');

            // role: admin | gerai
            $table->string('role')->default('gerai');

            // relasi ke tabel gerais (NULL untuk admin)
            $table->foreignId('gerai_id')
                ->nullable()
                ->constrained('gerais')
                ->nullOnDelete();

            // status akun
            $table->boolean('is_active')->default(true);

            // fitur remember me Laravel
            $table->rememberToken();

            $table->timestamps();

            $table->index(['role', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
