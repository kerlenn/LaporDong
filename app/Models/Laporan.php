<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laporan';

    protected $fillable = [
        'kode_laporan',
        'pelapor_id',
        'petugas_id',
        'judul',
        'deskripsi',
        'alamat_lengkap',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'latitude',
        'longitude',
        'status',
        'prioritas_ai',
        'skor_keparahan_ai',
        'catatan_ai',
        'estimasi_hari',
        'tenggat_sla',
        'foto_sebelum',
        'foto_sesudah',
        'tanggal_ditangani',
        'tanggal_selesai',
        'catatan_petugas',
    ];

    protected $casts = [
        'latitude'          => 'decimal:8',
        'longitude'         => 'decimal:8',
        'skor_keparahan_ai' => 'decimal:2',
        'foto_sebelum'      => 'array',
        'foto_sesudah'      => 'array',
        'tanggal_ditangani' => 'datetime',
        'tanggal_selesai'   => 'datetime',
        'tenggat_sla'       => 'datetime',
    ];

    // ────────────── STATUS CONSTANTS ──────────────
    const STATUS_DIKIRIM      = 'dikirim';
    const STATUS_DIVERIFIKASI = 'diverifikasi';
    const STATUS_DIPROSES     = 'diproses';
    const STATUS_SELESAI      = 'selesai';
    const STATUS_DITOLAK      = 'ditolak';

    const SEMUA_STATUS = [
        self::STATUS_DIKIRIM,
        self::STATUS_DIVERIFIKASI,
        self::STATUS_DIPROSES,
        self::STATUS_SELESAI,
        self::STATUS_DITOLAK,
    ];

    // ────────────── PRIORITAS CONSTANTS ──────────────
    const PRIORITAS_TINGGI = 'tinggi';
    const PRIORITAS_SEDANG = 'sedang';
    const PRIORITAS_RENDAH = 'rendah';

    // ────────────── RELATIONSHIPS ──────────────
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function ulasan(): HasOne
    {
        return $this->hasOne(UlasanLaporan::class, 'laporan_id');
    }

    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(RiwayatStatus::class, 'laporan_id')->orderBy('created_at', 'asc');
    }

    // ────────────── ACCESSORS ──────────────
    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DIKIRIM      => 'Dikirim',
            self::STATUS_DIVERIFIKASI => 'Diverifikasi',
            self::STATUS_DIPROSES     => 'Sedang Diproses',
            self::STATUS_SELESAI      => 'Selesai',
            self::STATUS_DITOLAK      => 'Ditolak',
            default                   => 'Tidak Diketahui',
        };
    }

    public function getWarnaPrioritasAttribute(): string
    {
        return match ($this->prioritas_ai) {
            self::PRIORITAS_TINGGI => 'red',
            self::PRIORITAS_SEDANG => 'yellow',
            self::PRIORITAS_RENDAH => 'green',
            default                => 'gray',
        };
    }

    public function getLabelPrioritasAttribute(): string
    {
        return match ($this->prioritas_ai) {
            self::PRIORITAS_TINGGI => 'Prioritas Tinggi',
            self::PRIORITAS_SEDANG => 'Prioritas Sedang',
            self::PRIORITAS_RENDAH => 'Prioritas Rendah',
            default                => 'Belum Dinilai',
        };
    }

    // ────────────── SLA HELPERS ──────────────

    /**
     * Hitung sisa hari SLA dari sekarang.
     * Negatif = sudah lewat deadline.
     */
    public function getSisaHariSlaAttribute(): ?int
    {
        if (!$this->tenggat_sla) return null;
        return (int) now()->diffInDays($this->tenggat_sla, false);
    }

    /**
     * Status SLA: ontime / warning / overdue / selesai
     */
    public function getStatusSlaAttribute(): string
    {
        if ($this->status === self::STATUS_SELESAI) return 'selesai';
        if ($this->status === self::STATUS_DITOLAK) return 'ditolak';
        if (!$this->tenggat_sla) return 'belum_ditetapkan';

        $sisa = $this->sisa_hari_sla;
        if ($sisa < 0)  return 'overdue';
        if ($sisa <= 2) return 'warning';
        return 'ontime';
    }

    /**
     * Apakah laporan tepat waktu diselesaikan?
     */
    public function getTepatWaktuAttribute(): ?bool
    {
        if ($this->status !== self::STATUS_SELESAI) return null;
        if (!$this->tenggat_sla || !$this->tanggal_selesai) return null;
        return $this->tanggal_selesai->lte($this->tenggat_sla);
    }

    // ────────────── SCOPES ──────────────
    public function scopeAktif($query)
    {
        return $query->whereNotIn('status', [self::STATUS_SELESAI, self::STATUS_DITOLAK]);
    }

    public function scopePrioritasTinggi($query)
    {
        return $query->where('prioritas_ai', self::PRIORITAS_TINGGI);
    }

    public function scopeByKota($query, string $kota)
    {
        return $query->where('kota', $kota);
    }

    public function scopeOverdueSla($query)
    {
        return $query->whereNotNull('tenggat_sla')
            ->where('tenggat_sla', '<', now())
            ->whereNotIn('status', [self::STATUS_SELESAI, self::STATUS_DITOLAK]);
    }

    // ────────────── HELPERS ──────────────
    public function sudahSelesai(): bool
    {
        return $this->status === self::STATUS_SELESAI;
    }

    public function bisaDiulas(): bool
    {
        return $this->sudahSelesai() && !$this->ulasan()->exists();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Laporan $laporan) {
            $laporan->kode_laporan = 'LD-' . strtoupper(uniqid());
        });
    }
}
