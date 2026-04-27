<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Services\LaporanService;

/**
 * LaporanController
 * Menangani CRUD laporan oleh warga, termasuk pengiriman, detail, dan ulasan.
 */
class LaporanController extends Controller
{
    public function __construct(
        protected LaporanService $laporanService
    ) {}

    // ----------------------------------------------------------------
    // Daftar laporan milik warga yang sedang login
    // ----------------------------------------------------------------
    public function daftarSaya(Request $request)
    {
        $laporan = Laporan::where('pelapor_id', auth()->id())
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->cari, fn($q, $c) => $q->where(function($sub) use ($c) {
                $sub->where('judul', 'like', "%{$c}%")
                    ->orWhere('kode_laporan', 'like', "%{$c}%");
            }))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pages.laporan.daftar-saya', compact('laporan'));
    }

    // ----------------------------------------------------------------
    // Form buat laporan baru
    // ----------------------------------------------------------------
    public function formBuat()
    {
        return view('pages.laporan.buat');
    }

    // ----------------------------------------------------------------
    // Kirim laporan baru
    // ----------------------------------------------------------------
    public function kirim(Request $request)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|min:10|max:255',
            'deskripsi'      => 'required|string|min:20',
            'alamat_lengkap' => 'required|string|max:500',
            'kota'           => 'required|string|max:100',
            'provinsi'       => 'required|string|max:100',
            'latitude'       => 'nullable|numeric|between:-90,90',
            'longitude'      => 'nullable|numeric|between:-180,180',
            'kelurahan'      => 'required|string|max:100',
            'kecamatan'      => 'required|string|max:100',
            'kode_pos'       => 'nullable|string|max:10',
            'foto_sebelum'   => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $laporan = $this->laporanService->buatLaporan(
    auth()->user(),
    $validated,
    [$request->file('foto_sebelum')]
);

        return redirect()
            ->route('laporan.detail', $laporan)
            ->with('sukses', "Laporan {$laporan->kode_laporan} berhasil dikirim! +10 poin diperoleh.");
    }

    // ----------------------------------------------------------------
    // Detail laporan
    // ----------------------------------------------------------------
    public function detail(Laporan $laporan)
    {
        // Warga hanya bisa lihat laporan mereka sendiri; admin/petugas bisa semua
        if (auth()->user()->peran === 'warga' && $laporan->pelapor_id !== auth()->id()) {
            abort(403, 'Kamu tidak memiliki akses ke laporan ini.');
        }

        $laporan->load(['pelapor', 'petugas', 'riwayatStatus', 'ulasan']);

        return view('pages.laporan.detail', compact('laporan'));
    }

    // ----------------------------------------------------------------
    // Form ulasan (hanya untuk laporan yang sudah selesai)
    // ----------------------------------------------------------------
    public function formUlasan(Laporan $laporan)
    {
        if ($laporan->pelapor_id !== auth()->id()) {
            abort(403);
        }

        if ($laporan->status !== 'selesai') {
            return back()->with('error', 'Ulasan hanya bisa diberikan untuk laporan yang sudah selesai.');
        }

        if ($laporan->ulasan) {
            return back()->with('info', 'Kamu sudah memberikan ulasan untuk laporan ini.');
        }

        return view('pages.laporan.ulasan', compact('laporan'));
    }

    // ----------------------------------------------------------------
    // Simpan ulasan
    // ----------------------------------------------------------------
    public function simpanUlasan(Request $request, Laporan $laporan)
    {
        if ($laporan->pelapor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'bintang'   => 'required|integer|min:1|max:5',
            'komentar'  => 'nullable|string|max:1000',
            'is_anonim' => 'sometimes|boolean',
        ]);

        $laporan->ulasan()->create([
            'pelapor_id' => auth()->id(),
            'bintang'    => $request->bintang,
            'komentar'   => $request->komentar,
            'is_anonim'  => $request->boolean('is_anonim'),
        ]);

        return redirect()
            ->route('laporan.detail', $laporan)
            ->with('sukses', 'Terima kasih! Ulasanmu telah disimpan. 🌟');
    }
}
