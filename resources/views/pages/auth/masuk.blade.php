@extends('layouts.utama')
@section('judul', 'LaporDong - Masuk')

@section('konten')
<div class="ld-auth-wrapper">

    <div class="ld-auth-container">

        <div class="ld-auth-header">
            <a href="{{ route('beranda') }}" class="ld-logo">
                <img src="{{ asset('images/logo_1.png') }}" alt="Logo LaporDong" class="ld-logo_img_daftar">
            </a>
            <p class="ld-auth-subtext">Selamat datang kembali!</p>
        </div>

        <div class="ld-card ld-auth-card" data-delay="0.1">
            <div class="ld-card__header">
                <div>
                    <h1 class="ld-auth-title">Masuk ke Akun</h1>
                </div>
            </div>

            <div class="ld-card__body">
                <form method="POST" action="{{ route('masuk') }}" class="ld-auth-form">
                    @csrf

                    <div class="ld-form-group">
                        <label for="email" class="ld-label">Alamat Email <span>*</span></label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email') }}"
                            class="ld-input {{ $errors->has('email') ? 'ld-input--error' : '' }}"
                            placeholder="Tuliskan Alamat Emailmu" required autofocus>
                        @error('email')<span class="ld-error-msg">{{ $message }}</span>@enderror
                    </div>

                    <div class="ld-form-group">
                        <div class="ld-password-header">
                            <label for="password" class="ld-label">Password <span>*</span></label>
                        </div>
                        <input type="password" id="password" name="password"
                            class="ld-input {{ $errors->has('password') ? 'ld-input--error' : '' }}"
                            placeholder="Masukkan password" required>
                        @error('password')<span class="ld-error-msg">{{ $message }}</span>@enderror
                    </div>

                    <div class="ld-remember">
                        <input type="checkbox" id="ingat_saya" name="ingat_saya" class="ld-checkbox">
                        <label for="ingat_saya" class="ld-remember-label">Ingat saya</label>
                    </div>

                    <button type="submit" class="ld-btn ld-btn--primer ld-login-btn">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="ld-auth-footer">
                    <p>
                        Belum punya akun?
                        <a href="{{ route('daftar') }}" class="ld-auth-link">Daftar gratis</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection