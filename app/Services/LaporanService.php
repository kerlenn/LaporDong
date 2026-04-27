<?php

namespace App\Services;

use App\Models\Laporan;
use App\Models\RiwayatStatus;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * LaporanService — logika bisnis inti untuk pembuatan & pemrosesan laporan.
 */
class LaporanService
{
    public function __construct(
        private readonly GeminiService $geminiService,
        private readonly BadgeService  $badgeService
    ) {}

    /**
     * Buat laporan baru dengan validasi foto AI dan penentuan prioritas + SLA.
     */
    public function buatLaporan(User $pelapor, array $data, array $fileFoto): Laporan
    {
        return DB::transaction(function () use ($pelapor, $data, $fileFoto) {
            // Simpan foto ke storage
            $pathFoto = $this->simpanFotoLaporan($fileFoto, 'sebelum');

            // Analisis AI untuk prioritas + estimasi SLA
            $analisisAi = $this->analisisFotoAi($fileFoto[0], $data['deskripsi']);

            // Hitung tenggat SLA dari estimasi hari
            $estimasiHari = $analisisAi['estimasi_hari'] ?? $this->defaultEstimasiHari($analisisAi['prioritas'] ?? 'sedang');
            $tenggat = now()->addDays($estimasiHari);

            // Buat laporan
            $laporan = Laporan::create([
                ...$data,
                'pelapor_id'        => $pelapor->id,
                'status'            => Laporan::STATUS_DIKIRIM,
                'prioritas_ai'      => $analisisAi['prioritas'],
                'skor_keparahan_ai' => $analisisAi['skor_keparahan'],
                'catatan_ai'        => $analisisAi['catatan_ai'],
                'estimasi_hari'     => $estimasiHari,
                'tenggat_sla'       => $tenggat,
                'foto_sebelum'      => $pathFoto,
            ]);

            // Catat riwayat status pertama
            $this->catatPerubahanStatus(
                $laporan, null, Laporan::STATUS_DIKIRIM, $pelapor->id,
                "Laporan dikirim. Target penyelesaian: {$estimasiHari} hari ({$tenggat->format('d M Y')})."
            );

            // Beri poin + cek badge
            $pelapor->tambahPoin(10);
            $this->badgeService->periksaBadgeBaru($pelapor);

            return $laporan;
        });
    }

    /**
     * Perbarui status laporan dengan audit trail lengkap.
     */
    public function perbaruiStatus(Laporan $laporan, string $statusBaru, User $pengubah, ?string $catatan = null): void
    {
        DB::transaction(function () use ($laporan, $statusBaru, $pengubah, $catatan) {
            $statusLama = $laporan->status;

            $laporan->update([
                'status'            => $statusBaru,
                'tanggal_ditangani' => $statusBaru === Laporan::STATUS_DIPROSES ? now() : $laporan->tanggal_ditangani,
                'tanggal_selesai'   => $statusBaru === Laporan::STATUS_SELESAI  ? now() : $laporan->tanggal_selesai,
            ]);

            $this->catatPerubahanStatus($laporan, $statusLama, $statusBaru, $pengubah->id, $catatan);

            // Tambah poin pelapor saat selesai
            if ($statusBaru === Laporan::STATUS_SELESAI) {
                $laporan->pelapor->tambahPoin(50);
                $this->badgeService->periksaBadgeBaru($laporan->pelapor);
            }
        });
    }

    /**
     * Unggah foto bukti sesudah perbaikan.
     */
    public function unggahFotoSesudah(Laporan $laporan, array $fileFoto): void
    {
        $pathFoto = $this->simpanFotoLaporan($fileFoto, 'sesudah');
        $laporan->update(['foto_sesudah' => $pathFoto]);
    }

    // ────────────── PRIVATE METHODS ──────────────

    private function analisisFotoAi(UploadedFile $foto, string $deskripsi): array
    {
        try {
            $base64 = base64_encode(file_get_contents($foto->getPathname()));
            return $this->geminiService->tentukanPrioritasSLA($base64, $deskripsi, $foto->getMimeType());
        } catch (\Throwable $e) {
            Log::warning('[LaporanService] AI analisis gagal: ' . $e->getMessage());
            return [
                'prioritas'      => 'sedang',
                'skor_keparahan' => 50,
                'estimasi_hari'  => 7,
                'catatan_ai'     => 'Penilaian AI tidak tersedia.',
            ];
        }
    }

    private function defaultEstimasiHari(string $prioritas): int
    {
        return match ($prioritas) {
            'tinggi' => 3,
            'sedang' => 7,
            'rendah' => 14,
            default  => 7,
        };
    }

    private function simpanFotoLaporan(array $fileFoto, string $fase): array
    {
        $paths = [];
        foreach ($fileFoto as $foto) {
            if ($foto instanceof UploadedFile) {
                $paths[] = $foto->store("laporan/{$fase}", 'public');
            }
        }
        return $paths;
    }

    private function catatPerubahanStatus(
        Laporan $laporan,
        ?string $statusLama,
        string  $statusBaru,
        int     $idPengubah,
        ?string $catatan
    ): void {
        RiwayatStatus::create([
            'laporan_id'  => $laporan->id,
            'diubah_oleh' => $idPengubah,
            'status_lama' => $statusLama,
            'status_baru' => $statusBaru,
            'catatan'     => $catatan,
        ]);
    }
}
