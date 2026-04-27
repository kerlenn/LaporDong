<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model Badge — sistem penghargaan gamifikasi untuk pelapor aktif.
 */
class Badge extends Model
{
    protected $table = 'badge';

    protected $fillable = [
        'nama',
        'deskripsi',
        'ikon',
        'warna',
        'syarat_poin',
        'syarat_laporan',
        'tipe',
    ];

    public function pemilik(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badge')
            ->withTimestamps()
            ->withPivot('diraih_pada');
    }
}
