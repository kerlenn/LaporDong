<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi tabel laporan — inti domain kerusakan jalan LaporDong.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_laporan', 30)->unique();
            $table->foreignId('pelapor_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();

            // Konten laporan
            $table->string('judul', 200);
            $table->text('deskripsi');

            // Lokasi
            $table->string('alamat_lengkap', 500);
            $table->string('kelurahan', 100);
            $table->string('kecamatan', 100);
            $table->string('kota', 100);
            $table->string('provinsi', 100);
            $table->string('kode_pos', 10)->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);

            // Status & AI
            $table->enum('status', ['dikirim', 'diverifikasi', 'diproses', 'selesai', 'ditolak'])
                ->default('dikirim');
            $table->enum('prioritas_ai', ['tinggi', 'sedang', 'rendah'])->nullable();
            $table->decimal('skor_keparahan_ai', 5, 2)->nullable();
            $table->text('catatan_ai')->nullable();

            // Bukti foto (JSON array path)
            $table->json('foto_sebelum')->nullable();
            $table->json('foto_sesudah')->nullable();

            // Tracking waktu
            $table->timestamp('tanggal_ditangani')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->text('catatan_petugas')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Indeks untuk performa query
            $table->index('status');
            $table->index('prioritas_ai');
            $table->index('kota');
            $table->index('provinsi');
            $table->index(['pelapor_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
