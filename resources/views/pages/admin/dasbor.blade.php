@extends('layouts.utama')

@section('judul', 'Dashboard Admin')

@section('konten')
<section class="py-8 px-4 min-h-screen" style="background: var(--warna-latar);">
    <div class="max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-8" data-animate="fadeUp">
            <h1 class="text-3xl font-bold" style="color: var(--warna-indigo); font-family: var(--font-display);">
                Dashboard Admin
            </h1>
            <p style="color: var(--warna-teks-muted);">
                Selamat datang, <strong>{{ auth()->user()->nama }}</strong> —
                {{ now()->isoFormat('dddd, D MMMM Y') }}
            </p>
        </div>

        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8" data-animate-grid>
            @php
                $kartuStats = [
                    ['angka' => $stats['total'],         'label' => 'Total Laporan',  'icon' => '📋', 'warna' => 'var(--warna-indigo)'],
                    ['angka' => $stats['menunggu'],      'label' => 'Menunggu Verifikasi','icon' => '⏳', 'warna' => '#F59E0B'],
                    ['angka' => $stats['diproses'],      'label' => 'Sedang Diproses','icon' => '🔧', 'warna' => '#3B82F6'],
                    ['angka' => $stats['selesai_bulan'], 'label' => 'Selesai Bulan Ini','icon' => '✅', 'warna' => '#10B981'],
                    ['angka' => $stats['petugas_aktif'], 'label' => 'Petugas Aktif',  'icon' => '👷', 'warna' => 'var(--warna-cobalt)'],
                ];
            @endphp
            @foreach($kartuStats as $kartu)
                <div class="ld-card p-5"
                    style="border-top: 3px solid {{ $kartu['warna'] }};">
                    <div class="text-3xl mb-3">{{ $kartu['icon'] }}</div>
                    <div class="text-3xl font-bold mb-1"
                        style="color: {{ $kartu['warna'] }}; font-family: var(--font-display);"
                        data-count="{{ $kartu['angka'] }}">{{ $kartu['angka'] }}</div>
                    <div class="text-sm" style="color: var(--warna-teks-muted);">{{ $kartu['label'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="grid lg:grid-cols-3 gap-6 mb-8">

            {{-- Laporan Menunggu Tindakan --}}
            <div class="lg:col-span-2 ld-card" data-animate="fadeLeft">
                <div class="p-5 border-b flex items-center justify-between"
                    style="border-color: var(--warna-icy);">
                    <h2 class="text-lg font-bold" style="color: var(--warna-indigo);">
                        ⚡ Laporan Perlu Tindakan
                    </h2>
                    <a href="{{ route('admin.laporan.daftar', ['status' => 'dikirim']) }}"
                        class="ld-btn-ghost ld-btn-sm">Lihat Semua</a>
                </div>
                <div class="divide-y" style="--tw-divide-opacity: 1;">
                    @forelse($laporanTerbaru as $laporan)
                        <div class="p-4 hover:bg-blue-50 transition-colors">
                            <div class="flex items-start gap-3">
                                @if($laporan->foto_sebelum)
                                    <img src="{{ Storage::url(is_array($laporan->foto_sebelum) ? $laporan->foto_sebelum[0] : $laporan->foto_sebelum) }}"
                                        alt="Foto" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center text-xl flex-shrink-0"
                                        style="background: var(--warna-icy);">🛣️</div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span class="text-xs font-mono" style="color: var(--warna-cobalt);">
                                            {{ $laporan->kode_laporan }}
                                        </span>
                                        <span class="ld-badge ld-badge-{{ $laporan->status }}">
                                            {{ $laporan->label_status }}
                                        </span>
                                        @if($laporan->prioritas_ai)
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded"
                                                style="background: {{ $laporan->warna_prioritas }}20; color: {{ $laporan->warna_prioritas }};">
                                                {{ $laporan->label_prioritas }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="font-medium text-sm truncate" style="color: var(--warna-teks);">
                                        {{ $laporan->judul }}
                                    </p>
                                    <p class="text-xs" style="color: var(--warna-teks-muted);">
                                        {{ $laporan->kota }} · {{ $laporan->pelapor->nama }} · {{ $laporan->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <a href="{{ route('laporan.detail', $laporan) }}"
                                    class="ld-btn-outline ld-btn-sm flex-shrink-0">Tinjau</a>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center">
                            <div class="text-4xl mb-2">🎉</div>
                            <p style="color: var(--warna-teks-muted);">Semua laporan sudah ditangani!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Panel Kanan --}}
            <div class="space-y-6">

                {{-- Petugas Aktif --}}
                <div class="ld-card p-5" data-animate="fadeRight">
                    <h3 class="font-bold mb-4" style="color: var(--warna-indigo);">
                        👷 Petugas Aktif
                    </h3>
                    @forelse($petugasAktif as $petugas)
                        <div class="flex items-center gap-3 py-2.5 border-b"
                            style="border-color: var(--warna-icy);">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm text-white"
                                style="background: var(--warna-cobalt);">
                                {{ strtoupper(substr($petugas->nama, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-sm truncate" style="color: var(--warna-teks);">
                                    {{ $petugas->nama }}
                                </p>
                                <p class="text-xs" style="color: var(--warna-teks-muted);">
                                    {{ $petugas->tugasSaya()->where('status', 'diproses')->count() }} tugas aktif
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center py-3" style="color: var(--warna-teks-muted);">
                            Tidak ada petugas
                        </p>
                    @endforelse
                </div>

                {{-- Aksi Cepat --}}
                <div class="ld-card p-5" data-animate="fadeRight">
                    <h3 class="font-bold mb-4" style="color: var(--warna-indigo);">
                        ⚡ Aksi Cepat
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.laporan.daftar', ['status' => 'dikirim']) }}"
                            class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors"
                            style="border: 1px solid var(--warna-icy);">
                            <span class="text-xl">📨</span>
                            <span class="text-sm font-medium" style="color: var(--warna-teks);">
                                Verifikasi Laporan Baru
                            </span>
                            @if($stats['menunggu'] > 0)
                                <span class="ml-auto text-xs font-bold px-2 py-0.5 rounded-full text-white"
                                    style="background: #EF4444;">{{ $stats['menunggu'] }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.laporan.daftar', ['status' => 'diverifikasi']) }}"
                            class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors"
                            style="border: 1px solid var(--warna-icy);">
                            <span class="text-xl">👷</span>
                            <span class="text-sm font-medium" style="color: var(--warna-teks);">
                                Tugaskan Petugas
                            </span>
                        </a>
                        <a href="{{ route('statistik') }}"
                            class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors"
                            style="border: 1px solid var(--warna-icy);">
                            <span class="text-xl">📊</span>
                            <span class="text-sm font-medium" style="color: var(--warna-teks);">
                                Lihat Statistik Publik
                            </span>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
