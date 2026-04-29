<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * AuthController — autentikasi pengguna (registrasi, masuk, keluar).
 * Mendukung tiga peran: warga, petugas, dan admin.
 */
class AuthController extends Controller
{
    public function formMasuk(): View
    {
        return view('pages.auth.masuk');
    }

    public function masuk(Request $request): RedirectResponse
    {
        $kredensial = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($kredensial, $request->boolean('ingat_saya'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password tidak sesuai.']);
        }

        if (!Auth::user()->is_aktif) {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi admin.']);
        }

        $request->session()->regenerate();

        return $this->arahanSesuaiPeran(Auth::user());
    }

    public function formDaftar(): View
    {
        return view('pages.auth.daftar');
    }

    public function daftar(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:150',
            'email'        => 'required|email|unique:users,email',
            'no_telepon'   => 'nullable|string|max:20',
            'kota_domisili' => 'nullable|string|max:100',
            'password'     => 'required|string|min:8|confirmed',
        ]);

        $pengguna = User::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
            'no_telepon'    => $request->no_telepon,
            'kota_domisili' => $request->kota_domisili,
            'password'      => Hash::make($request->password),
            'peran'         => User::PERAN_WARGA,
            'is_aktif'      => true,
            'total_poin'    => 0,
            'total_laporan' => 0,
        ]);

        Auth::login($pengguna);

        return redirect()->route('dasbor.warga')
            ->with('sukses', "Selamat datang, {$pengguna->nama_lengkap}! Akun berhasil dibuat.");
    }

    public function keluar(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda')->with('sukses', 'Anda berhasil keluar.');
    }

    private function arahanSesuaiPeran(User $pengguna): RedirectResponse
    {
        $peran = strtolower($pengguna->peran);

        return match ($peran) {
            'admin', 'petugas' => redirect()->route('admin.dasbor'),
            default            => redirect()->route('dasbor.warga'),
        };
    }
}
