@extends('layouts.utama')

@section('judul', 'Beri Ulasan - ' . $laporan->kode_laporan)

@section('konten')
<section class="py-10 px-4 min-h-screen" style="background: var(--warna-latar);">
    <div class="max-w-2xl mx-auto">

        <div data-animate="fadeUp">
            <a href="{{ route('laporan.detail', $laporan) }}"
                class="inline-flex items-center gap-2 mb-6 text-sm font-medium"
                style="color: var(--warna-cobalt);">
                ← Kembali ke Detail Laporan
            </a>
        </div>

        {{-- Header Card --}}
        <div class="ld-card p-6 mb-6" data-animate="fadeUp"
            style="background: linear-gradient(135deg, var(--warna-indigo) 0%, var(--warna-cobalt) 100%); color: white;">
            <div class="flex items-center gap-4">
                <div class="text-4xl">🏆</div>
                <div>
                    <h1 class="text-2xl font-bold" style="font-family: var(--font-display);">
                        Laporan Selesai!
                    </h1>
                    <p class="opacity-80 mt-1">
                        Bagikan pengalamanmu terkait penanganan laporan <strong>{{ $laporan->kode_laporan }}</strong>
                    </p>
                </div>
            </div>
        </div>

        {{-- Ringkasan Laporan --}}
        <div class="ld-card p-5 mb-6" data-animate="fadeUp">
            <h3 class="font-semibold mb-3" style="color: var(--warna-indigo);">Laporan yang Diselesaikan</h3>
            <div class="flex gap-4">
                @if($laporan->foto_sesudah)
                    <img src="{{ Storage::url(is_array($laporan->foto_sesudah) ? $laporan->foto_sesudah[0] : $laporan->foto_sesudah) }}" alt="Sesudah"
                        class="w-20 h-20 object-cover rounded-xl flex-shrink-0">
                @endif
                <div>
                    <p class="font-medium" style="color: var(--warna-teks);">{{ $laporan->judul }}</p>
                    <p class="text-sm mt-1" style="color: var(--warna-teks-muted);">
                        📍 {{ $laporan->alamat_lengkap }}
                    </p>
                    <p class="text-sm" style="color: var(--warna-teks-muted);">
                        ✅ Selesai {{ $laporan->updated_at->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Form Ulasan --}}
        <div class="ld-card p-6" data-animate="fadeUp">
            <h2 class="text-xl font-bold mb-6" style="color: var(--warna-indigo); font-family: var(--font-display);">
                Berikan Penilaianmu
            </h2>

            <form method="POST" action="{{ route('laporan.ulasan.simpan', $laporan) }}">
                @csrf

                {{-- Rating Bintang --}}
                <div class="mb-6">
                    <label class="ld-label">
                        Rating Kepuasan <span style="color: #EF4444;">*</span>
                    </label>
                    <div class="mt-3">
                        <div class="ld-star-rating" id="starRating">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="ld-star" data-nilai="{{ $i }}" aria-label="{{ $i }} bintang">
                                    ★
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="bintang" id="inputBintang" value="{{ old('bintang', 0) }}" required>
                        <p class="text-sm mt-2" id="labelBintang" style="color: var(--warna-teks-muted);">
                            Klik bintang untuk menilai
                        </p>
                    </div>
                    @error('bintang')
                        <p class="ld-pesan-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Komentar --}}
                <div class="mb-6">
                    <label for="komentar" class="ld-label">
                        Komentar <span style="color: var(--warna-teks-muted); font-weight: 400;">(Opsional)</span>
                    </label>
                    <textarea id="komentar" name="komentar" rows="4"
                        class="ld-input mt-1 @error('komentar') ld-input-error @enderror"
                        placeholder="Ceritakan pengalamanmu — apakah penanganan sudah memuaskan?">{{ old('komentar') }}</textarea>
                    @error('komentar')
                        <p class="ld-pesan-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Anonim Toggle --}}
                <div class="mb-6 p-4 rounded-xl" style="background: var(--warna-latar-kartu-2);">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="is_anonim" id="isAnonim" class="sr-only"
                                {{ old('is_anonim') ? 'checked' : '' }}>
                            <div class="ld-toggle-track" id="toggleTrack"></div>
                            <div class="ld-toggle-thumb" id="toggleThumb"></div>
                        </div>
                        <div>
                            <p class="font-medium" style="color: var(--warna-teks);">Kirim sebagai Anonim</p>
                            <p class="text-sm" style="color: var(--warna-teks-muted);">
                                Nama kamu tidak akan ditampilkan di ulasan publik
                            </p>
                        </div>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="ld-btn-primer w-full"
                    id="btnKirimUlasan" disabled style="opacity: 0.5; cursor: not-allowed;">
                    Kirim Ulasan
                </button>
            </form>
        </div>

    </div>
