@extends('layouts.utama')

@section('judul', 'LaporDong - Laporkan Kerusakan Jalan')

@section('konten')

{{-- ══════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════ --}}
<section class="ld-hero">
    <div class="ld-hero__bg">
        <div class="ld-hero__orb ld-hero__orb--1"></div>
        <div class="ld-hero__orb ld-hero__orb--2"></div>
        <div class="ld-hero__orb ld-hero__orb--3"></div>
    </div>

    <div class="ld-container ld-hero__container">
        <div class="ld-hero__grid">

            <div class="ld-hero__konten">

                <h1 class="ld-hero__judul">
                    Laporkan Jalan Rusak,<br>
                    <span class="aksen">Indonesia Lebih Baik</span>
                </h1>

                <p class="ld-hero__desc">
                    Platform pelaporan jalan antara warga dan pemerintah dengan bantuan AI untuk menilai dan menentukan prioritas perbaikan.
                </p>

                <div class="ld-hero__aksi">
                    @guest
                        <a href="{{ route('daftar') }}" class="ld-btn ld-btn--primer ld-btn--lg">
                            Mulai Laporkan
                        </a>
                        <a href="{{ route('eksplorasi') }}" class="ld-btn ld-btn--ghost ld-btn--lg">
                            Eksplorasi Laporan
                        </a>
                    @else
                        <a href="{{ route('laporan.buat') }}" class="ld-btn ld-btn--primer ld-btn--lg">
                            Buat Laporan Baru
                        </a>
                        <a href="{{ route('dasbor.warga') }}" class="ld-btn ld-btn--ghost ld-btn--lg">
                            Dasbor Saya
                        </a>
                    @endguest
                </div>
            </div>

            {{-- Ilustrasi Kanan --}}
            <div class="image-card-gradient">

            <div class="image-card-inner">

                <!-- IMAGE -->
                <div class="image-card-img">
                    <img src="{{ asset('images/jalanrusak.png') }}" alt="Jalan Rusak">
                </div>

                <!-- TEXT -->
                <div class="image-card-content">
                    <div class="image-card-title">
                        Jalan rusak parah di pusat kota
                    </div>

                    <div class="image-card-location">
                        Grogol, Jakarta Barat
                    </div>
                </div>

            </div>

            <!-- AI BADGE -->
            <div class="ai-badge">
                 <div class="ld-ai-badge__ikon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-stars" viewBox="0 0 16 16">
                    <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
                    </svg></div>
                <div>
                    <div class="ai-title">AI Analisis Aktif</div>
                    <div class="ai-sub">Gemini Flash 1.5</div>
                </div>
            </div>

        </div>
    </div>
</div>


    </div>
</section>

{{-- ══════════════════════════════════════════════
     STATISTIK STRIP
══════════════════════════════════════════════ --}}
<section class="ld-section-stats">
    <div class="ld-container">
        <div class="ld-stats-strip">
            <div class="ld-stat-item">
                <div class="ld-stat-item__angka" data-count="{{ $statistikPublik['total_laporan'] }}" data-satuan="">0</div>
                <div class="ld-stat-item__label">Total Laporan</div>
            </div>
            <div class="ld-stat-item">
                <div class="ld-stat-item__angka" data-count="{{ $statistikPublik['laporan_selesai'] }}" data-satuan="">0</div>
                <div class="ld-stat-item__label">Berhasil Diperbaiki</div>
            </div>
            <div class="ld-stat-item">
                <div class="ld-stat-item__angka" data-count="{{ $statistikPublik['kota_terlayani'] }}" data-satuan="">0</div>
                <div class="ld-stat-item__label">Kota Terlayani</div>
            </div>
            <div class="ld-stat-item">
                <div class="ld-stat-item__angka ld-stat-item__angka--text">{{ $statistikPublik['rata_penyelesaian'] }}</div>
                <div class="ld-stat-item__label">Rata-rata Penyelesaian</div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     CARA KERJA
══════════════════════════════════════════════ --}}
<section class="ld-section ld-section--white">
    <div class="ld-container">
        <div class="ld-section-header" data-animate="fadeUp">

            <h2 class="ld-section-title">4 Langkah Mudah Melapor</h2>
            <p class="ld-section-desc ld-section-desc--center">Dari foto hingga perbaikan, proses yang transparan dan terpantau</p>
        </div>

        <div class="ld-langkah-grid">
            @foreach($langkah as $item)
            <div class="ld-card ld-card--langkah">
                <div class="ld-card__body ld-card__body--langkah">
                    <div class="ld-langkah__ikon-wrap">
                        {!! $item['ikon'] !!}
                        <span class="ld-langkah__nomor">{{ $item['nomor'] }}</span>
                    </div>
                    <h3 class="ld-langkah__judul">{{ $item['judul'] }}</h3>
                    <p class="ld-langkah__desc">{{ $item['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     FITUR UNGGULAN
══════════════════════════════════════════════ --}}
<section class="ld-section">
    <div class="ld-container">
        <div class="ld-fitur-grid">

            <div class="gamifikasi_border">
                <h2 class="ld-section-title-card">Kecerdasan Buatan untuk<br>Infrastruktur Indonesia</h2>
                <p class="ld-section-desc">AI mempercepat proses laporan jalan dengan menganalisis foto, menilai tingkat kerusakan, memperkirakan urgensi, dan membantu pemerintah mengambil keputusan yang lebih tepat.</p>

                <div class="ld-fitur-ai-list">
                    @foreach($fiturAi as $fitur)
                    <div class="ld-fitur-ai-item">
                        <div class="ld-fitur-ai-item__ikon">{!! $fitur['ikon'] !!}</div>
                        <div>
                            <div class="ld-fitur-ai-item__judul">{{ $fitur['judul'] }}</div>
                            <div class="ld-fitur-ai-item__desc">{{ $fitur['desc'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Gamifikasi --}}
            <div class="gamifikasi_border">
                <h2 class="ld-section-title-card">Kumpulkan Badge,<br>Jadilah Pahlawan Negara!</h2>
                <p class="ld-section-desc">Setiap kontribusi yang Anda lakukan akan menambah poin dan membuka badge baru. Semakin aktif, semakin banyak penghargaan!</p>

                <div class="ld-badge-grid">
                    @foreach($contohBadge as $badge)
                    <div class="ld-badge-card">
                        <div class="ld-badge-card__ikon">{{ $badge['ikon'] }}</div>
                        <div class="ld-badge-card__nama">{{ $badge['nama'] }}</div>
                        <div class="ld-badge-card__desc">{{ $badge['syarat'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     CTA SECTION
══════════════════════════════════════════════ --}}
<section class="ld-section-cta">
    <div class="ld-container ld-section-cta__inner">
        <h2 class="ld-section-cta__judul">
            Mulai Berkontribusi Hari Ini!
        </h2>
        <p class="ld-section-cta__desc">
            Bersama-sama kita bangun infrastruktur Indonesia yang lebih baik. Satu laporan bisa membawa perubahan.
        </p>
        <div class="ld-section-cta__aksi">
            @guest
                <a href="{{ route('daftar') }}" class="ld-btn ld-btn--primer ld-btn--lg">
                    Daftar Sekarang
                </a>
                <a href="{{ route('eksplorasi') }}" class="ld-btn ld-btn--ghost ld-btn--lg">
                    Eksplorasi Laporan
                </a>
            @else
                <a href="{{ route('laporan.buat') }}" class="ld-btn ld-btn--primer ld-btn--lg">
                    Buat Laporan Baru
                </a>
            @endguest
        </div>
    </div>
</section>

@endsection