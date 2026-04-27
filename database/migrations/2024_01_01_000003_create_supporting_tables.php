<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi tabel pendukung: badge, user_badge, riwayat_status, ulasan_laporan.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ─── Badge ───
        Schema::create('badge', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->unique();
            $table->string('deskripsi', 300);
            $table->string('ikon', 10)->default('🏅');
            $table->string('warna', 20)->default('#234A89');
            $table->unsignedInteger('syarat_poin')->default(0);
            $table->unsignedInteger('syarat_laporan')->default(0);
            $table->string('tipe', 50)->default('umum');
            $table->timestamps();
        });

        // ─── Pivot: user ↔ badge ───
        Schema::create('user_badge', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('badge_id')->constrained('badge')->cascadeOnDelete();
            $table->timestamp('diraih_pada')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'badge_id']);
        });

        // ─── Riwayat Status ───
        Schema::create('riwayat_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporan')->cascadeOnDelete();
            $table->foreignId('diubah_oleh')->constrained('users')->restrictOnDelete();
            $table->string('status_lama', 30)->nullable();
            $table->string('status_baru', 30);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('laporan_id');
        });

        // ─── Ulasan Laporan ───
        Schema::create('ulasan_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporan')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->unsignedTinyInteger('bintang');
            $table->text('komentar')->nullable();
            $table->boolean('is_anonim')->default(false);
            $table->timestamps();

            $table->unique('laporan_id'); // 1 ulasan per laporan
            $table->index('bintang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan_laporan');
        Schema::dropIfExists('riwayat_status');
        Schema::dropIfExists('user_badge');
        Schema::dropIfExists('badge');
    }
};
