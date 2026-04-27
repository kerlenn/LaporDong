<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class BadgeService
{
    private const DAFTAR_BADGE = [
        [
            'nama'            => 'Pengamat Jalan',
            'deskripsi'       => 'Berhasil mengirim laporan pertama',
            'ikon'            => '🚀',
            'warna'           => '#4FB0F5',
            'syarat_laporan'  => 1,
            'syarat_poin'     => 0,
            'tipe'            => 'laporan',
        ],
        [
            'nama'            => 'Pelapor Aktif',
            'deskripsi'       => 'Mengirim 5 laporan kerusakan jalan',
            'ikon'            => '🏙️',
            'warna'           => '#3575AF',
            'syarat_laporan'  => 5,
            'syarat_poin'     => 0,
            'tipe'            => 'laporan',
        ],
        [
            'nama'            => 'Penjaga Jalanan',
            'deskripsi'       => 'Mengumpulkan 1000 poin kontribusi',
            'ikon'            => '🦸',
            'warna'           => '#234A89',
            'syarat_laporan'  => 0,
            'syarat_poin'     => 1000,
            'tipe'            => 'poin',
        ],
        [
            'nama'            => 'Pahlawan Negara',
            'deskripsi'       => 'Mengirim 20 laporan yang selesai ditangani',
            'ikon'            => '🛡️',
            'warna'           => '#7BCFF5',
            'syarat_laporan'  => 20,
            'syarat_poin'     => 0,
            'tipe'            => 'laporan',
        ],
    ];

    public function periksaBadgeBaru(User $user): array
    {
        $badgeBaru = [];

        foreach (self::DAFTAR_BADGE as $definisi) {
            // Cek apakah user sudah punya badge ini
            if ($user->badge()->where('nama', $definisi['nama'])->exists()) {
                continue;
            }

            if ($this->memenuhinSyarat($user, $definisi)) {
                $badge = $this->pastikanBadgeAda($definisi);
                $user->badge()->attach($badge->id, ['diraih_pada' => now()]);
                $badgeBaru[] = $badge;
                Log::info("[BadgeService] Badge '{$badge->nama}' diberikan ke {$user->email}");
            }
        }

        return $badgeBaru;
    }

    private function memenuhinSyarat(User $user, array $definisi): bool
    {
        $syaratLaporanTerpenuhi = $definisi['syarat_laporan'] === 0
            || $user->total_laporan >= $definisi['syarat_laporan'];

        $syaratPoinTerpenuhi = $definisi['syarat_poin'] === 0
            || $user->total_poin >= $definisi['syarat_poin'];

        return $syaratLaporanTerpenuhi && $syaratPoinTerpenuhi;
    }

    private function pastikanBadgeAda(array $definisi): Badge
    {
        return Badge::firstOrCreate(
            ['nama' => $definisi['nama']],
            $definisi
        );
    }
}
