@extends('layouts.utama')
@section('judul', 'Profil Saya — LaporDong')

@section('konten')
<div style="min-height: 100vh; background: #F0F4FF; padding-bottom: 4rem;">

    {{-- HERO HEADER --}}
    <div style="background: linear-gradient(135deg, #1E3A8A 0%, #234A89 50%, #0EA5E9 100%); padding: 5rem 1.5rem 5rem; position: relative; overflow: hidden;">
        {{-- Decorative blobs --}}
        <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; border-radius: 50%; background: rgba(255,255,255,0.05);"></div>
        <div style="position: absolute; bottom: -80px; left: 5%; width: 300px; height: 300px; border-radius: 50%; background: rgba(255,255,255,0.04);"></div>

        <div style="max-width: 900px; margin: 0 auto; position: relative;">
            <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                {{-- Avatar --}}
                <div style="position: relative; flex-shrink: 0;">
                    <div style="width: 96px; height: 96px; border-radius: 24px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; color: white; border: 3px solid rgba(255,255,255,0.3); backdrop-filter: blur(10px);">
                        {{ strtoupper(substr($user->nama_lengkap ?? 'U', 0, 1)) }}
                    </div>
                    {{-- Level badge --}}
                    <div style="position: absolute; -bottom: 8px; -right: 8px; bottom: -8px; right: -8px; background: #F59E0B; border-radius: 10px; padding: 3px 8px; font-size: 0.7rem; font-weight: 800; color: white; white-space: nowrap;">
                        @php
                        $levelIcon = match($user->level) {
                            'Pahlawan Negara' => '🏆',
                            'Penjaga Infrastruktur'   => '🛡️',
                            'Pelapor Aktif'    => '⭐',
                            default   => '🌱',
                        };
                        @endphp
                        {{ $levelIcon }} {{ $user->level }}
                    </div>
                </div>

                {{-- Info utama --}}
                <div style="flex: 1; color: white;">
                    <h1 style="font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.25rem;">
                        {{ $user->nama_lengkap }}
                    </h1>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-bottom: 1rem;">{{ $user->email }}</p>

                    {{-- Stats pills --}}
                    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                        <div style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); padding: 0.375rem 1rem; border-radius: 100px; font-size: 0.85rem; font-weight: 600;">
                            🏅 {{ number_format($user->total_poin) }} Poin
                        </div>
                        <div style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); padding: 0.375rem 1rem; border-radius: 100px; font-size: 0.85rem; font-weight: 600;">
                            📋 {{ $user->total_laporan }} Laporan
                        </div>
                        @if($user->kota_domisili)
                        <div style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); padding: 0.375rem 1rem; border-radius: 100px; font-size: 0.85rem; font-weight: 600;">
                            📍 {{ $user->kota_domisili }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div style="max-width: 900px; margin: -2rem auto 0; padding: 0 1.5rem; position: relative; z-index: 10;">

        {{-- Flash messages --}}
        @if(session('sukses'))
        <div style="background: #ECFDF5; border: 1px solid #6EE7B7; color: #065F46; padding: 0.875rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 500;">
            ✅ {{ session('sukses') }}
        </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1.6fr; gap: 1.5rem;">

            {{-- KOLOM KIRI --}}
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                {{-- Edit Profil --}}
                <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">
                    <h2 style="font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: #1E3A8A; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                        ✏️ Edit Profil
                    </h2>
                    <form method="POST" action="{{ route('dasbor.profil.update') }}">
                        @csrf @method('PATCH')
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 600; color: #374151; display: block; margin-bottom: 0.375rem;">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $user->nama_lengkap) }}"
                                    style="width: 100%; padding: 0.625rem 0.875rem; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 0.875rem; outline: none; box-sizing: border-box; transition: border 0.2s;"
                                    onfocus="this.style.borderColor='#234A89'" onblur="this.style.borderColor='#E5E7EB'">
                                @error('nama')<p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 600; color: #374151; display: block; margin-bottom: 0.375rem;">Nomor Telepon</label>
                                <input type="tel" name="nomor_telepon" value="{{ old('nomor_telepon', $user->no_telepon) }}"
                                    placeholder="08xx-xxxx-xxxx"
                                    style="width: 100%; padding: 0.625rem 0.875rem; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 0.875rem; outline: none; box-sizing: border-box;"
                                    onfocus="this.style.borderColor='#234A89'" onblur="this.style.borderColor='#E5E7EB'">
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 600; color: #374151; display: block; margin-bottom: 0.375rem;">Email</label>
                                <input type="email" value="{{ $user->email }}" disabled
                                    style="width: 100%; padding: 0.625rem 0.875rem; border: 1.5px solid #F3F4F6; border-radius: 10px; font-size: 0.875rem; background: #F9FAFB; color: #9CA3AF; box-sizing: border-box;">
                                <p style="font-size: 0.75rem; color: #9CA3AF; margin-top: 0.25rem;">Email tidak dapat diubah</p>
                            </div>
                            <button type="submit"
                                style="width: 100%; padding: 0.75rem; background: linear-gradient(135deg, #234A89, #0EA5E9); color: white; border: none; border-radius: 10px; font-size: 0.875rem; font-weight: 700; cursor: pointer;">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Ubah Password --}}
                <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">
                    <h2 style="font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: #1E3A8A; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                        🔒 Ubah Password
                    </h2>
                    <form method="POST" action="{{ route('dasbor.profil.password') }}">
                        @csrf @method('PATCH')
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 600; color: #374151; display: block; margin-bottom: 0.375rem;">Password Lama</label>
                                <input type="password" name="password_lama"
                                    style="width: 100%; padding: 0.625rem 0.875rem; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 0.875rem; outline: none; box-sizing: border-box;"
                                    onfocus="this.style.borderColor='#234A89'" onblur="this.style.borderColor='#E5E7EB'">
                                @error('password_lama')<p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 600; color: #374151; display: block; margin-bottom: 0.375rem;">Password Baru</label>
                                <input type="password" name="password_baru"
                                    style="width: 100%; padding: 0.625rem 0.875rem; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 0.875rem; outline: none; box-sizing: border-box;"
                                    onfocus="this.style.borderColor='#234A89'" onblur="this.style.borderColor='#E5E7EB'">
                                @error('password_baru')<p style="color: #DC2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; font-weight: 600; color: #374151; display: block; margin-bottom: 0.375rem;">Konfirmasi Password Baru</label>
                                <input type="password" name="password_baru_confirmation"
                                    style="width: 100%; padding: 0.625rem 0.875rem; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 0.875rem; outline: none; box-sizing: border-box;"
                                    onfocus="this.style.borderColor='#234A89'" onblur="this.style.borderColor='#E5E7EB'">
                            </div>
                            <button type="submit"
                                style="width: 100%; padding: 0.75rem; background: white; color: #234A89; border: 2px solid #234A89; border-radius: 10px; font-size: 0.875rem; font-weight: 700; cursor: pointer;">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- KOLOM KANAN --}}
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                {{-- Level Progress --}}
                <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">
                    <h2 style="font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: #1E3A8A; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                        🎯 Progress Level
                    </h2>
                    @php
                        $levels = [
                            ['min' => 0,  'max' => 499,  'nama' => 'Pengamat Jalan', 'icon' => '🌱'],
                            ['min' => 500,  'max' => 1999, 'nama' => 'Warga Aktif',  'icon' => '⭐'],
                            ['min' => 2000, 'max' => 4999, 'nama' => 'Penjaga Kota', 'icon' => '🛡️'],
                            ['min' => 5000, 'max' => 9999, 'nama' => 'Pahlawan Jalan','icon' => '🏆'],
                        ];
                        $currentLevelIdx = 0;
                        foreach ($levels as $idx => $l) {
                            if ($user->total_poin >= $l['min']) $currentLevelIdx = $idx;
                        }
                        $level = $levels[$currentLevelIdx];
                        $nextLevel = $levels[$currentLevelIdx + 1] ?? null;
                        $progressPersen = $nextLevel
                            ? min(100, round((($user->total_poin - $level['min']) / ($level['max'] - $level['min'])) * 100))
                            : 100;
                    @endphp

                    {{-- Current level display --}}
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border-radius: 14px; background: linear-gradient(135deg, #EEF2FF, #E0F2FE); margin-bottom: 1.25rem;">
                        <div style="font-size: 2.5rem;">{{ $level['icon'] }}</div>
                        <div>
                            <div style="font-weight: 800; font-size: 1.125rem; color: #1E3A8A;">{{ $level['nama'] }}</div>
                            <div style="font-size: 0.8rem; color: #6B7280;">{{ number_format($user->total_poin) }} poin terkumpul</div>
                        </div>
                    </div>

                    {{-- Progress bar --}}
                    @if($nextLevel)
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 0.5rem;">
                            <span style="color: #6B7280;">Menuju {{ $nextLevel['nama'] }} {{ $nextLevel['icon'] }}</span>
                            <span style="font-weight: 700; color: #234A89;">{{ $progressPersen }}%</span>
                        </div>
                        <div style="height: 10px; border-radius: 100px; background: #E5E7EB; overflow: hidden;">
                            <div style="height: 10px; border-radius: 100px; width: {{ $progressPersen }}%; background: linear-gradient(90deg, #234A89, #0EA5E9); transition: width 1s ease;"></div>
                        </div>
                        <div style="font-size: 0.75rem; color: #9CA3AF; margin-top: 0.375rem;">
                            {{ number_format($nextLevel['min'] - $user->total_poin) }} poin lagi untuk naik level
                        </div>
                    </div>
                    @endif

                    {{-- Level roadmap --}}
                    <div style="display: flex; justify-content: space-between; margin-top: 0.5rem;">
                        @foreach($levels as $idx => $l)
                        <div style="text-align: center; flex: 1;">
                            <div style="font-size: 1.25rem; {{ $idx <= $currentLevelIdx ? '' : 'opacity: 0.3; filter: grayscale(1);' }}">{{ $l['icon'] }}</div>
                            <div style="font-size: 0.65rem; margin-top: 0.25rem; color: {{ $idx <= $currentLevelIdx ? '#234A89' : '#9CA3AF' }}; font-weight: {{ $idx === $currentLevelIdx ? '700' : '400' }};">{{ $l['nama'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Badge Collection --}}
                <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">
                    <h2 style="font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: #1E3A8A; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                        🏅 Koleksi Badge
                    </h2>
                    @php
                        $semua_badge = \App\Models\Badge::all();
                        $badge_milik = $user->badge->pluck('id')->toArray();
                    @endphp
                    @if($semua_badge->isEmpty())
                        <p style="text-align: center; color: #9CA3AF; padding: 2rem 0; font-size: 0.875rem;">Belum ada badge tersedia</p>
                    @else
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.875rem;">
                        @foreach($semua_badge as $badge)
                            @php $dimiliki = in_array($badge->id, $badge_milik); @endphp
                            <div style="text-align: center; padding: 1rem 0.5rem; border-radius: 14px; border: 1.5px solid {{ $dimiliki ? '#BFDBFE' : '#F3F4F6' }}; background: {{ $dimiliki ? 'linear-gradient(135deg, #EEF2FF, #E0F2FE)' : '#F9FAFB' }}; {{ $dimiliki ? '' : 'opacity: 0.5; filter: grayscale(0.8);' }}">
                                <div style="font-size: 2rem; margin-bottom: 0.375rem;">{{ $badge->ikon }}</div>
                                <div style="font-size: 0.75rem; font-weight: 700; color: {{ $dimiliki ? '#1E40AF' : '#6B7280' }}; line-height: 1.3;">{{ $badge->nama }}</div>
                                @if($dimiliki)
                                    <div style="margin-top: 0.375rem; font-size: 0.65rem; background: #DBEAFE; color: #1E40AF; padding: 2px 8px; border-radius: 100px; display: inline-block; font-weight: 600;">✓ Dimiliki</div>
                                @else
                                    <div style="margin-top: 0.375rem; font-size: 0.65rem; color: #9CA3AF;">{{ $badge->syarat_poin > 0 ? $badge->syarat_poin . ' poin' : ($badge->syarat_laporan . ' laporan') }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Riwayat Aktivitas --}}
                <div style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">
                    <h2 style="font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: #1E3A8A; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                        📜 Riwayat Aktivitas
                    </h2>
                    @if($riwayatAktivitas->isEmpty())
                        <div style="text-align: center; padding: 2rem 0;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📭</div>
                            <p style="color: #9CA3AF; font-size: 0.875rem;">Belum ada aktivitas</p>
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 0.625rem;">
                            @foreach($riwayatAktivitas as $aktivitas)
                            <div style="display: flex; align-items: center; gap: 0.875rem; padding: 0.875rem; border-radius: 12px; background: #F9FAFB;">
                                <div style="width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; background: {{ $aktivitas->poin > 0 ? '#DBEAFE' : '#FEE2E2' }};">
                                    {{ $aktivitas->poin > 0 ? '➕' : '➖' }}
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <p style="font-size: 0.8125rem; font-weight: 500; color: #1F2937; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $aktivitas->keterangan }}</p>
                                    <p style="font-size: 0.75rem; color: #9CA3AF;">{{ $aktivitas->created_at->diffForHumans() }}</p>
                                </div>
                                <span style="font-weight: 800; font-size: 0.875rem; color: {{ $aktivitas->poin > 0 ? '#059669' : '#DC2626' }}; flex-shrink: 0;">
                                    {{ $aktivitas->poin > 0 ? '+' : '' }}{{ $aktivitas->poin }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection