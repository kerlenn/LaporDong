<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\UlasanLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EksplorasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with(['pelapor', 'ulasan'])
            ->whereNotIn('status', ['ditolak']);

        // Filter kota
        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }

        // Filter provinsi
        if ($request->filled('provinsi')) {
            $query->where('provinsi', $request->provinsi);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search judul/alamat
        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('alamat_lengkap', 'like', '%' . $request->cari . '%')
                  ->orWhere('kota', 'like', '%' . $request->cari . '%');
            });
        }

        // Sort
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'tertua'    => $query->oldest(),
            'bintang'   => $query->leftJoin('ulasan_laporan', 'laporan.id', '=', 'ulasan_laporan.laporan_id')
                                  ->orderByDesc('ulasan_laporan.bintang')
                                  ->select('laporan.*'),
            default     => $query->latest(),
        };

        $laporan = $query->paginate(12)->withQueryString();

        // Data untuk filter dropdown
        $daftarKota = Laporan::whereNotIn('status', ['ditolak'])
            ->select('kota')->distinct()->orderBy('kota')->pluck('kota');

        $daftarProvinsi = Laporan::whereNotIn('status', ['ditolak'])
            ->select('provinsi')->distinct()->orderBy('provinsi')->pluck('provinsi');

        return view('pages.eksplorasi.index', compact(
            'laporan', 'daftarKota', 'daftarProvinsi'
        ));
    }

    public function simpanKomentar(Request $request, Laporan $laporan)
    {
        // Hanya laporan selesai yang bisa diulas
        if ($laporan->status !== 'selesai') {
            return back()->with('error', 'Hanya laporan yang sudah selesai yang bisa diberi ulasan.');
        }

        // Cek sudah pernah ulasan belum
        $sudahUlasan = UlasanLaporan::where('laporan_id', $laporan->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($sudahUlasan) {
            return back()->with('error', 'Kamu sudah memberikan ulasan untuk laporan ini.');
        }

        $request->validate([
            'bintang'   => 'required|integer|min:1|max:5',
            'komentar'  => 'nullable|string|max:500',
            'is_anonim' => 'sometimes|boolean',
        ]);

        UlasanLaporan::create([
            'laporan_id' => $laporan->id,
            'user_id'    => auth()->id(),
            'bintang'    => $request->bintang,
            'komentar'   => $request->komentar,
            'is_anonim'  => $request->boolean('is_anonim'),
        ]);

        // Tambah poin
        auth()->user()->tambahPoin(5);

        return back()->with('sukses', 'Ulasanmu berhasil disimpan! +5 poin 🌟');
    }
}
