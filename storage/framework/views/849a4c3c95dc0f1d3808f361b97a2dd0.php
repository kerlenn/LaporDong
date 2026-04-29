<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('judul', 'LaporDong'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/lapordong.css')); ?>">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="ld-body antialiased">

<!-- HEADER -->
<header class="ld-header" id="headerUtama">
    <div class="ld-container">
        <nav class="ld-nav">

            <!-- Logo -->
            <a href="<?php echo e(route('beranda')); ?>" class="ld-logo">
                <img src="<?php echo e(asset('images/logo_1.png')); ?>" alt="Logo LaporDong" class="ld-logo__img">
            </a>

            <!-- Navigation -->
            <ul class="ld-nav__links">
                <li><a href="<?php echo e(route('beranda')); ?>" class="ld-nav__link <?php echo e(request()->routeIs('beranda') ? 'aktif' : ''); ?>">Beranda</a></li>
                <li><a href="<?php echo e(route('eksplorasi')); ?>" class="ld-nav__link <?php echo e(request()->routeIs('eksplorasi') ? 'aktif' : ''); ?>">Eksplorasi</a></li>
                <li><a href="<?php echo e(route('statistik')); ?>" class="ld-nav__link <?php echo e(request()->routeIs('statistik') ? 'aktif' : ''); ?>">Statistik</a></li>
            </ul>

            <!-- Auth -->
            <div class="ld-nav__auth">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('masuk')); ?>" class="ld-btn ld-btn--ghost">Masuk</a>
                    <a href="<?php echo e(route('daftar')); ?>" class="ld-btn ld-btn--primer">Daftar</a>
                <?php else: ?>
                    <div class="ld-profil-gradient-wrapper">
                        <div class="ld-nav__profil ld-profil-inner" id="menuProfilToggle">
                            <img src="<?php echo e(Auth::user()->avatar_url); ?>" alt="Profil" class="ld-nav__avatar">
                            <span class="ld-nav__nama"><?php echo e(Str::words(Auth::user()->nama_lengkap, 1, '')); ?></span>

                            <div class="ld-nav__dropdown" id="menuProfil">
                            <div class="ld-nav__dropdown-header">
                                <p><?php echo e(Auth::user()->nama_lengkap); ?></p>
                            <?php if(Auth::user()->peran === 'admin'): ?>
                                <small>Admin</small>
                            <?php else: ?>
                                <small><?php echo e(Auth::user()->level); ?></small>
                            <?php endif; ?>
                            </div>

                            <?php if(Auth::user()->peran === 'admin'): ?>
                                <a href="<?php echo e(route('admin.dasbor')); ?>" class="ld-nav__dropdown-item">Dasbor Pemerintah</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('dasbor.warga')); ?>" class="ld-nav__dropdown-item">Dasbor</a>
                            <?php endif; ?>

                            <a href="<?php echo e(route('dasbor.profil')); ?>" class="ld-nav__dropdown-item">Profil</a>

                            <form method="POST" action="<?php echo e(route('keluar')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="ld-nav__dropdown-item-keluar danger">Keluar</button>
                            </form>
                        </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Hamburger -->
            <button class="ld-nav__hamburger" id="hamburger">
                <span></span><span></span><span></span>
            </button>

        </nav>
    </div>

    <!-- Mobile Menu -->
    <div class="ld-mobile-menu" id="mobileMenu">
        <a href="<?php echo e(route('beranda')); ?>">Beranda</a>
        <a href="<?php echo e(route('eksplorasi')); ?>">Eksplorasi</a>
        <a href="<?php echo e(route('statistik')); ?>">Statistik</a>
    </div>
</header>

<!-- FLASH -->
<?php if(session('sukses')): ?>
<div class="ld-flash ld-flash--sukses" data-flash>
    <span><?php echo e(session('sukses')); ?></span>
    <button class="ld-flash__close">&times;</button>
</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="ld-flash ld-flash--error" data-flash>
    <span><?php echo e(session('error')); ?></span>
    <button class="ld-flash__close">&times;</button>
</div>
<?php endif; ?>

<!-- MAIN -->
<main id="kontenUtama">
    <?php echo $__env->yieldContent('konten'); ?>
</main>

<!-- FOOTER -->
<footer class="ld-footer">
    <div class="ld-container">

        <div class="ld-footer__grid">

            <!-- Brand -->
            <div class="ld-footer__brand">
                <div class="ld-logo">
                    <img src="<?php echo e(asset('images/logo_white.png')); ?>" alt="Logo LaporDong" class="ld-logo__img-footer">
                </div>

                <p class="ld-footer__desc">
                    Platform website pelaporan kerusakan jalan untuk menuju Indonesia yang lebih baik.
                </p>
            </div>

            <!-- Platform -->
            <div>
                <h4 class="ld-footer__heading">Platform</h4>
                <ul class="ld-footer__links">
                    <li><a href="<?php echo e(route('beranda')); ?>">Beranda</a></li>
                    <li><a href="<?php echo e(route('eksplorasi')); ?>">Eksplorasi</a></li>
                    <li><a href="<?php echo e(route('statistik')); ?>">Statistik</a></li>
                </ul>
            </div>

            <div>
                <h4 class="ld-footer__heading">Akun</h4>
                <ul class="ld-footer__links">
                    <?php if(auth()->guard()->guest()): ?>
                        <li><a href="<?php echo e(route('daftar')); ?>">Daftar</a></li>
                        <li><a href="<?php echo e(route('masuk')); ?>">Masuk</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo e(route('dasbor.warga')); ?>">Dasbor</a></li>
                        <li><a href="<?php echo e(route('laporan.buat')); ?>">Buat Laporan</a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>

        <div class="ld-footer__bottom">
            <p>© <?php echo e(date('Y')); ?> LaporDong. Dibuat untuk Negera Indonesia</p>
            <p class="ld-footer__tech">Dibuat oleh UCCD_KicauMania</p>
        </div>

    </div>
</footer>

<!-- Scripts -->
<script src="<?php echo e(asset('js/lapordong.js')); ?>"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/layouts/utama.blade.php ENDPATH**/ ?>