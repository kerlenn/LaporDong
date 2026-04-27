<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model UlasanLaporan — ulasan & rating dari warga setelah laporan selesai.
 * Mendukung sistem performance review untuk petugas.
 */
class UlasanLaporan extends Model
{
    protected $table = 'ulasan_laporan';

    protected $fillable = [
        'laporan_id',
        'user_id',
        'bintang',
        'komentar',
        'is_anonim',
    ];

    protected $casts = [
        'bintang'   => 'integer',
        'is_anonim' => 'boolean',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getNamaPenulisAttribute(): string
    {
        if ($this->is_anonim) {
            return 'Warga Anonim';
        }
        return $this->penulis?->nama_lengkap ?? 'Pengguna';
    }
}
