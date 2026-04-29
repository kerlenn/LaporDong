@extends('layouts.utama')
@section('judul', 'LaporDong - Dashboard Warga')

@section('konten')
<div class="dashboard-warga-wrapper">
    <div class="ld-container">

        {{-- Header Dasbor --}}
        <div class="warga-header-container" data-animate="fadeUp">
            <div>
                <div class="warga-header-subtitle">Dashboard Warga</div>
                <h1 class="warga-header-title">Selamat datang, {{ $pengguna->nama_lengkap }}</h1>
            </div>
            <a href="{{ route('laporan.buat') }}" class="ld-btn ld-btn--primer ld-btn--lg">
                Buat Laporan Baru
            </a>
        </div>

        {{-- Ringkasan Statistik --}}
        <div class="warga-stats-grid" data-animate-grid>
            @php
            $kartaStat = [
                ['angka' => $ringkasan['total'],    'label' => 'Total Laporan', 'ikon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/>
                </svg>', 'warna' => 'var(--ld-indigo)'],
                ['angka' => $ringkasan['diproses'],  'label' => 'Sedang Diproses', 'ikon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-wrench" viewBox="0 0 16 16">
                <path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/>
                </svg>', 'warna' => 'var(--ld-indigo)'],
                ['angka' => $ringkasan['selesai'],   'label' => 'Selesai', 'ikon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                </svg>', 'warna' => 'var(--ld-indigo)'],
                ['angka' => $pengguna->total_poin,   'label' => 'Total Poin', 'ikon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-star-fill" viewBox="0 0 16 16">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>', 'warna' => 'var(--ld-indigo)'],
            ];
            @endphp

            @foreach($kartaStat as $stat)
            <div class="ld-card">
                <div class="ld-card__body warga-stat-body">
                    <div class="warga-stat-icon">
                        {!! $stat['ikon'] !!}
                    </div>
                    <div>
                        <div class="warga-stat-number" style="color: {{ $stat['warna'] }};">
                            {{ number_format($stat['angka']) }}
                        </div>
                        <div class="warga-stat-label">{{ $stat['label'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="warga-main-grid">

            {{-- Laporan Terkini --}}
            <div class="ld-card" data-animate="fadeUp" data-delay="0.2">
                <div class="ld-card__header">
                    <h2 class="warga-section-title">Laporan Terkini</h2>
                    <a href="{{ route('laporan.daftar-saya') }}" class="warga-section-link">Lihat semua</a>
                </div>

                <div class="warga-list-container">
                    @forelse($laporanTerkini as $laporan)
                    <a href="{{ route('laporan.detail', $laporan->kode_laporan) }}" class="warga-laporan-item">
                        <div class="warga-laporan-icon">
                            @if($laporan->status === 'selesai') <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                            </svg>
                            @elseif($laporan->status === 'diproses') <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-wrench" viewBox="0 0 16 16">
                            <path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/>
                            </svg>
                            @elseif($laporan->status === 'diverifikasi') <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                            <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                            </svg>
                            @elseif($laporan->status === 'ditolak') <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-ban-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M2.71 12.584q.328.378.706.707l9.875-9.875a7 7 0 0 0-.707-.707l-9.875 9.875Z"/>
                            </svg>
                            @else <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#234A89" class="bi bi-send-fill" viewBox="0 0 16 16">
                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
                                    </svg>
                            @endif
                        </div>
                        <div class="warga-laporan-content">
                            <div class="warga-laporan-title">{{ $laporan->judul }}</div>
                            <div class="warga-laporan-meta">
                                {{ $laporan->kecamatan }}, {{ $laporan->kota }} · {{ $laporan->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="warga-laporan-badge">
                            <span class="ld-badge ld-badge--{{ $laporan->status }}">{{ $laporan->label_status }}</span>
                        </div>
                    </a>
                    @empty
                    <div class="warga-empty-state">
                        <p class="warga-empty-title">Belum ada laporan</p>
                        <p class="warga-empty-text">Mulai dengan membuat laporan pertama Anda!</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Badge & Profil --}}
            <div class="warga-sidebar">

                {{-- Profil Singkat --}}
                <div class="ld-card" data-animate="fadeRight" data-delay="0.15">
                    <div class="ld-card__body warga-profile-body">
                        <img src="{{ $pengguna->avatar_url }}" alt="Foto Profil" class="warga-profile-avatar">
                        <div class="warga-profile-name">{{ $pengguna->nama_lengkap }}</div>
                        <div class="warga-profile-email">{{ $pengguna->email }}</div>

                        {{-- Progress Poin --}}
                        <div class="warga-progress-container">
                            <div class="warga-progress-labels">
                                <span>{{ $pengguna->level }}</span>
                                <span>{{ number_format($pengguna->total_poin) }} poin</span>
                            </div>
                            @php
                            $poinSelanjutnya = match(true) {
                                $pengguna->total_poin < 500  => 500,
                                $pengguna->total_poin < 2000 => 2000,
                                $pengguna->total_poin < 5000 => 5000,
                                default                      => 5000,
                            };
                            $persen = min(100, round(($pengguna->total_poin / $poinSelanjutnya) * 100));
                            @endphp
                            <div class="warga-progress-track">
                                {{-- Style width dibiarkan inline karena nilai dinamis bergantung pada $persen dari proses PHP di atas --}}
                                <div class="warga-progress-bar" style="width: {{ $persen }}%;"></div>
                            </div>
                            <div class="warga-progress-target">
                                Target: {{ number_format($poinSelanjutnya) }} poin
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Badge --}}
                <div class="ld-card" data-animate="fadeRight" data-delay="0.25">
                    <div class="ld-card__header">
                        <h2 class="warga-badge-header-title">Badge Saya</h2>
                        <a href="{{ route('dasbor.profil') }}" class="warga-badge-link">Lihat semua</a>
                    </div>
                    <div class="ld-card__body">
                        @if($pengguna->badge->count() > 0)
                        <div class="warga-badge-grid">
                            @foreach($pengguna->badge->take(4) as $badge)
                            <div class="ld-badge-card">
                                <div class="ld-badge-card__ikon"><img src="{{ asset('images/' . $badge->ikon) }}"></div>
                                <div class="ld-badge-card__nama">{{ $badge->nama }}</div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="warga-badge-empty">
                            <p class="warga-badge-empty-text">Kirim laporan pertama untuk mendapat badge!</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection