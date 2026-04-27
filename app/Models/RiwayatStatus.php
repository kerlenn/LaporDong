<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model RiwayatStatus — rekam jejak perubahan status laporan.
 * Memberikan transparansi penuh kepada pelapor.
 */
class RiwayatStatus extends Model
{
    protected $table = 'riwayat_status';

    protected $fillable = [
        'laporan_id',
        'diubah_oleh',
        'status_lama',
        'status_baru',
        'catatan',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function pengubah(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }
}
