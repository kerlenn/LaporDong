@extends('layouts.utama')

@section('judul', 'LaporDong - Kelola Laporan')

@section('konten')
<div class="ld-manage-wrapper">
    <div class="ld-container">

        {{-- BACK BUTTON --}}
        <div class="ld-back-wrapper" data-animate="fadeUp">
            <a href="{{ route('admin.dasbor') }}" class="ld-btn ld-btn--ghost ld-btn--back ld-btn-back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Kembali
            </a> 
        </div>

        {{-- HEADER --}}
        <div class="ld-header-flex" data-animate="fadeUp">
            <div class="ld-header-title-box">
                <div>
                    <h1 class="ld-page-title">Kelola Laporan</h1>
                    <div class="ld-page-subtitle">
                        Total {{ $laporan->total() }} laporan
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTER SIMPLE --}}
        <div class="ld-card" style="margin-bottom:1rem;" data-animate="fadeUp">
            <div class="ld-card__body">
                <form method="GET" action="{{ route('admin.laporan.daftar') }}" class="ld-filter-form">
                    <input type="text" name="cari" value="{{ request('cari') }}"
                        placeholder="Cari laporan..."
                        class="ld-input ld-filter-input-search">

                    <select name="prioritas" class="ld-input">
                        <option value="">Semua Prioritas</option>
                        @foreach(['tinggi','sedang','rendah'] as $p)
                            <option value="{{ $p }}" {{ request('prioritas') === $p ? 'selected' : '' }}>
                                {{ ucfirst($p) }}
                            </option>
                        @endforeach
                    </select>

                    <button class="ld-btn ld-btn--primer">Cari</button>

                    @if(request()->hasAny(['cari','prioritas']))
                        <a href="{{ route('admin.laporan.daftar') }}" class="ld-btn ld-btn--ghost">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        {{-- TAB STATUS --}}
        <div class="ld-tabs-container" data-animate="fadeUp">
            @php
                $statusList = [
                    '' => 'Semua',
                    'dikirim' => 'Dikirim',
                    'diverifikasi' => 'Verifikasi',
                    'diproses' => 'Diproses',
                    'selesai' => 'Selesai'
                ];
            @endphp

            @foreach($statusList as $key => $label)
                <a href="{{ route('admin.laporan.daftar', array_merge(request()->all(), ['status' => $key])) }}"
                   class="ld-btn {{ request('status') == $key ? 'ld-btn--primer' : 'ld-btn--ghost' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- LIST --}}
        <div class="ld-card" data-animate="fadeUp">
            <div class="ld-card__header">
                <h2 style="font-weight:700;">Daftar Laporan</h2>
            </div>

            <div>
                @forelse($laporan as $item)
                <div class="ld-report-item">

                    {{-- FOTO --}}
                    <div class="ld-report-img-container">
                        @if($item->foto_sebelum)
                            <img src="{{ Storage::url(is_array($item->foto_sebelum) ? $item->foto_sebelum[0] : $item->foto_sebelum) }}">
                        @else
                            <div class="ld-report-img-placeholder">🛣️</div>
                        @endif
                    </div>

                    {{-- INFO --}}
                    <div class="ld-report-content">
                        <div class="ld-report-title">
                            {{ $item->judul }}
                        </div>
                        <div class="ld-report-meta">
                            {{ $item->kota }} · {{ $item->created_at->diffForHumans() }}
                        </div>
                        <div class="ld-report-code">
                            {{ $item->kode_laporan }}
                        </div>
                        <span class="ld-badge ld-badge--outline">
                            {{ ucfirst($item->prioritas) }}
                        </span>
                    </div>

                    {{-- STATUS --}}
                    <span class="ld-badge ld-badge--{{ $item->status }}">
                        {{ $item->label_status }}
                    </span>

                    {{-- AKSI --}}
                    <div class="ld-action-group">
                        <a href="{{ route('laporan.detail', $item) }}"
                           class="ld-btn ld-btn--ghost ld-btn--sm">
                            Detail
                        </a>

                        @if($item->status === 'dikirim')
                            <form method="POST" action="{{ route('admin.laporan.verifikasi', $item) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="aksi" value="verifikasi">
                                <button class="ld-btn ld-btn--primer ld-btn--sm">Terima</button>
                            </form>

                            <form method="POST" action="{{ route('admin.laporan.verifikasi', $item) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="aksi" value="tolak">
                                <button class="ld-btn ld-btn--danger ld-btn--sm">Tolak</button>
                            </form>
                        @endif

                        @if($item->status === 'diverifikasi')
                            <form method="POST" action="{{ route('admin.laporan.proses', $item) }}">
                                @csrf @method('PATCH')
                                <button class="ld-btn ld-btn--primer ld-btn--sm">Proses</button>
                            </form>
                        @endif

                        @if($item->status === 'diproses')
                            <button onclick="bukaModal({{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                class="ld-btn ld-btn--primer ld-btn--sm">
                                Selesai
                            </button>
                        @endif
                    </div>

                </div>
                @empty
                <div class="ld-empty-state">
                    Tidak ada laporan
                </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            @if($laporan->hasPages())
                <div class="ld-pagination-wrapper">
                    {{ $laporan->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL (STRUKTUR YANG HILANG SUDAH DIKEMBALIKAN) --}}
<div class="ld-modal-overlay" id="modalSelesai">
    <div class="ld-modal-card">
        <h3 class="ld-modal-title">Selesaikan Laporan</h3>
        
        <form id="formSelesai" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" id="laporan_id">

            <div style="margin-bottom:1rem;">
                <label style="font-size:0.8rem; font-weight: 600; display: block; margin-bottom: 0.5rem;">Upload Bukti Foto Perbaikan</label>
                <input type="file" name="foto_sesudah[]" multiple class="ld-input" required>
            </div>

            <div style="font-size:0.7rem; color:var(--ld-text-muted); margin-bottom:1.5rem;">
                * Maksimal 5 foto
            </div>

            <div class="ld-modal-footer">
                <button type="button" onclick="tutupModal()" class="ld-btn ld-btn--ghost">
                    Batal
                </button>
                <button type="submit" class="ld-btn ld-btn--primer">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>

@endsection