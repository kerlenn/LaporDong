@extends('layouts.utama')

@section('judul', 'Kelola Laporan')

@section('konten')
<section class="py-8 px-4 min-h-screen" style="background: var(--warna-latar);">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-6" data-animate="fadeUp">
            <h1 class="text-3xl font-bold" style="color: var(--warna-indigo); font-family: var(--font-display);">
                Kelola Laporan
            </h1>
            <p style="color: var(--warna-teks-muted);">
                Total <strong>{{ $laporan->total() }}</strong> laporan ditemukan
            </p>
        </div>

        {{-- Filter Panel --}}
        <div class="ld-card p-5 mb-6" data-animate="fadeUp">
            <form method="GET" action="{{ route('admin.laporan.daftar') }}"
                class="flex flex-wrap gap-3 items-end">
                <div class="flex-1" style="min-width: 200px;">
                    <label class="ld-label">Cari</label>
                    <input type="text" name="cari" value="{{ request('cari') }}"
                        placeholder="Judul, kode, nama pelapor..."
                        class="ld-input mt-1">
                </div>
                <div style="min-width: 140px;">
                    <label class="ld-label">Status</label>
                    <select name="status" class="ld-input mt-1">
                        <option value="">Semua Status</option>
                        @foreach(['dikirim','diverifikasi','diproses','selesai','ditolak'] as $s)
                            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="min-width: 140px;">
                    <label class="ld-label">Prioritas</label>
                    <select name="prioritas" class="ld-input mt-1">
                        <option value="">Semua Prioritas</option>
                        @foreach(['tinggi','sedang','rendah'] as $p)
                            <option value="{{ $p }}" {{ request('prioritas') === $p ? 'selected' : '' }}>
                                {{ ucfirst($p) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="min-width: 180px;">
                    <label class="ld-label">Kota / Provinsi</label>
                    <input type="text" name="kota" value="{{ request('kota') }}"
                        placeholder="Cth: Bandung" class="ld-input mt-1">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="ld-btn-primer ld-btn-sm">Filter</button>
                    @if(request()->hasAny(['cari','status','prioritas','kota']))
                        <a href="{{ route('admin.laporan.daftar') }}" class="ld-btn-ghost ld-btn-sm">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel Laporan --}}
        <div class="ld-card overflow-hidden" data-animate="fadeUp">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="background: var(--warna-latar-kartu-2); border-bottom: 2px solid var(--warna-icy);">
                            <th class="text-left py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Laporan</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Pelapor</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Status</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Prioritas</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Petugas</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $item)
                            <tr class="hover:bg-blue-50 transition-colors"
                                style="border-bottom: 1px solid var(--warna-icy);">

                                {{-- Laporan Info --}}
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        @if($item->foto_sebelum)
                                            <img src="{{ Storage::url(is_array($item->foto_sebelum) ? $item->foto_sebelum[0] : $item->foto_sebelum) }}"
                                                alt="Foto" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                        @else
                                            <div class="w-12 h-12 rounded-lg flex items-center justify-center text-xl"
                                                style="background: var(--warna-icy);">🛣️</div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-sm max-w-xs truncate" style="color: var(--warna-teks);">
                                                {{ $item->judul }}
                                            </p>
                                            <p class="text-xs font-mono" style="color: var(--warna-cobalt);">
                                                {{ $item->kode_laporan }}
                                            </p>
                                            <p class="text-xs" style="color: var(--warna-teks-muted);">
                                                📍 {{ $item->kota }}, {{ $item->provinsi }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Pelapor --}}
                                <td class="py-3 px-4">
                                    <p class="text-sm font-medium" style="color: var(--warna-teks);">
                                        {{ $item->pelapor->nama }}
                                    </p>
                                    <p class="text-xs" style="color: var(--warna-teks-muted);">
                                        {{ $item->created_at->format('d M Y') }}
                                    </p>
                                </td>

                                {{-- Status --}}
                                <td class="py-3 px-4 text-center">
                                    <span class="ld-badge ld-badge-{{ $item->status }}">
                                        {{ $item->label_status }}
                                    </span>
                                </td>

                                {{-- Prioritas --}}
                                <td class="py-3 px-4 text-center">
                                    @if($item->prioritas_ai)
                                        <span class="text-xs font-semibold px-2 py-1 rounded-full"
                                            style="background: {{ $item->warna_prioritas }}20; color: {{ $item->warna_prioritas }};">
                                            {{ $item->label_prioritas }}
                                        </span>
                                    @else
                                        <span class="text-xs" style="color: var(--warna-teks-muted);">—</span>
                                    @endif
                                </td>

                                {{-- Petugas --}}
                                <td class="py-3 px-4">
                                    @if($item->petugas)
                                        <p class="text-sm font-medium" style="color: var(--warna-teks);">
                                            {{ $item->petugas->nama }}
                                        </p>
                                    @else
                                        <span class="text-xs" style="color: var(--warna-teks-muted);">Belum ditugaskan</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="py-3 px-4">
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        <a href="{{ route('laporan.detail', $item) }}"
                                            class="ld-btn-ghost ld-btn-sm">Detail</a>

                                        @if($item->status === 'dikirim')
                                            <form method="POST" action="{{ route('admin.laporan.verifikasi', $item) }}" class="inline">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="aksi" value="terima">
                                                <button type="submit" class="ld-btn-primer ld-btn-sm"
                                                    data-konfirmasi="Verifikasi laporan ini?">
                                                    ✅ Verifikasi
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.laporan.verifikasi', $item) }}" class="inline">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="aksi" value="tolak">
                                                <button type="submit" class="ld-btn-danger ld-btn-sm"
                                                    data-konfirmasi="Tolak laporan ini?">
                                                    ❌ Tolak
                                                </button>
                                            </form>
                                        @endif

                                        @if($item->status === 'diverifikasi')
                                            <button type="button"
                                                class="ld-btn-outline ld-btn-sm"
                                                onclick="bukaModalTugaskan({{ $item->id }}, '{{ addslashes($item->judul) }}')">
                                                👷 Tugaskan
                                            </button>
                                        @endif

                                        @if($item->status === 'diproses')
                                            <button type="button"
                                                class="ld-btn-primer ld-btn-sm"
                                                onclick="bukaModalSelesai({{ $item->id }}, '{{ addslashes($item->judul) }}')">
                                                🏆 Selesaikan
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <div class="text-4xl mb-3">🔍</div>
                                    <p style="color: var(--warna-teks-muted);">
                                        Tidak ada laporan yang sesuai filter
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($laporan->hasPages())
                <div class="p-5 border-t" style="border-color: var(--warna-icy);">
                    {{ $laporan->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>
</section>

{{-- Modal Tugaskan Petugas --}}
<div id="modalTugaskan" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
    style="background: rgba(0,0,0,0.5);">
    <div class="ld-card p-6 w-full max-w-md" data-animate="fadeUp">
        <h3 class="text-xl font-bold mb-2" style="color: var(--warna-indigo);">
            👷 Tugaskan Petugas
        </h3>
        <p class="text-sm mb-4" id="judulTugaskan" style="color: var(--warna-teks-muted);"></p>
        <form method="POST" id="formTugaskan" action="">
            @csrf @method('PATCH')
            <div class="mb-4">
                <label class="ld-label">Pilih Petugas</label>
                <select name="petugas_id" class="ld-input mt-1" required>
                    <option value="">— Pilih Petugas —</option>
                    @foreach($semuaPetugas as $petugas)
                        <option value="{{ $petugas->id }}">
                            {{ $petugas->nama }} ({{ $petugas->tugasSaya()->where('status','diproses')->count() }} tugas aktif)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="ld-label">Catatan (Opsional)</label>
                <textarea name="catatan" rows="2" class="ld-input mt-1"
                    placeholder="Instruksi khusus untuk petugas..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="ld-btn-primer flex-1">Tugaskan</button>
                <button type="button" onclick="tutupModal('modalTugaskan')"
                    class="ld-btn-ghost flex-1">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Selesaikan --}}
