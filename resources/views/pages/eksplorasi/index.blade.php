@extends('layouts.utama')
@section('judul', 'LaporDong - Eksplorasi Laporan')

@section('konten')

<div class="ld-page-wrapper">
    <div class="ld-container ld-container-wide">

        {{-- Hero Banner (Sama dengan Statistik) --}}
        <div class="ld-hero-wrapper">
            <h1 class="ld-hero__judul">
                <span class="aksen">Eksplorasi Laporan</span>
            </h1>
            <p class="ld-hero__desc ld-hero__desc-custom">
                Pantau kerusakan jalan di seluruh Indonesia, beri ulasan, dan nilai kinerja pemerintah.
            </p>

            {{-- SEARCH --}}
            <form method="GET" action="{{ route('eksplorasi') }}" class="ld-search" style="margin-top: 2rem;">
                <div class="ld-search__wrapper">
                    <input 
                        type="text" 
                        name="cari" 
                        value="{{ request('cari') }}"
                        placeholder="Cari nama jalan, kota, atau daerah..."
                        class="ld-search__input"
                    >
                    <button type="submit" class="ld-btn ld-btn--primer">Cari</button>
                </div>
            </form>
        </div>

        {{-- Konten Eksplorasi Grid (Sidebar & Feed) --}}
        <div class="ld-eksplorasi__grid" style="margin-top: 0;">

            {{-- SIDEBAR FILTER --}}
            <aside class="ld-filter">
                <form method="GET" action="{{ route('eksplorasi') }}" id="filterForm" class="ld-filter__card">

                    @if(request('cari'))
                        <input type="hidden" name="cari" value="{{ request('cari') }}">
                    @endif

                    <h3 class="ld-filter__title">Filter</h3>

                    <div class="ld-filter__group">
                        <label>Provinsi</label>
                        <select name="provinsi" onchange="this.form.submit()" class="ld-input">
                            <option value="">Semua Provinsi</option>
                            @foreach($daftarProvinsi as $prov)
                                <option value="{{ $prov }}" {{ request('provinsi') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="ld-filter__group">
                        <label>Kota / Kabupaten</label>
                        <select name="kota" onchange="this.form.submit()" class="ld-input">
                            <option value="">Semua Kota</option>
                            @foreach($daftarKota as $kota)
                                <option value="{{ $kota }}" {{ request('kota') === $kota ? 'selected' : '' }}>{{ $kota }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="ld-filter__group">
                        <label>Status</label>
                        @php
                            $statusList = [
                                '' => 'Semua Status',
                                'dikirim' => 'Dikirim',
                                'diverifikasi' => 'Diverifikasi',
                                'diproses' => 'Diproses',
                                'selesai' => 'Selesai',
                            ];
                        @endphp
                        @foreach($statusList as $val => $label)
                            <label class="ld-radio">
                                <input type="radio" name="status" value="{{ $val }}"
                                    {{ request('status','') === $val ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="ld-filter__group">
                        <label>Urutkan</label>
                        <select name="sort" onchange="this.form.submit()" class="ld-input">
                            <option value="terbaru" {{ request('sort','terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="tertua" {{ request('sort') === 'tertua' ? 'selected' : '' }}>Terlama</option>
                            <option value="bintang" {{ request('sort') === 'bintang' ? 'selected' : '' }}>Rating Tertinggi</option>
                        </select>
                    </div>

                    @if(request()->hasAny(['kota','provinsi','status','cari','sort']))
                        <div style="margin-top: 1.5rem;">
                            <a href="{{ route('eksplorasi') }}" class="ld-btn ld-btn--ghost" style="width: 100%; text-align: center;">Reset Filter</a>
                        </div>
                    @endif
                </form>
            </aside>

            {{-- FEED UTAMA --}}
            <main class="ld-feed">

                <div class="ld-feed__info">
                    Menampilkan <strong>{{ $laporan->total() }}</strong> laporan
                </div>

                @forelse($laporan as $item)
                @php
                    $statusColor = match($item->status) {
                        'dikirim'     => 'ld-badge--dikirim',
                        'diverifikasi'=> 'ld-badge--diverifikasi',
                        'diproses'    => 'ld-badge--diproses',
                        'selesai'     => 'ld-badge--selesai',
                        'ditolak'     => 'ld-badge--ditolak',
                        default       => '',
                    };
                    $prioritasColor = match($item->prioritas_ai) {
                        'tinggi' => 'ld-priority--high',
                        'sedang' => 'ld-priority--medium',
                        'rendah' => 'ld-priority--low',
                        default  => '',
                    };
                    $foto = is_array($item->foto_sebelum) ? ($item->foto_sebelum[0] ?? null) : $item->foto_sebelum;
                @endphp

                <article class="ld-card-eksplorasi">

                    {{-- HEAD --}}
                    <div class="ld-card__head">
                        <div class="ld-card__media">
                            @if($foto)
                                <img src="{{ asset('storage/' . $foto) }}" class="ld-card__img" alt="Foto laporan">
                            @else
                                <div class="ld-card__img ld-card__img--placeholder">
                                    <span>🛣️</span>
                                </div>
                            @endif
                        </div>

                        <div class="ld-card__content">
                            <div class="ld-card__top">
                                <div class="ld-card__badges">
                                    <span class="ld-badge {{ $statusColor }}">{{ $item->label_status }}</span>
                                    @if($item->prioritas_ai)
                                        <span class="ld-priority {{ $prioritasColor }}">{{ $item->label_prioritas }}</span>
                                    @endif
                                </div>
                                <span class="ld-time">{{ $item->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="ld-card__title">{{ $item->judul }}</h3>
                            <p class="ld-location">{{ $item->kecamatan }}, {{ $item->kota }}, {{ $item->provinsi }}</p>
                        </div>
                    </div>

                    {{-- DESC --}}
                    <p class="ld-card__desc">{{ Str::limit($item->deskripsi, 150) }}</p>
                    

                    <div class="ld-divider"></div>

                    {{-- FOOTER: user + rating sejajar --}}
                    <div class="ld-card__footer">
                        <div class="ld-user">
                            <div class="ld-user__avatar">
                                {{ strtoupper(substr($item->pelapor?->nama_lengkap ?? 'U', 0, 1)) }}
                            </div>
                            <span class="ld-user__name">{{ $item->pelapor?->nama_lengkap }}</span>
                        </div>

                        <div class="ld-rating-display">
                            @if($item->ulasan?->bintang)
                                <div class="ld-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="ld-star {{ $item->ulasan->bintang >= $i ? 'is-active' : '' }}">★</span>
                                    @endfor
                                </div>
                                <span class="ld-rating__value">{{ $item->ulasan->bintang }}/5</span>
                            @else
                                <span class="ld-rating__empty">Belum ada ulasan</span>
                            @endif
                        </div>
                    </div>

                    <div class="ld-divider"></div>

                    {{-- ACTION SECTION --}}
                    <div class="ld-card__action">

                        <a href="{{ route('laporan.detail', $item->id) }}" class="ld-btn ld-btn--primer">
                            Lihat Detail
                        </a>

                        @guest
                            {{-- Belum login --}}
                            @if($item->status === 'selesai')
                                <div class="ld-gate">
                                    <span class="ld-gate__text">Mau kasih ulasan atau rating?</span>
                                    <a href="{{ route('masuk') }}" class="ld-gate__link">Masuk dulu</a>
                                </div>
                            @else
                                <div class="ld-gate">
                                    <span class="ld-gate__text">
                                        Laporan sedang <strong>{{ $item->label_status }}</strong>. Ulasan bisa diberikan setelah status <strong>Selesai</strong>.
                                    </span>
                                </div>
                            @endif
                        @endguest

                        @auth
                            {{-- Sudah login --}}
                            @if($item->status === 'selesai')
                                <div class="ld-comment-form__label">Beri ulasanmu</div>
                                
                                {{-- Menampilkan Error Global jika Validasi Gagal --}}
                                @if($errors->any())
                                    <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 0.9rem;">
                                        Gagal mengirim ulasan. Pastikan bintang dan komentar sudah diisi!
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('eksplorasi.ulasan', $item->id) }}" class="ld-comment-form">
                                    @csrf
                                    <div class="ld-stars-input" data-form="{{ $item->id }}" style="display: flex; gap: 4px; margin-bottom: 5px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="ld-star-input" data-value="{{ $i }}" style="cursor: pointer; font-size: 24px; color: #E2E8F0;">★</span>
                                        @endfor
                                        <input type="hidden" name="bintang" required>
                                    </div>
                                    @error('bintang')
                                        <div style="color: red; font-size: 0.85rem; margin-bottom: 10px;">{{ $message }}</div>
                                    @enderror

                                    <textarea name="komentar" placeholder="Tulis pengalamanmu tentang perbaikan jalan ini..." rows="2" class="ld-textarea" style="min-height: 80px;"></textarea>
                                    @error('komentar')
                                        <div style="color: red; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div>
                                    @enderror

                                    <div class="ld-comment-form__row" style="justify-content: flex-end; margin-top: 10px;">
                                        <button type="submit" class="ld-btn ld-btn--primer">
                                            Kirim
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="ld-gate">
                                    <span class="ld-gate__text">
                                        Laporan sedang <strong>{{ $item->label_status }}</strong>. Ulasan bisa diberikan setelah status <strong>Selesai</strong>.
                                    </span>
                                </div>
                            @endif
                        @endauth

                        {{-- Komentar yang sudah ada (semua orang bisa lihat) --}}
                        @if($item->ulasanList && $item->ulasanList->count() > 0)
                            <div style="margin-top: 15px; text-align: center;">
                                {{-- Tombol untuk memunculkan komentar --}}
                                <button type="button" onclick="toggleUlasan('komentar-{{ $item->id }}', this)" class="ld-btn ld-btn--ghost" style="width: 100%; border: 1px dashed #cbd5e1;">
                                    Lihat {{ $item->ulasanList->count() }} Ulasan ▼
                                </button>
                            </div>

                            {{-- Bungkus komentar dengan div yang di-hidden (display: none) secara default --}}
                            <div id="komentar-{{ $item->id }}" class="ld-comments" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                                @foreach($item->ulasanList as $ulasan)
                                    <div class="ld-comment">
                                        <div class="ld-comment__avatar">
                                            {{ strtoupper(substr($ulasan->user?->nama_lengkap ?? 'U', 0, 1)) }}
                                        </div>

                                        <div class="ld-comment__body">
                                            <div class="ld-comment__header">
                                                <span class="ld-comment__who">
                                                    {{-- NAMA PENGGUNA LANGSUNG DITAMPILKAN --}}
                                                    {{ $ulasan->user?->nama_lengkap }}
                                                </span>

                                                <div class="ld-comment__stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span class="{{ $ulasan->bintang >= $i ? 'on' : 'off' }}">★</span>
                                                    @endfor
                                                </div>
                                            </div>

                                            <p class="ld-comment__text">{{ $ulasan->komentar }}</p>

                                            <span class="ld-comment__time">
                                                {{ $ulasan->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                </article>
                @empty
                <div class="ld-empty">
                    <p>Tidak ada laporan ditemukan.</p>
                </div>
                @endforelse

                @if($laporan->hasPages())
                    <div class="ld-pagination-wrapper">
                        {{ $laporan->links() }}
                    </div>
                @endif

            </main>
        </div>

    </div>
</div>

@endsection