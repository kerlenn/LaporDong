<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Update ulasan_laporan: allow multiple ulasan per laporan (per user),
 * remove unique constraint on laporan_id only, add unique on laporan_id+user_id.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ulasan_laporan', function (Blueprint $table) {
            // Hapus unique constraint lama (hanya laporan_id)
            $table->dropUnique(['laporan_id']);

            // Tambah unique per user per laporan (1 user = 1 ulasan per laporan)
            $table->unique(['laporan_id', 'user_id'], 'ulasan_laporan_per_user');
        });
    }

    public function down(): void
    {
        Schema::table('ulasan_laporan', function (Blueprint $table) {
            $table->dropUnique('ulasan_laporan_per_user');
            $table->unique('laporan_id');
        });
    }
};
