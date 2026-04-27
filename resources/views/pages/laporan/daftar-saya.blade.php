@extends('layouts.utama')

@section('judul', 'Laporan Saya')

@section('konten')
<section class="py-10 px-4 min-h-screen" style="background: var(--warna-latar);">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="mb-8" data-animate="fadeUp">
            <h1 class="text-3xl font-bold" style="color: var(--warna-indigo); font-family: var(--font-display);">
                Laporan Saya
            </h1>
            <p class="mt-1" style="color: var(--warna-teks-muted);">
                Pantau semua laporan kerusakan yang pernah kamu kirimkan
            </p>
        </div>

        {{-- Filter Bar --}}
        <div class="ld-card mb-6 p-4" data-animate="fadeUp">
            <form method="GET" action="{{ route('laporan.daftar-saya') }}" class="flex flex-wrap gap-3 items-center">
                <select name="status" class="ld-input" style="width: auto; min-width: 160px;">
                    <option value="">Semua Status</option>
                    @foreach(['dikirim','diverifikasi','diproses','selesai','ditolak'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul atau kode..."
                    class="ld-input flex-1" style="min-width: 200px;">
                <button type="submit" class="ld-btn-primer ld-btn-sm">Filter</button>
                @if(request()->hasAny(['status','cari']))
                    <a href="{{ route('laporan.daftar-saya') }}" class="ld-btn-ghost ld-btn-sm">Reset</a>
                @endif
            </form>
        </div>

        {{-- Daftar Laporan --}}
        @if($laporan->isEmpty())
            <div class="ld-card p-16 text-center" data-animate="fadeUp">
                <div class="text-6xl mb-4">📋</div>
                <h3 class="text-xl font-semibold mb-2" style="color: var(--warna-indigo);">Belum Ada Laporan</h3>
                <p style="color: var(--warna-teks-muted);" class="mb-6">
                    Kamu belum pernah mengirimkan laporan kerusakan jalan.
                </p>
                <a href="{{ route('laporan.buat') }}" class="ld-btn-primer">
                    + Buat Laporan Pertama
                </a>
            </div>
        @else
            <div class="space-y-4" data-animate-grid>
                @foreach($laporan as $item)
                    <div class="ld-card p-5 hover:shadow-lg transition-all duration-300" style="border-left: 4px solid var(--warna-cobalt);">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">

                            {{-- Foto Thumbnail --}}
                            @if($item->foto_sebelum)
                                <div class="flex-shrink-0">
                                    <img src="{{ Storage::url(is_array($item->foto_sebelum) ? $item->foto_sebelum[0] : $item->foto_sebelum) }}"
                                        alt="Foto kerusakan"
                                        class="w-20 h-20 object-cover rounded-xl"
                                        style="border: 2px solid var(--warna-icy);">
                                </div>
                            @else
                                <div class="flex-shrink-0 w-20 h-20 rounded-xl flex items-center justify-center text-3xl"
                                    style="background: var(--warna-icy);">🛣️</div>
                            @endif

                            {{-- Info Utama --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap gap-2 items-center mb-1">
                                    <span class="text-xs font-mono px-2 py-0.5 rounded"
                                        style="background: var(--warna-icy); color: var(--warna-cobalt);">
                                        {{ $item->kode_laporan }}
                                    </span>
                                    <span class="ld-badge ld-badge-{{ $item->status }}">
                                        {{ $item->label_status }}
                                    </span>
                                    @if($item->prioritas_ai)
                                        <span class="ld-badge"
                                            style="background: {{ $item->warna_prioritas }}20; color: {{ $item->warna_prioritas }}; border: 1px solid {{ $item->warna_prioritas }}40;">
                                            {{ $item->label_prioritas }} Priority
                                        </span>
                                    @endif
                                </div>
                                <h3 class="font-semibold text-lg truncate" style="color: var(--warna-indigo);">
                                    {{ $item->judul }}
                                </h3>
                                <p class="text-sm mt-0.5" style="color: var(--warna-teks-muted);">
                                    📍 {{ $item->kota }}, {{ $item->provinsi }}
                                    &nbsp;·&nbsp;
                                    🕐 {{ $item->created_at->diffForHumans() }}
                                </p>
                            </div>

                            {{-- Aksi --}}
                            <div class="flex flex-col gap-2 flex-shrink-0">
                                <a href="{{ route('laporan.detail', $item) }}" class="ld-btn-primer ld-btn-sm text-center">
                                    Lihat Detail
                                </a>
                                @if($item->status === 'selesai' && !$item->ulasan)
                                    <a href="{{ route('laporan.ulasan.form', $item) }}" class="ld-btn-outline ld-btn-sm text-center">
                                        ⭐ Beri Ulasan
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Progress Bar Status --}}
                        @php
                            $steps = ['dikirim','diverifikasi','diproses','selesai'];
                            $currentStep = array_search($item->status, $steps);
                            $progress = $item->status === 'ditolak' ? 0 : (($currentStep + 1) / count($steps)) * 100;
                        @endphp
                        @if($item->status !== 'ditolak')
                            <div class="mt-3">
                                <div class="h-1.5 rounded-full" style="background: var(--warna-icy);">
                                    <div class="h-1.5 rounded-full transition-all duration-700"
                                        style="width: {{ $progress }}%; background: linear-gradient(90deg, var(--warna-indigo), var(--warna-cobalt));">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $laporan->withQueryString()->links() }}
            </div>
        @endif

    </div>
</section>
@endsection
