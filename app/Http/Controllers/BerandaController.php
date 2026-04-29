<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;

/**
 * BerandaController
 * Menangani halaman publik: beranda, lacak laporan, dan statistik nasional.
 */
class BerandaController extends Controller
{
    // ----------------------------------------------------------------
    // Halaman Beranda
    // ----------------------------------------------------------------
    public function tampilkan()
    {
        $selesai = Laporan::where('status', 'selesai')->count();
        $total   = Laporan::count();

        $statistikPublik = [
            'total_laporan'     => $total,
            'laporan_selesai'   => $selesai,
            'kota_terlayani'    => Laporan::distinct('kota')->count('kota'),
            'rata_penyelesaian' => $total > 0 ? round(($selesai / $total) * 100) . '%' : '0%',
        ];

        $laporanTerbaru = Laporan::with('pelapor')
            ->whereIn('status', ['diproses', 'selesai'])
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        $langkah     = $this->langkah();
        $fiturAi     = $this->fiturAi();
        $contohBadge = $this->contohBadge();

        return view('pages.beranda', compact(
            'statistikPublik',
            'laporanTerbaru',
            'langkah',
            'fiturAi',
            'contohBadge'
        ));
    }

    // ----------------------------------------------------------------
    // Lacak Laporan Publik
    // ----------------------------------------------------------------
    public function lacakPublik(Request $request)
    {
        $kode    = $request->kode ? strtoupper(trim($request->kode)) : null;
        $laporan = null;

        if ($kode) {
            $laporan = Laporan::with(['riwayatStatus', 'petugas'])
                ->where('kode_laporan', $kode)
                ->first();
        }

        return view('pages.laporan.lacak', compact('kode', 'laporan'));
    }

    // ----------------------------------------------------------------
    // Statistik Publik Nasional
    // ----------------------------------------------------------------
    public function statistikPublik()
    {
        $stats = [
            'total'    => Laporan::count(),
            'selesai'  => Laporan::where('status', 'selesai')->count(),
            'diproses' => Laporan::where('status', 'diproses')->count(),
            'tinggi'   => Laporan::where('prioritas_ai', 'tinggi')->count(),
        ];

        $byStatus = Laporan::select('status', DB::raw('count(*) as jumlah'))
            ->groupBy('status')
            ->get();

        $byPrioritas = Laporan::select('prioritas_ai', DB::raw('count(*) as jumlah'))
            ->whereNotNull('prioritas_ai')
            ->groupBy('prioritas_ai')
            ->get();

        $byProvinsi = Laporan::select(
                'provinsi',
                DB::raw('count(*) as total'),
                DB::raw('sum(case when status="selesai" then 1 else 0 end) as selesai'),
                DB::raw('sum(case when status="diproses" then 1 else 0 end) as diproses'),
                DB::raw('sum(case when prioritas_ai="tinggi" then 1 else 0 end) as tinggi')
            )
            ->groupBy('provinsi')
            ->orderByDesc('total')
            ->get();

        return view('pages.statistik', compact('stats', 'byStatus', 'byPrioritas', 'byProvinsi'));
    }

    // ----------------------------------------------------------------
    // Data Statis (dipindahkan dari @php di beranda.blade.php)
    // ----------------------------------------------------------------

    private function langkah(): array
    {
        return [
            [
                'ikon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#234A89" class="bi bi-camera-fill" viewBox="0 0 16 16">
                <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0"/>
                </svg>',
                'nomor' => '01',
                'judul' => 'Foto & Kirim',
                'desc'  => 'Ambil foto kerusakan jalan dan lengkapi informasi lokasi yang otomatis terdeteksi melalui GPS.',
            ],
            [
                'ikon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#234A89" class="bi bi-robot" viewBox="0 0 16 16">
                <path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5M3 8.062C3 6.76 4.235 5.765 5.53 5.886a26.6 26.6 0 0 0 4.94 0C11.765 5.765 13 6.76 13 8.062v1.157a.93.93 0 0 1-.765.935c-.845.147-2.34.346-4.235.346s-3.39-.2-4.235-.346A.93.93 0 0 1 3 9.219zm4.542-.827a.25.25 0 0 0-.217.068l-.92.9a25 25 0 0 1-1.871-.183.25.25 0 0 0-.068.495c.55.076 1.232.149 2.02.193a.25.25 0 0 0 .189-.071l.754-.736.847 1.71a.25.25 0 0 0 .404.062l.932-.97a25 25 0 0 0 1.922-.188.25.25 0 0 0-.068-.495c-.538.074-1.207.145-1.98.189a.25.25 0 0 0-.166.076l-.754.785-.842-1.7a.25.25 0 0 0-.182-.135"/>
                <path d="M8.5 1.866a1 1 0 1 0-1 0V3h-2A4.5 4.5 0 0 0 1 7.5V8a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v1a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-1a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1v-.5A4.5 4.5 0 0 0 10.5 3h-2zM14 7.5V13a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7.5A3.5 3.5 0 0 1 5.5 4h5A3.5 3.5 0 0 1 14 7.5"/>
                </svg>',
                'nomor' => '02',
                'judul' => 'AI Analisis',
                'desc'  => 'AI memverifikasi kondisi dan menentukan tingkat urgensi perbaikan.',
            ],
            [
                'ikon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#234A89" class="bi bi-wrench" viewBox="0 0 16 16">
                <path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/>
                </svg>',
                'nomor' => '03',
                'judul' => 'Penanganan',
                'desc'  => 'Pemerintah menugaskan petugas lapangan sesuai prioritas dan mulai melakukan perbaikan.',
            ],
            [
                'ikon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#234A89" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                </svg>',
                'nomor' => '04',
                'judul' => 'Selesai & Ulasan',
                'desc'  => 'Setelah perbaikan selesai, laporan selesai dengan bukti foto. Pengguna dapat memberikan rating dan ulasan.',
            ],
        ];
    }

    private function fiturAi(): array
    {
        return [
            [
                'ikon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>',
                'judul' => 'Validasi Foto Otomatis',
                'desc'  => 'AI memastikan foto yang dikirim benar menunjukkan kerusakan jalan.',
            ],
            [
                'ikon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-lightning-charge-fill" viewBox="0 0 16 16">
                <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
                </svg>',
                'judul' => 'Sistem Prioritas Deadline Perbaikan',
                'desc'  => 'Laporan dibagi menjadi tiga prioritas: tinggi, sedang, dan rendah.',
            ],
            [
                'ikon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/>
                </svg>',
                'judul' => 'Skor Keparahan',
                'desc'  => 'AI memberi skor tingkat kerusakan secara otomatis.',
            ],
        ];
    }

    private function contohBadge(): array
    {
        return [
            [
                'ikon' => asset('images/Pengamat_Jalan.png'),
                'nama' => 'Pengamat Jalan',
                'syarat' => 'Level 1'
            ],
            [
                'ikon' => asset('images/Pelapor_Aktif.png'),
                'nama' => 'Pelapor Aktif',
                'syarat' => 'Level 2'
            ],
            [
                'ikon' => asset('images/Penjaga_Infrastruktur.png'),
                'nama' => 'Penjaga Infrastruktur',
                'syarat' => 'Level 3'
            ],
            [
                'ikon' => asset('images/Pahlawan_Negara.png'),
                'nama' => 'Pahlawan Negara',
                'syarat' => 'Level 4'
            ],
        ];
    }
}