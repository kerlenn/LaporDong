<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Laporan;

/**
 * DasborController
 * Dashboard warga dan manajemen profil.
 */
class DasborController extends Controller
{
    public function warga()
    {
        $warga = auth()->user();

        $ringkasanStats = [
            'total'    => Laporan::where('pelapor_id', $warga->id)->count(),
            'diproses' => Laporan::where('pelapor_id', $warga->id)->where('status', 'diproses')->count(),
            'selesai'  => Laporan::where('pelapor_id', $warga->id)->where('status', 'selesai')->count(),
            'poin'     => $warga->total_poin,
        ];

        $laporanTerbaru = Laporan::where('pelapor_id', $warga->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $pengguna = $warga;
        $ringkasan = $ringkasanStats;
        $laporanTerkini = $laporanTerbaru;
        return view('pages.dashboard.warga', compact('pengguna', 'ringkasan', 'laporanTerkini'));
    }

    public function profil()
    {
        $user = auth()->user();

        $riwayatAktivitas = \App\Models\RiwayatStatus::whereHas('laporan', function ($q) use ($user) {
                $q->where('pelapor_id', $user->id);
            })
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function ($riwayat) {
                if ($riwayat->status_baru === 'dikirim') {
                    return (object)['poin' => 10, 'keterangan' => 'Laporan dikirim: '.$riwayat->laporan->judul, 'created_at' => $riwayat->created_at];
                }
                if ($riwayat->status_baru === 'selesai') {
                    return (object)['poin' => 50, 'keterangan' => 'Laporan selesai: '.$riwayat->laporan->judul, 'created_at' => $riwayat->created_at];
                }
                return null;
            })
            ->filter()->values();

        return view('pages.dashboard.profil', compact('user', 'riwayatAktivitas'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        auth()->user()->update([
            'nama'          => $request->nama,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return back()->with('sukses', 'Profil berhasil diperbarui!');
    }

    public function ubahPassword(Request $request)
    {
        $request->validate([
            'password_lama' => ['required', function ($attr, $val, $fail) {
                if (!Hash::check($val, auth()->user()->password)) {
                    $fail('Password lama tidak sesuai.');
                }
            }],
            'password_baru' => ['required', 'confirmed', Password::min(8)],
        ]);

        auth()->user()->update(['password' => Hash::make($request->password_baru)]);

        return back()->with('sukses', 'Password berhasil diubah!');
    }
}
