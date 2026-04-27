<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Badge;
use App\Models\Laporan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed data awal: admin, petugas, warga, badge, dan laporan contoh.
     */
    public function run(): void
    {
        // ----------------------------------------------------------------
        // 1. Seed Badge Gamifikasi
        // ----------------------------------------------------------------
        $daftarBadge = [
            [
                'nama'       => 'Pengamat Jalan',
                'ikon'       => '🌱',
                'deskripsi'  => 'Kirim laporan pertamamu',
                'syarat'     => 'laporan_1',
            ],
            [
                'nama'       => 'Pelapor Aktif',
                'ikon'       => '🏙️',
                'deskripsi'  => 'Kirim 5 laporan jalan rusak',
                'syarat'     => 'laporan_5',
            ],
            [
                'nama'       => 'Penjaga Jalanan',
                'ikon'       => '🦸',
                'deskripsi'  => 'Kumpulkan 1.000 poin kontribusi',
                'syarat'     => 'poin_1000',
            ],
            [
                'nama'       => 'Pahlawan Negara',
                'ikon'       => '🛡️',
                'deskripsi'  => 'Kirim 20 laporan dalam setahun',
                'syarat'     => 'laporan_20',
            ],
        ];

        foreach ($daftarBadge as $badge) {
            Badge::firstOrCreate(['syarat' => $badge['syarat']], $badge);
        }

        // ----------------------------------------------------------------
        // 2. Akun Admin
        // ----------------------------------------------------------------
        $admin = User::firstOrCreate(
            ['email' => 'admin@lapordong.id'],
            [
                'nama'          => 'Administrator LaporDong',
                'password'      => Hash::make('admin123'),
                'peran'         => 'admin',
                'is_aktif'      => true,
                'nomor_telepon' => '08112345678',
                'total_poin'    => 0,
                'total_laporan' => 0,
            ]
        );

        // ----------------------------------------------------------------
        // 3. Akun Petugas
        // ----------------------------------------------------------------
        $petugas1 = User::firstOrCreate(
            ['email' => 'budi@lapordong.id'],
            [
                'nama'          => 'Budi Santoso',
                'password'      => Hash::make('petugas123'),
                'peran'         => 'petugas',
                'is_aktif'      => true,
                'nomor_telepon' => '08211111111',
                'total_poin'    => 0,
                'total_laporan' => 0,
            ]
        );

        $petugas2 = User::firstOrCreate(
            ['email' => 'siti@lapordong.id'],
            [
                'nama'          => 'Siti Rahayu',
                'password'      => Hash::make('petugas123'),
                'peran'         => 'petugas',
                'is_aktif'      => true,
                'nomor_telepon' => '08222222222',
                'total_poin'    => 0,
                'total_laporan' => 0,
            ]
        );

        // ----------------------------------------------------------------
        // 4. Akun Warga Demo
        // ----------------------------------------------------------------
        $warga1 = User::firstOrCreate(
            ['email' => 'warga@lapordong.id'],
            [
                'nama'          => 'Andi Pratama',
                'password'      => Hash::make('warga123'),
                'peran'         => 'warga',
                'is_aktif'      => true,
                'nomor_telepon' => '08133333333',
                'total_poin'    => 60,
                'total_laporan' => 2,
            ]
        );

        $warga2 = User::firstOrCreate(
            ['email' => 'dewi@lapordong.id'],
            [
                'nama'          => 'Dewi Lestari',
                'password'      => Hash::make('warga123'),
                'peran'         => 'warga',
                'is_aktif'      => true,
                'nomor_telepon' => '08144444444',
                'total_poin'    => 110,
                'total_laporan' => 3,
            ]
        );

        // ----------------------------------------------------------------
        // 5. Laporan Demo (hanya buat jika belum ada)
        // ----------------------------------------------------------------
        if (Laporan::count() === 0) {
            $laporanContoh = [
                [
                    'pelapor_id'    => $warga1->id,
                    'petugas_id'    => $petugas1->id,
                    'judul'         => 'Jalan berlubang besar di Jl. Soekarno Hatta',
                    'deskripsi'     => 'Terdapat lubang dengan diameter sekitar 50cm dan kedalaman 20cm di bahu jalan, sangat berbahaya bagi pengendara motor.',
                    'alamat_lengkap'=> 'Jl. Soekarno Hatta No. 123',
                    'kota'          => 'Bandung',
                    'provinsi'      => 'Jawa Barat',
                    'latitude'      => -6.9175,
                    'longitude'     => 107.6191,
                    'status'        => 'selesai',
                    'prioritas_ai'  => 'tinggi',
                    'skor_keparahan'=> 85,
                    'estimasi_hari' => 3,
                    'catatan_ai'    => 'Kerusakan parah dengan risiko kecelakaan tinggi.',
                ],
                [
                    'pelapor_id'    => $warga1->id,
                    'petugas_id'    => null,
                    'judul'         => 'Aspal retak-retak di Jl. Pasteur',
                    'deskripsi'     => 'Permukaan aspal mengalami retak buaya sepanjang kurang lebih 10 meter.',
                    'alamat_lengkap'=> 'Jl. Dr. Djundjunan (Pasteur) Km 5',
                    'kota'          => 'Bandung',
                    'provinsi'      => 'Jawa Barat',
                    'latitude'      => -6.8876,
                    'longitude'     => 107.5942,
                    'status'        => 'dikirim',
                    'prioritas_ai'  => 'sedang',
                    'skor_keparahan'=> 55,
                    'estimasi_hari' => 7,
                    'catatan_ai'    => 'Kerusakan sedang, perlu penanganan sebelum makin parah.',
                ],
                [
                    'pelapor_id'    => $warga2->id,
                    'petugas_id'    => $petugas2->id,
                    'judul'         => 'Jalan ambles dekat persimpangan',
                    'deskripsi'     => 'Jalan mengalami penurunan permukaan (ambles) sekitar 15cm di dekat persimpangan lampu merah.',
                    'alamat_lengkap'=> 'Jl. Asia Afrika Persimpangan Alun-Alun',
                    'kota'          => 'Bandung',
                    'provinsi'      => 'Jawa Barat',
                    'latitude'      => -6.9215,
                    'longitude'     => 107.6069,
                    'status'        => 'diproses',
                    'prioritas_ai'  => 'tinggi',
                    'skor_keparahan'=> 90,
                    'estimasi_hari' => 2,
                    'catatan_ai'    => 'Ambles jalan sangat berbahaya, prioritas tertinggi.',
                ],
                [
                    'pelapor_id'    => $warga2->id,
                    'petugas_id'    => null,
                    'judul'         => 'Marka jalan hilang tidak terlihat',
                    'deskripsi'     => 'Marka jalan di tikungan sudah sangat pudar dan tidak terlihat, rawan kecelakaan malam hari.',
                    'alamat_lengkap'=> 'Jl. Buah Batu, dekat Stadion',
                    'kota'          => 'Bandung',
                    'provinsi'      => 'Jawa Barat',
                    'latitude'      => -6.9355,
                    'longitude'     => 107.6347,
                    'status'        => 'diverifikasi',
                    'prioritas_ai'  => 'rendah',
                    'skor_keparahan'=> 30,
                    'estimasi_hari' => 14,
                    'catatan_ai'    => 'Perlu pengecatan ulang marka jalan.',
                ],
                [
                    'pelapor_id'    => $warga2->id,
                    'petugas_id'    => null,
                    'judul'         => 'Drainase jalan tersumbat menggenang',
                    'deskripsi'     => 'Saluran drainase di pinggir jalan tersumbat sampah sehingga air menggenangi jalan saat hujan.',
                    'alamat_lengkap'=> 'Jl. Riau No. 45',
                    'kota'          => 'Bandung',
                    'provinsi'      => 'Jawa Barat',
                    'latitude'      => -6.9061,
                    'longitude'     => 107.6289,
                    'status'        => 'dikirim',
                    'prioritas_ai'  => 'sedang',
                    'skor_keparahan'=> 60,
                    'estimasi_hari' => 5,
                    'catatan_ai'    => 'Genangan air merusak jalan secara bertahap.',
                ],
            ];

            foreach ($laporanContoh as $data) {
                Laporan::create($data);
            }
        }

        // ----------------------------------------------------------------
        // 6. Badge untuk warga demo
        // ----------------------------------------------------------------
        $badgePerdana = Badge::where('syarat', 'laporan_1')->first();
        if ($badgePerdana) {
            $warga1->badge()->syncWithoutDetaching([$badgePerdana->id]);
            $warga2->badge()->syncWithoutDetaching([$badgePerdana->id]);
        }

        $this->command->info('✅ Seed selesai!');
        $this->command->info('---');
        $this->command->info('👤 Admin     : admin@lapordong.id / admin123');
        $this->command->info('👷 Petugas 1 : budi@lapordong.id / petugas123');
        $this->command->info('👷 Petugas 2 : siti@lapordong.id / petugas123');
        $this->command->info('🧑 Warga 1   : warga@lapordong.id / warga123');
        $this->command->info('🧑 Warga 2   : dewi@lapordong.id / warga123');
    }
}
