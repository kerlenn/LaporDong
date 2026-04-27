<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi tabel users — pengguna sistem LaporDong.
 * Mencakup warga pelapor, petugas lapangan, dan admin.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 150);
            $table->string('email')->unique();
            $table->string('no_telepon', 20)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('peran', ['warga', 'petugas', 'admin'])->default('warga');
            $table->string('foto_profil')->nullable();
            $table->unsignedInteger('total_poin')->default(0);
            $table->unsignedInteger('total_laporan')->default(0);
            $table->string('kota_domisili', 100)->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->index('peran');
            $table->index('kota_domisili');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