<div id="modalSelesai" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
    style="background: rgba(0,0,0,0.5);">
    <div class="ld-card p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-2" style="color: var(--warna-indigo);">
            🏆 Selesaikan Laporan
        </h3>
        <p class="text-sm mb-4" id="judulSelesai" style="color: var(--warna-teks-muted);"></p>
        <form method="POST" id="formSelesai" action="" enctype="multipart/form-data">
            @csrf @method('PATCH')
            <div class="mb-4">
                <label class="ld-label">Foto Sesudah Perbaikan <span style="color: #EF4444;">*</span></label>
                <div class="ld-upload-area mt-1" id="uploadSelesai">
                    <input type="file" name="foto_sesudah" id="fotoSelesai" accept="image/*" required class="sr-only">
                    <label for="fotoSelesai" class="cursor-pointer block text-center p-6">
                        <div class="text-3xl mb-2">📸</div>
                        <p class="text-sm font-medium" style="color: var(--warna-cobalt);">
                            Klik untuk unggah foto sesudah
                        </p>
                    </label>
                    <img id="previewSelesai" class="hidden w-full rounded-xl mt-2 max-h-48 object-cover">
                </div>
            </div>
            <div class="mb-4">
                <label class="ld-label">Catatan Penyelesaian</label>
                <textarea name="catatan" rows="2" class="ld-input mt-1"
                    placeholder="Deskripsi pekerjaan yang telah dilakukan..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="ld-btn-primer flex-1">Tandai Selesai</button>
                <button type="button" onclick="tutupModal('modalSelesai')"
                    class="ld-btn-ghost flex-1">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function bukaModalTugaskan(id, judul) {
    document.getElementById('judulTugaskan').textContent = judul;
    document.getElementById('formTugaskan').action = `/admin/laporan/${id}/tugaskan`;
    const modal = document.getElementById('modalTugaskan');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function bukaModalSelesai(id, judul) {
    document.getElementById('judulSelesai').textContent = judul;
    document.getElementById('formSelesai').action = `/admin/laporan/${id}/selesaikan`;
    const modal = document.getElementById('modalSelesai');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function tutupModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Preview foto sesudah
document.getElementById('fotoSelesai').addEventListener('change', function(e) {
    if (e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = (ev) => {
            const img = document.getElementById('previewSelesai');
            img.src = ev.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

// Tutup modal klik luar
['modalTugaskan','modalSelesai'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) tutupModal(id);
    });
});
</script>
@endsection
