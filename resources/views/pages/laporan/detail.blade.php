@extends('layouts.utama')
@section('judul', 'Detail Laporan ' . $laporan->kode_laporan . ' — LaporDong')

@section('konten')
<div style="padding-top: 6rem; padding-bottom: 4rem; background: var(--ld-bg-soft); min-height: 100vh;">
    <div class="ld-container" style="max-width: 900px;">

        {{-- Breadcrumb --}}
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--ld-text-muted);">
            <a href="{{ route('laporan.daftar-saya') }}" style="color: var(--ld-cobalt); text-decoration: none;">← Laporan Saya</a>
            <span>/</span>
            <span>{{ $laporan->kode_laporan }}</span>
        </div>

        {{-- Header Laporan --}}
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
            <div>
                <h1 style="font-family: var(--ld-font-display); font-size: 1.5rem; font-weight: 800; color: var(--ld-text); letter-spacing: -0.02em;">{{ $laporan->judul }}</h1>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 0.625rem; flex-wrap: wrap;">
                    <span style="font-size: 0.8rem; color: var(--ld-text-muted); font-family: monospace; background: var(--ld-bg-soft); padding: 0.25rem 0.5rem; border-radius: 6px; border: 1px solid var(--ld-border);">{{ $laporan->kode_laporan }}</span>
                    <span class="ld-badge ld-badge--{{ $laporan->status }}">{{ $laporan->label_status }}</span>
                    @if($laporan->prioritas_ai)
                        <span class="ld-badge ld-badge--prioritas-{{ $laporan->prioritas_ai }}">{{ $laporan->label_prioritas }}</span>
                    @endif
                    <span style="font-size: 0.8rem; color: var(--ld-text-muted);">{{ $laporan->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @if($laporan->bisaDiulas())
                <a href="{{ route('laporan.ulasan.form', $laporan->kode_laporan) }}" class="ld-btn ld-btn--primer ld-btn--sm">
                    ⭐ Beri Ulasan
                </a>
            @endif
        </div>

        {{-- TRACKING STEP --}}
        <div class="ld-step-tracker" style="margin-bottom: 1.5rem;">
            @php
            $tahapan = [
                ['kode' => 'dikirim',      'label' => 'Dikirim',      'ikon' => '📤'],
                ['kode' => 'diverifikasi', 'label' => 'Diverifikasi', 'ikon' => '✔️'],
                ['kode' => 'diproses',     'label' => 'Diproses',     'ikon' => '🔧'],
                ['kode' => 'selesai',      'label' => 'Selesai',      'ikon' => '✅'],
            ];
            $urutanStatus  = array_column($tahapan, 'kode');
            $indeksSekarang = array_search($laporan->status, $urutanStatus);
            @endphp
            @foreach($tahapan as $i => $tahap)
                @php $lewat = $indeksSekarang !== false && $i < $indeksSekarang; $aktif = $i === $indeksSekarang; @endphp
                <div class="ld-step {{ $lewat ? 'ld-step--lewat' : '' }} {{ $aktif ? 'ld-step--sekarang' : '' }}">
                    <div class="ld-step__nomor">
                        @if($lewat || $aktif) {{ $tahap['ikon'] }} @else {{ $i + 1 }} @endif
                    </div>
                    <div class="ld-step__label">{{ $tahap['label'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- SLA WIDGET --}}
        @if($laporan->tenggat_sla && $laporan->status !== 'ditolak')
        @php
            $statusSla  = $laporan->status_sla;
            $sisaHari   = $laporan->sisa_hari_sla;
            $slaConfig  = match($statusSla) {
                'selesai'          => ['bg' => '#ECFDF5', 'border' => '#6EE7B7', 'color' => '#065F46', 'icon' => '✅', 'label' => 'Diselesaikan Tepat Waktu'],
                'overdue'          => ['bg' => '#FEF2F2', 'border' => '#FCA5A5', 'color' => '#991B1B', 'icon' => '🚨', 'label' => 'SLA Terlampaui'],
                'warning'          => ['bg' => '#FFFBEB', 'border' => '#FCD34D', 'color' => '#92400E', 'icon' => '⚠️', 'label' => 'Mendekati Batas Waktu'],
                'ontime'           => ['bg' => '#EFF6FF', 'border' => '#93C5FD', 'color' => '#1E40AF', 'icon' => '🕐', 'label' => 'Dalam Batas Waktu'],
                default            => ['bg' => '#F9FAFB', 'border' => '#E5E7EB', 'color' => '#6B7280', 'icon' => '📋', 'label' => 'SLA Belum Ditetapkan'],
            };
        @endphp
        <div style="margin-bottom: 1.5rem; padding: 1.25rem 1.5rem; border-radius: 14px; background: {{ $slaConfig['bg'] }}; border: 1.5px solid {{ $slaConfig['border'] }}; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.875rem;">
                <div style="font-size: 1.75rem;">{{ $slaConfig['icon'] }}</div>
                <div>
                    <div style="font-weight: 700; font-size: 0.9375rem; color: {{ $slaConfig['color'] }};">
                        {{ $slaConfig['label'] }}
                    </div>
                    <div style="font-size: 0.8125rem; color: {{ $slaConfig['color'] }}; opacity: 0.8; margin-top: 2px;">
                        Target penyelesaian: {{ $laporan->tenggat_sla->format('d M Y') }}
                        @if($laporan->estimasi_hari) · Estimasi AI: {{ $laporan->estimasi_hari }} hari @endif
                    </div>
                </div>
            </div>
            <div style="text-align: right;">
                @if($statusSla === 'selesai')
                    @if($laporan->tepat_waktu)
                        <div style="font-size: 1.5rem; font-weight: 800; color: #065F46;">✓ Tepat Waktu</div>
                    @else
                        <div style="font-size: 1.5rem; font-weight: 800; color: #991B1B;">Terlambat</div>
                    @endif
                @elseif($statusSla === 'overdue')
                    <div style="font-size: 1.5rem; font-weight: 800; color: #991B1B;">{{ abs($sisaHari) }} hari terlewat</div>
                @else
                    <div style="font-size: 1.5rem; font-weight: 800; color: {{ $slaConfig['color'] }};">{{ $sisaHari }} hari lagi</div>
                @endif
                <div style="font-size: 0.75rem; color: {{ $slaConfig['color'] }}; opacity: 0.7;">dari tenggat waktu</div>
            </div>
        </div>
        @endif

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">

            {{-- Kolom Kiri --}}
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                {{-- AI Analisis --}}
                @if($laporan->prioritas_ai)
                <div class="ld-card" style="border: 1px solid rgba(53,117,175,0.2); background: linear-gradient(135deg, #F0F7FF, #E8F4FD);">
                    <div class="ld-card__body">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                            <div style="width: 40px; height: 40px; background: var(--ld-grad-primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">✨</div>
                            <div>
                                <div style="font-weight: 700; font-size: 0.9rem; color: var(--ld-indigo);">Analisis AI Gemini</div>
                                <div style="font-size: 0.75rem; color: var(--ld-cobalt);">Penilaian otomatis berdasarkan foto</div>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 0.75rem;">
                            <div style="text-align: center; background: white; padding: 0.875rem; border-radius: 12px;">
                                <div style="font-family: var(--ld-font-display); font-size: 1rem; font-weight: 800; color: var(--ld-indigo);">{{ $laporan->label_prioritas }}</div>
                                <div style="font-size: 0.7rem; color: var(--ld-text-muted); margin-top: 2px;">Prioritas</div>
                            </div>
                            <div style="text-align: center; background: white; padding: 0.875rem; border-radius: 12px;">
                                <div style="font-family: var(--ld-font-display); font-size: 1.25rem; font-weight: 800; color: var(--ld-indigo);">{{ $laporan->skor_keparahan_ai ?? '-' }}</div>
                                <div style="font-size: 0.7rem; color: var(--ld-text-muted); margin-top: 2px;">Skor Keparahan</div>
                            </div>
                            <div style="text-align: center; background: white; padding: 0.875rem; border-radius: 12px;">
                                <div style="font-family: var(--ld-font-display); font-size: 1.25rem; font-weight: 800; color: #0891B2;">{{ $laporan->estimasi_hari ?? '-' }}</div>
                                <div style="font-size: 0.7rem; color: var(--ld-text-muted); margin-top: 2px;">Estimasi Hari</div>
                            </div>
                            <div style="text-align: center; background: white; padding: 0.875rem; border-radius: 12px;">
                                <div style="font-size: 0.75rem; font-weight: 600; color: var(--ld-indigo); line-height: 1.4;">{{ Str::limit($laporan->catatan_ai ?? 'N/A', 40) }}</div>
                                <div style="font-size: 0.7rem; color: var(--ld-text-muted); margin-top: 4px;">Catatan AI</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Deskripsi --}}
                <div class="ld-card">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">📋 Deskripsi Kerusakan</h2>
                    </div>
                    <div class="ld-card__body">
                        <p style="font-size: 0.9rem; color: var(--ld-text); line-height: 1.7;">{{ $laporan->deskripsi }}</p>
                    </div>
                </div>

                {{-- Foto Sebelum --}}
                @if($laporan->foto_sebelum && count($laporan->foto_sebelum) > 0)
                <div class="ld-card">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">📸 Foto Kerusakan (Sebelum)</h2>
                        <span style="font-size: 0.75rem; color: var(--ld-text-muted);">{{ $laporan->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="ld-card__body">
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 0.75rem;">
                            @foreach($laporan->foto_sebelum as $foto)
                            <div style="position: relative;">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto sebelum"
                                    style="width: 100%; height: 120px; object-fit: cover; border-radius: 10px; cursor: pointer; border: 1px solid var(--ld-border);"
                                    onclick="bukaGambarBesar(this.src)">
                                <div style="position: absolute; bottom: 6px; right: 6px; background: rgba(0,0,0,0.6); color: white; font-size: 0.65rem; padding: 2px 6px; border-radius: 4px;">
                                    {{ $laporan->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- Foto Sesudah --}}
                @if($laporan->foto_sesudah && count($laporan->foto_sesudah) > 0)
                <div class="ld-card" style="border-color: #BBF7D0;">
                    <div class="ld-card__header" style="background: #F0FDF4;">
                        <h2 style="font-size: 0.9rem; font-weight: 700; color: #15803D;">✅ Foto Bukti Perbaikan (Sesudah)</h2>
                        @if($laporan->tanggal_selesai)
                            <span style="font-size: 0.75rem; color: #16A34A;">{{ $laporan->tanggal_selesai->format('d M Y, H:i') }} WIB</span>
                        @endif
                    </div>
                    <div class="ld-card__body">
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 0.75rem;">
                            @foreach($laporan->foto_sesudah as $foto)
                            <div style="position: relative;">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto sesudah"
                                    style="width: 100%; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid #BBF7D0;">
                                <div style="position: absolute; bottom: 6px; right: 6px; background: rgba(0,100,0,0.7); color: white; font-size: 0.65rem; padding: 2px 6px; border-radius: 4px;">
                                    {{ $laporan->tanggal_selesai?->format('d/m/Y') ?? '' }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($laporan->catatan_petugas)
                        <div style="margin-top: 1rem; padding: 0.875rem; background: #F0FDF4; border-radius: 10px; border-left: 3px solid #16A34A;">
                            <div style="font-size: 0.75rem; font-weight: 600; color: #15803D; margin-bottom: 0.375rem;">Catatan Petugas:</div>
                            <p style="font-size: 0.875rem; color: #166534;">{{ $laporan->catatan_petugas }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Ulasan --}}
                @if($laporan->ulasan)
                <div class="ld-card">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">⭐ Ulasan & Performance Score</h2>
                    </div>
                    <div class="ld-card__body">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            @for($b = 1; $b <= 5; $b++)
                                <span style="font-size: 1.5rem; color: {{ $b <= $laporan->ulasan->bintang ? '#F59E0B' : '#E2E8F0' }};">★</span>
                            @endfor
                            <span style="font-size: 1rem; font-weight: 700; color: var(--ld-text);">{{ $laporan->ulasan->bintang }}/5</span>
                            <span style="font-size: 0.8rem; color: var(--ld-text-muted);">— {{ $laporan->ulasan->nama_penulis }}</span>
                        </div>
                        {{-- Progress bar score --}}
                        <div style="height: 8px; border-radius: 100px; background: #F3F4F6; overflow: hidden; margin-bottom: 0.75rem;">
                            <div style="height: 8px; border-radius: 100px; width: {{ ($laporan->ulasan->bintang / 5) * 100 }}%; background: linear-gradient(90deg, #F59E0B, #FCD34D);"></div>
                        </div>
                        @if($laporan->ulasan->komentar)
                        <p style="font-size: 0.875rem; color: var(--ld-text); line-height: 1.6; font-style: italic; padding: 0.75rem; background: #FFFBEB; border-radius: 8px; border-left: 3px solid #F59E0B;">"{{ $laporan->ulasan->komentar }}"</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            {{-- Kolom Kanan --}}
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                {{-- Lokasi --}}
                <div class="ld-card">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">📍 Lokasi</h2>
                    </div>
                    <div class="ld-card__body" style="font-size: 0.8625rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.625rem;">
                            <div><strong>Alamat:</strong><br>{{ $laporan->alamat_lengkap }}</div>
                            <div><strong>Kelurahan:</strong> {{ $laporan->kelurahan }}</div>
                            <div><strong>Kecamatan:</strong> {{ $laporan->kecamatan }}</div>
                            <div><strong>Kota:</strong> {{ $laporan->kota }}</div>
                            <div><strong>Provinsi:</strong> {{ $laporan->provinsi }}</div>
                            <div style="padding: 0.5rem; background: var(--ld-bg-soft); border-radius: 8px; font-family: monospace; font-size: 0.775rem;">
                                {{ $laporan->latitude }}, {{ $laporan->longitude }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timeline Riwayat Status --}}
                <div class="ld-card">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">🕐 Riwayat Status</h2>
                    </div>
                    <div class="ld-card__body">
                        <div class="ld-timeline">
                            @foreach($laporan->riwayatStatus as $i => $riwayat)
                            @php $isLast = $i === $laporan->riwayatStatus->count() - 1; @endphp
                            <div class="ld-timeline__item {{ $isLast ? 'ld-timeline__item--aktif' : '' }}">
                                <div class="ld-timeline__dot {{ $isLast ? 'ld-timeline__dot--aktif' : 'ld-timeline__dot--selesai' }}">
                                    @if($riwayat->status_baru === 'selesai') ✅
                                    @elseif($riwayat->status_baru === 'diproses') 🔧
                                    @elseif($riwayat->status_baru === 'diverifikasi') ✔️
                                    @elseif($riwayat->status_baru === 'ditolak') ❌
                                    @else 📤
                                    @endif
                                </div>
                                <div class="ld-timeline__konten">
                                    <div class="ld-timeline__label">{{ ucfirst($riwayat->status_baru) }}</div>
                                    <div class="ld-timeline__waktu">
                                        {{ $riwayat->created_at->format('d M Y, H:i') }}
                                        @if($riwayat->pengubah) · {{ $riwayat->pengubah->nama_lengkap }} @endif
                                    </div>
                                    @if($riwayat->catatan)
                                    <div class="ld-timeline__catatan">{{ $riwayat->catatan }}</div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Lightbox --}}
<div id="lightboxGambar" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 9999; align-items: center; justify-content: center; cursor: zoom-out;" onclick="tutupGambarBesar()">
    <img id="lightboxGambarImg" src="" alt="" style="max-width: 90vw; max-height: 90vh; object-fit: contain; border-radius: 12px;">
</div>

@push('scripts')
<script>
function bukaGambarBesar(src) {
    document.getElementById('lightboxGambarImg').src = src;
    document.getElementById('lightboxGambar').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function tutupGambarBesar() {
    document.getElementById('lightboxGambar').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') tutupGambarBesar(); });
</script>
@endpush

@endsection