</section>

<style>
.ld-star-rating {
    display: flex;
    gap: 8px;
}
.ld-star {
    font-size: 2.5rem;
    background: none;
    border: none;
    cursor: pointer;
    color: #D1D5DB;
    transition: color 0.2s, transform 0.15s;
    line-height: 1;
    padding: 0;
}
.ld-star:hover,
.ld-star.aktif {
    color: #F59E0B;
}
.ld-star:hover {
    transform: scale(1.15);
}
.ld-toggle-track {
    width: 44px;
    height: 24px;
    border-radius: 12px;
    background: #D1D5DB;
    transition: background 0.3s;
}
.ld-toggle-thumb {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: white;
    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
    transition: transform 0.3s;
}
input#isAnonim:checked ~ #toggleTrack {
    background: var(--warna-cobalt);
}
input#isAnonim:checked ~ #toggleThumb {
    transform: translateX(20px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.ld-star');
    const inputBintang = document.getElementById('inputBintang');
    const labelBintang = document.getElementById('labelBintang');
    const btnKirim = document.getElementById('btnKirimUlasan');
    const toggleTrack = document.getElementById('toggleTrack');
    const toggleThumb = document.getElementById('toggleThumb');
    const checkAnonim = document.getElementById('isAnonim');

    const labelMap = {
        1: '😞 Sangat Tidak Puas',
        2: '😕 Kurang Memuaskan',
        3: '😐 Cukup',
        4: '😊 Puas',
        5: '🤩 Sangat Puas!'
    };

    function setRating(nilai) {
        stars.forEach((s, i) => {
            s.classList.toggle('aktif', i < nilai);
        });
        inputBintang.value = nilai;
        labelBintang.textContent = labelMap[nilai] || 'Klik bintang untuk menilai';
        btnKirim.disabled = false;
        btnKirim.style.opacity = '1';
        btnKirim.style.cursor = 'pointer';
    }

    stars.forEach((star, idx) => {
        star.addEventListener('click', () => setRating(idx + 1));
        star.addEventListener('mouseenter', () => {
            stars.forEach((s, i) => s.style.color = i <= idx ? '#F59E0B' : '#D1D5DB');
        });
        star.addEventListener('mouseleave', () => {
            const current = parseInt(inputBintang.value) || 0;
            stars.forEach((s, i) => s.style.color = i < current ? '#F59E0B' : '#D1D5DB');
        });
    });

    // Pre-fill old value
    const oldVal = parseInt(inputBintang.value);
    if (oldVal > 0) setRating(oldVal);

    // Anonim toggle style
    checkAnonim.addEventListener('change', function () {
        if (this.checked) {
            toggleTrack.style.background = 'var(--warna-cobalt)';
            toggleThumb.style.transform = 'translateX(20px)';
        } else {
            toggleTrack.style.background = '#D1D5DB';
            toggleThumb.style.transform = 'translateX(0)';
        }
    });
});
</script>
@endsection
