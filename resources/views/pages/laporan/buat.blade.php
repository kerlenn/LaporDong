@extends('layouts.utama')
@section('judul', 'LaporDong - Buat Laporan Baru')

@section('konten')
<div class="ld-page-wrapper">
    <div class="ld-container ld-container--narrow">

        {{-- Header --}}
        <div class="ld-header-section" data-animate="fadeUp">
            <a href="{{ url()->previous() }}" class="ld-btn ld-btn--ghost ld-btn--back ld-btn-back-link">
               <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Kembali
            </a> 
            <h1 class="ld-page-title">Buat Laporan Baru</h1>
            <p class="ld-page-subtitle">Lengkapi formulir di bawah. AI kami akan menganalisis foto dan menentukan prioritas secara otomatis.</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('laporan.kirim') }}" enctype="multipart/form-data">
            @csrf

            <div class="ld-card ld-card--mb" data-animate="fadeUp" data-delay="0.15">
                <div class="ld-card__header">
                    <div>
                        <h2 class="ld-section-title">Informasi Laporan</h2>
                        <p class="ld-section-subtitle">Deskripsikan kerusakan yang Anda temukan</p>
                    </div>
                </div>
                <div class="ld-card__body ld-card-body--stacked">

                    <div class="ld-form-group">
                        <label for="judul" class="ld-label">Judul Laporan <span>*</span></label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                            class="ld-input {{ $errors->has('judul') ? 'ld-input--error' : '' }}"
                            placeholder="Cth: Lubang Besar di Jl. Sudirman Depan Toko Maju" required maxlength="200">
                        @error('judul')<span class="ld-error-msg">{{ $message }}</span>@enderror
                    </div>

                    <div class="ld-form-group">
                        <label for="deskripsi" class="ld-label">Deskripsi Kerusakan <span>*</span></label>
                        <textarea id="deskripsi" name="deskripsi" rows="5"
                            class="ld-textarea {{ $errors->has('deskripsi') ? 'ld-input--error' : '' }}"
                            placeholder="Jelaskan kondisi kerusakan, ukuran perkiraan, dampak terhadap pengendara, dll. (min. 20 karakter)" required minlength="20" maxlength="2000">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<span class="ld-error-msg">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="ld-card ld-card--mb" data-animate="fadeUp" data-delay="0.2">
                <div class="ld-card__header">
                    <div>
                        <h2 class="ld-section-title">Lokasi Kejadian</h2>
                    </div>
                    <button type="button" id="tombolAmbilLokasi" class="ld-btn ld-btn--primer ld-btn--gps">
                        Ambil Lokasi GPS
                    </button>
                </div>
                <div class="ld-card__body ld-card-body--stacked">

                    <p id="statusGPS" class="ld-gps-status"></p>

                    {{-- Fitur Peta Interaktif --}}
                    <div class="ld-map-container">
                        <label class="ld-label">Cari atau Geser Pin pada Peta</label>
                        <div class="ld-map-search-wrap">
                            <input type="text" id="mapSearchInput" class="ld-input" placeholder="Ketik nama jalan atau daerah...">
                            <button type="button" id="btnSearchMap" class="ld-btn ld-btn--primer ">Cari</button>
                        </div>
                        <div id="mapLocation" class="ld-map-view"></div>
                        <p class="ld-map-instruction">Klik atau tarik pin biru di atas untuk menentukan titik persis kerusakan.</p>
                    </div>

                    <div class="ld-grid-half ld-mt-1rem">
                        <div class="ld-form-group">
                            <label for="latitude" class="ld-label">Latitude <span>*</span></label>
                            <input type="number" id="latitude" name="latitude" value="{{ old('latitude') }}"
                                class="ld-input {{ $errors->has('latitude') ? 'ld-input--error' : '' }}"
                                placeholder="-6.9175" step="any" required>
                            @error('latitude')<span class="ld-error-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="ld-form-group">
                            <label for="longitude" class="ld-label">Longitude <span>*</span></label>
                            <input type="number" id="longitude" name="longitude" value="{{ old('longitude') }}"
                                class="ld-input {{ $errors->has('longitude') ? 'ld-input--error' : '' }}"
                                placeholder="107.6191" step="any" required>
                            @error('longitude')<span class="ld-error-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="ld-form-group">
                        <label for="alamat_lengkap" class="ld-label">Alamat Lengkap <span>*</span></label>
                        <input type="text" id="alamat_lengkap" name="alamat_lengkap" value="{{ old('alamat_lengkap') }}"
                            class="ld-input {{ $errors->has('alamat_lengkap') ? 'ld-input--error' : '' }}"
                            placeholder="Jl. Nama Jalan No. XX, RT/RW" required>
                        @error('alamat_lengkap')<span class="ld-error-msg">{{ $message }}</span>@enderror
                    </div>

                    <div class="ld-grid-half">
                        <div class="ld-form-group">
                            <label for="kelurahan" class="ld-label">Kelurahan <span>*</span></label>
                            <input type="text" id="kelurahan" name="kelurahan" value="{{ old('kelurahan') }}"
                                class="ld-input" placeholder="Nama Kelurahan" required>
                        </div>
                        <div class="ld-form-group">
                            <label for="kecamatan" class="ld-label">Kecamatan <span>*</span></label>
                            <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}"
                                class="ld-input" placeholder="Nama Kecamatan" required>
                        </div>
                    </div>

                    <div class="ld-grid-third">
                        <div class="ld-form-group">
                            <label for="kota" class="ld-label">Kota/Kabupaten <span>*</span></label>
                            <input type="text" id="kota" name="kota" value="{{ old('kota') }}"
                                class="ld-input" placeholder="Bandung" required>
                        </div>
                        <div class="ld-form-group">
                            <label for="provinsi" class="ld-label">Provinsi <span>*</span></label>
                            <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi') }}"
                                class="ld-input" placeholder="Jawa Barat" required>
                        </div>
                        <div class="ld-form-group">
                            <label for="kode_pos" class="ld-label">Kode Pos</label>
                            <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}"
                                class="ld-input" placeholder="40111">
                        </div>
                    </div>
                </div>
            </div>

            <div class="ld-card ld-card--mb-lg" data-animate="fadeUp" data-delay="0.25">
                <div class="ld-card__header">
                    <div>
                        <h2 class="ld-section-title">Foto Bukti Kerusakan</h2>
                        <p class="ld-section-subtitle">1-5 foto · Max 5MB per foto · JPG/PNG/WebP</p>
                    </div>
                </div>

                <div class="ld-card__body">
                    <div class="ld-upload-area">
                        <input type="file" name="foto_sebelum" id="inputFoto" accept="image/*" class="sr-only">
                        <div class="ld-upload-teks">
                            <div class="ld-upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#234A89" class="bi bi-image" viewBox="0 0 16 16">
                                  <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                  <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
                                </svg>
                            </div>
                            <p class="ld-upload-title">Klik atau seret foto ke sini</p>
                            <p class="ld-upload-subtitle">Foto yang jelas membantu AI menganalisis lebih akurat</p>
                        </div>
                        <div class="ld-upload-preview ld-upload-preview-container"></div>
                    </div>
                    @error('foto_sebelum')<span class="ld-error-msg mt-2 block">{{ $message }}</span>@enderror
                    @error('foto_sebelum.*')<span class="ld-error-msg mt-2 block">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Submit --}}
            <div class="ld-form-actions" data-animate="fadeUp" data-delay="0.3">
                <a href="{{ route('dasbor.warga') }}" class="ld-btn ld-btn--ghost">Batal</a>
                <button type="submit" class="ld-btn ld-btn--primer ld-btn--lg">
                    Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection