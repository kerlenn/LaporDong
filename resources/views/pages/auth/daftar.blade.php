@extends('layouts.utama') 
@section('judul', 'LaporDong - Daftar Akun Baru') 

@section('konten')
<div class="ld-auth-wrapper">

    <div class="ld-auth-container">

        <div class="ld-auth-header">
            <a href="{{ route('beranda') }}" class="ld-logo">
                <img src="{{ asset('images/logo_1.png') }}" alt="Logo LaporDong" class="ld-logo_img_daftar">
            </a>
            <p class="ld-auth-subtext">Bergabung dan bantu bangun Indonesia yang lebih baik!</p>
        </div>

        <div class="ld-card ld-auth-card" data-delay="0.1">
            <div class="ld-card__header">
                <div>
                    <h1 class="ld-auth-title">Buat Akun Baru</h1>
                </div>
            </div>

            <div class="ld-card__body">
                <form method="POST" action="{{ route('daftar') }}" class="ld-auth-form">
                    @csrf

                    <div class="ld-form-group">
                        <label for="nama_lengkap" class="ld-label">Nama Lengkap <span>*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                            value="{{ old('nama_lengkap') }}"
                            class="ld-input {{ $errors->has('nama_lengkap') ? 'ld-input--error' : '' }}"
                            placeholder="Tuliskan Nama Lengkapmu" required autofocus>
                        @error('nama_lengkap')<span class="ld-error-msg">{{ $message }}</span>@enderror
                    </div>

                    <div class="ld-form-group">
                        <label for="email" class="ld-label">Alamat Email <span>*</span></label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email') }}"
                            class="ld-input {{ $errors->has('email') ? 'ld-input--error' : '' }}"
                            placeholder="Tuliskan Alamat Emailmu" required>
                        @error('email')<span class="ld-error-msg">{{ $message }}</span>@enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="ld-form-group">
                            <label for="no_telepon" class="ld-label">No. Telepon</label>
                            <input type="tel" id="no_telepon" name="no_telepon"
                                value="{{ old('no_telepon') }}"
                                class="ld-input" placeholder="Tuliskan No. Teleponmu">
                        </div>
                        <div class="ld-form-group">
                            <label for="kota_domisili" class="ld-label">Kota Domisili</label>
                            <input type="text" id="kota_domisili" name="kota_domisili"
                                value="{{ old('kota_domisili') }}"
                                class="ld-input" placeholder="Tuliskan Kota Domisilimu">
                        </div>
                    </div>

                    <div class="ld-form-group">
                        <label for="password" class="ld-label">Password <span>*</span></label>
                        <input type="password" id="password" name="password"
                            class="ld-input {{ $errors->has('password') ? 'ld-input--error' : '' }}"
                            placeholder="Minimal 8 karakter" required>
                        @error('password')<span class="ld-error-msg">{{ $message }}</span>@enderror
                    </div>

                    <div class="ld-form-group">
                        <label for="password_confirmation" class="ld-label">Konfirmasi Password <span>*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="ld-input" placeholder="Ulangi password" required>
                    </div>

                    <button type="submit" class="ld-btn ld-btn--primer ld-login-btn">
                        Buat Akun Sekarang
                    </button>
                </form>

                <div class="ld-auth-footer">
                    <p>
                        Sudah punya akun?
                        <a href="{{ route('masuk') }}" class="ld-auth-link">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
