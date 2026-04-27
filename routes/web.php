<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DasborController;
use App\Http\Controllers\EksplorasiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════════
// PUBLIK
// ═══════════════════════════════════════════════
Route::get('/', [BerandaController::class, 'tampilkan'])->name('beranda');
Route::get('/statistik', [BerandaController::class, 'statistikPublik'])->name('statistik');
Route::get('/eksplorasi', [EksplorasiController::class, 'index'])->name('eksplorasi');

// ═══════════════════════════════════════════════
// AUTENTIKASI (tamu saja)
// ═══════════════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'formMasuk'])->name('masuk');
    Route::post('/masuk', [AuthController::class, 'masuk']);
    Route::get('/daftar', [AuthController::class, 'formDaftar'])->name('daftar');
    Route::post('/daftar', [AuthController::class, 'daftar']);
});

Route::post('/keluar', [AuthController::class, 'keluar'])->middleware('auth')->name('keluar');

// ═══════════════════════════════════════════════
// WARGA (login)
// ═══════════════════════════════════════════════
Route::middleware(['auth'])->group(function () {
    Route::get('/dasbor', [DasborController::class, 'warga'])->name('dasbor.warga');

    // Profil
    Route::get('/profil', [DasborController::class, 'profil'])->name('dasbor.profil');
    Route::patch('/profil', [DasborController::class, 'updateProfil'])->name('dasbor.profil.update');
    Route::patch('/profil/password', [DasborController::class, 'ubahPassword'])->name('dasbor.profil.password');

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'daftarSaya'])->name('daftar-saya');
        Route::get('/buat', [LaporanController::class, 'formBuat'])->name('buat');
        Route::post('/kirim', [LaporanController::class, 'kirim'])->name('kirim');
        Route::get('/{laporan}', [LaporanController::class, 'detail'])->name('detail');
        Route::get('/{laporan}/ulasan', [LaporanController::class, 'formUlasan'])->name('ulasan.form');
        Route::post('/{laporan}/ulasan', [LaporanController::class, 'simpanUlasan'])->name('ulasan.simpan');
    });

    // Eksplorasi — komentar & rating (butuh login)
    Route::post('/eksplorasi/{laporan}/ulasan', [EksplorasiController::class, 'simpanKomentar'])
        ->name('eksplorasi.ulasan');
});

// ═══════════════════════════════════════════════
// ADMIN & PETUGAS
// ═══════════════════════════════════════════════
Route::middleware(['auth', 'role:admin,petugas'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dasbor', [AdminController::class, 'dasbor'])->name('dasbor');
        Route::get('/laporan', [AdminController::class, 'daftarLaporan'])->name('laporan.daftar');

        Route::prefix('laporan/{laporan}')->name('laporan.')->group(function () {
            Route::patch('/verifikasi', [AdminController::class, 'verifikasiLaporan'])->name('verifikasi');
            Route::patch('/tugaskan', [AdminController::class, 'tugaskanPetugas'])->name('tugaskan');
            Route::patch('/selesaikan', [AdminController::class, 'selesaikanLaporan'])->name('selesai');
        });
    });
