<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User — mencakup pelapor, petugas, dan admin.
 * Dilengkapi sistem poin dan badge untuk gamifikasi.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_telepon',
        'password',
        'peran',
        'foto_profil',
        'total_poin',
        'total_laporan',
        'kota_domisili',
        'is_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_aktif'          => 'boolean',
        'total_poin'        => 'integer',
        'total_laporan'     => 'integer',
    ];

    // ────────────── PERAN CONSTANTS ──────────────
    const PERAN_WARGA   = 'warga';
    const PERAN_PETUGAS = 'petugas';
    const PERAN_ADMIN   = 'admin';

    // ────────────── RELATIONSHIPS ──────────────
    public function laporanSaya(): HasMany
    {
        return $this->hasMany(Laporan::class, 'pelapor_id');
    }

    public function tugasSaya(): HasMany
    {
        return $this->hasMany(Laporan::class, 'petugas_id');
    }

    public function badge(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badge', 'user_id', 'badge_id')
            ->withTimestamps()
            ->withPivot('diraih_pada');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(UlasanLaporan::class, 'user_id');
    }

    // ────────────── ACCESSORS ──────────────
    public function getLevelAttribute(): string
    {
        return match (true) {
            $this->total_poin >= 5000 => 'Pahlawan Negara',
            $this->total_poin >= 2000 => 'Penjaga Infrastruktur',
            $this->total_poin >= 500  => 'Pengamat Aktif',
            default                   => 'Pengamat Jalan',
        };
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->foto_profil) {
            return asset('storage/' . $this->foto_profil);
        }

        $inisial = urlencode(substr($this->nama_lengkap, 0, 2));
        return "https://ui-avatars.com/api/?name={$inisial}&background=234A89&color=fff&size=128";
    }

    // ────────────── HELPERS ──────────────
    public function adalahAdmin(): bool
    {
        return $this->peran === self::PERAN_ADMIN;
    }

    public function adalahPetugas(): bool
    {
        return $this->peran === self::PERAN_PETUGAS;
    }

    public function tambahPoin(int $jumlahPoin): void
    {
        $this->increment('total_poin', $jumlahPoin);
        $this->increment('total_laporan');
    }
}
