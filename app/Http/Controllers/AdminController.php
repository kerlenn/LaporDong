<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use App\Services\LaporanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * AdminController — panel kendali untuk admin & petugas lapangan.
 * Mengelola verifikasi, penugasan, dan pembaruan status laporan.
 */
class AdminController extends Controller
{
    public function __construct(private readonly LaporanService $laporanService) {}

    /**
     * Dashboard admin dengan statistik ringkas.
     */
    public function dasbor(): View
    {
        $statistik = [
            'total'          => Laporan::count(),
            'menunggu'       => Laporan::where('status', Laporan::STATUS_DIKIRIM)->count(),
            'diproses'       => Laporan::where('status', Laporan::STATUS_DIPROSES)->count(),
            'selesai_bulan'  => Laporan::where('status', Laporan::STATUS_SELESAI)
                ->whereMonth('tanggal_selesai', now()->month)->count(),
            'petugas_aktif'  => Laporan::where('prioritas_ai', Laporan::PRIORITAS_TINGGI)
                ->whereNotIn('status', [Laporan::STATUS_SELESAI, Laporan::STATUS_DITOLAK])->count(),
        ];

        $laporanTerbaru = Laporan::with(['pelapor', 'petugas'])
            ->latest()
            ->take(8)
            ->get();

        $petugasAktif = User::where('peran', User::PERAN_PETUGAS)
            ->where('is_aktif', true)
            ->withCount(['tugasSaya as tugas_aktif' => function ($q) {
                $q->whereIn('status', [Laporan::STATUS_DIVERIFIKASI, Laporan::STATUS_DIPROSES]);
            }])
            ->get();

        $stats = $statistik;
return view('pages.admin.dasbor', compact('stats', 'laporanTerbaru', 'petugasAktif'));
    }

    /**
     * Daftar semua laporan dengan filter & sorting.
     */
    public function daftarLaporan(Request $request): View
    {
        $query = Laporan::with(['pelapor', 'petugas'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('prioritas')) {
            $query->where('prioritas_ai', $request->prioritas);
        }
        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }
        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_laporan', 'like', '%' . $request->cari . '%')
                  ->orWhere('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('alamat_lengkap', 'like', '%' . $request->cari . '%');
            });
        }

        $laporan = $query->paginate(15)->withQueryString();

$semuaPetugas = User::where('peran', 'petugas')
    ->where('is_aktif', true)
    ->get();

return view('pages.admin.daftar-laporan', compact('laporan', 'semuaPetugas'));
    }

    /**
     * Verifikasi atau tolak laporan yang masuk.
     */
    public function verifikasiLaporan(Request $request, Laporan $laporan): RedirectResponse
    {
        $request->validate([
            'aksi'    => 'required|in:verifikasi,tolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        $statusBaru = $request->aksi === 'verifikasi'
            ? Laporan::STATUS_DIVERIFIKASI
            : Laporan::STATUS_DITOLAK;

        $this->laporanService->perbaruiStatus($laporan, $statusBaru, Auth::user(), $request->catatan);

        return back()->with('sukses', 'Status laporan berhasil diperbarui.');
    }

    /**
     * Tugaskan laporan ke petugas lapangan.
     */
    public function tugaskanPetugas(Request $request, Laporan $laporan): RedirectResponse
    {
        $request->validate([
            'petugas_id' => 'required|exists:users,id',
            'catatan'    => 'nullable|string|max:500',
        ]);

        $laporan->update(['petugas_id' => $request->petugas_id]);

        $this->laporanService->perbaruiStatus(
            $laporan,
            Laporan::STATUS_DIPROSES,
            Auth::user(),
            $request->catatan ?? 'Laporan ditugaskan ke petugas lapangan.'
        );

        return back()->with('sukses', 'Petugas berhasil ditugaskan.');
    }

    /**
     * Petugas mengunggah foto sesudah & menyelesaikan laporan.
     */
    public function selesaikanLaporan(Request $request, Laporan $laporan): RedirectResponse
    {
        $request->validate([
            'foto_sesudah'   => 'required|array|min:1|max:5',
            'foto_sesudah.*' => 'image|mimes:jpeg,png,webp|max:5120',
            'catatan_petugas' => 'nullable|string|max:1000',
        ]);

        $this->laporanService->unggahFotoSesudah($laporan, $request->file('foto_sesudah'));

        $laporan->update(['catatan_petugas' => $request->catatan_petugas]);

        $this->laporanService->perbaruiStatus(
            $laporan,
            Laporan::STATUS_SELESAI,
            Auth::user(),
            'Perbaikan selesai dilakukan di lapangan.'
        );

        return back()->with('sukses', 'Laporan berhasil diselesaikan! Pelapor akan mendapatkan notifikasi.');
    }
}
