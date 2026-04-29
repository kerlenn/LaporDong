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
                'deskripsi'       => 'Level 1',
                'ikon'            => 'images/Pengamat_Jalan.png',
                'warna'           => '#4FB0F5',
                'syarat_laporan'  => 0,
                'syarat_poin'     => 0,
                'tipe'            => 'laporan',
            ],
            [
                'nama'            => 'Pelapor Aktif',
                'deskripsi'       => 'Level 2',
                'ikon'            => 'images/Pelapor_Aktif.png',
                'warna'           => '#3575AF',
                'syarat_laporan'  => 5,
                'syarat_poin'     => 0,
                'tipe'            => 'laporan',
            ],
            [
                'nama'            => 'Penjaga Jalanan',
                'deskripsi'       => 'Level 3',
                'ikon'            => 'images/Penjaga_Jalanan.png',
                'warna'           => '#234A89',
                'syarat_laporan'  => 10,
                'syarat_poin'     => 0,
                'tipe'            => 'poin',
            ],
            [
                'nama'            => 'Pahlawan Negara',
                'deskripsi'       => 'Level 4',
                'ikon'            => 'images/Pahlawan_Negara.png',
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
