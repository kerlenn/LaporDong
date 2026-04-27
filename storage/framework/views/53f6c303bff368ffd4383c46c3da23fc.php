<?php $__env->startSection('judul', 'LaporDong - Laporkan Kerusakan Jalan'); ?>

<?php $__env->startSection('konten'); ?>


<section class="ld-hero">
    <div class="ld-hero__bg">
        <div class="ld-hero__orb ld-hero__orb--1"></div>
        <div class="ld-hero__orb ld-hero__orb--2"></div>
        <div class="ld-hero__orb ld-hero__orb--3"></div>
    </div>

    <div class="ld-container ld-hero__container">
        <div class="ld-hero__grid">

            <div class="ld-hero__konten">

                <h1 class="ld-hero__judul">
                    Laporkan Jalan Rusak,<br>
                    <span class="aksen">Indonesia Lebih Baik</span>
                </h1>

                <p class="ld-hero__desc">
                    Platform pelaporan jalan antara warga dan pemerintah dengan bantuan AI untuk menilai dan menentukan prioritas perbaikan.
                </p>

                <div class="ld-hero__aksi">
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('daftar')); ?>" class="ld-btn ld-btn--primer ld-btn--lg">
                            Mulai Laporkan
                        </a>
                        <a href="<?php echo e(route('eksplorasi')); ?>" class="ld-btn ld-btn--ghost ld-btn--lg">
                            Eksplorasi Laporan
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('laporan.buat')); ?>" class="ld-btn ld-btn--primer ld-btn--lg">
                            Buat Laporan Baru
                        </a>
                        <a href="<?php echo e(route('dasbor.warga')); ?>" class="ld-btn ld-btn--ghost ld-btn--lg">
                            Dasbor Saya
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="image-card-gradient">

            <div class="image-card-inner">

                <!-- IMAGE -->
                <div class="image-card-img">
                    <img src="<?php echo e(asset('images/jalanrusak.png')); ?>" alt="Jalan Rusak">
                </div>

                <!-- TEXT -->
                <div class="image-card-content">
                    <div class="image-card-title">
                        Jalan rusak parah di pusat kota
                    </div>

                    <div class="image-card-location">
                        Grogol, Jakarta Barat
                    </div>
                </div>

            </div>

            <!-- AI BADGE -->
            <div class="ai-badge">
                 <div class="ld-ai-badge__ikon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-stars" viewBox="0 0 16 16">
                    <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
                    </svg></div>
                <div>
                    <div class="ai-title">AI Analisis Aktif</div>
                    <div class="ai-sub">Gemini Flash 1.5</div>
                </div>
            </div>

        </div>
    </div>
</div>


    </div>
</section>


<section class="ld-section-stats">
    <div class="ld-container">
        <div class="ld-stats-strip">
            <div class="ld-stat-item">
                <div class="ld-stat-item__angka" data-count="<?php echo e($statistikPublik['total_laporan']); ?>" data-satuan="">0</div>
                <div class="ld-stat-item__label">Total Laporan</div>
            </div>
            <div class="ld-stat-item">
                <div class="ld-stat-item__angka" data-count="<?php echo e($statistikPublik['laporan_selesai']); ?>" data-satuan="">0</div>
                <div class="ld-stat-item__label">Berhasil Diperbaiki</div>
            </div>
            <div class="ld-stat-item">
                <div class="ld-stat-item__angka" data-count="<?php echo e($statistikPublik['kota_terlayani']); ?>" data-satuan="">0</div>
                <div class="ld-stat-item__label">Kota Terlayani</div>
            </div>
            <div class="ld-stat-item">
                <div class="ld-stat-item__angka ld-stat-item__angka--text"><?php echo e($statistikPublik['rata_penyelesaian']); ?></div>
                <div class="ld-stat-item__label">Rata-rata Penyelesaian</div>
            </div>
        </div>
    </div>
</section>


<section class="ld-section ld-section--white">
    <div class="ld-container">
        <div class="ld-section-header" data-animate="fadeUp">

            <h2 class="ld-section-title">4 Langkah Mudah Melapor</h2>
            <p class="ld-section-desc ld-section-desc--center">Dari foto hingga perbaikan, proses yang transparan dan terpantau</p>
        </div>

        <div class="ld-langkah-grid">
            <?php $__currentLoopData = $langkah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="ld-card ld-card--langkah">
                <div class="ld-card__body ld-card__body--langkah">
                    <div class="ld-langkah__ikon-wrap">
                        <?php echo $item['ikon']; ?>

                        <span class="ld-langkah__nomor"><?php echo e($item['nomor']); ?></span>
                    </div>
                    <h3 class="ld-langkah__judul"><?php echo e($item['judul']); ?></h3>
                    <p class="ld-langkah__desc"><?php echo e($item['desc']); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="ld-section">
    <div class="ld-container">
        <div class="ld-fitur-grid">

            <div class="gamifikasi_border">
                <h2 class="ld-section-title-card">Kecerdasan Buatan untuk<br>Infrastruktur Indonesia</h2>
                <p class="ld-section-desc">AI mempercepat proses laporan jalan dengan menganalisis foto, menilai tingkat kerusakan, memperkirakan urgensi, dan membantu pemerintah mengambil keputusan yang lebih tepat.</p>

                <div class="ld-fitur-ai-list">
                    <?php $__currentLoopData = $fiturAi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fitur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="ld-fitur-ai-item">
                        <div class="ld-fitur-ai-item__ikon"><?php echo $fitur['ikon']; ?></div>
                        <div>
                            <div class="ld-fitur-ai-item__judul"><?php echo e($fitur['judul']); ?></div>
                            <div class="ld-fitur-ai-item__desc"><?php echo e($fitur['desc']); ?></div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="gamifikasi_border">
                <h2 class="ld-section-title-card">Kumpulkan Badge,<br>Jadilah Pahlawan Negara!</h2>
                <p class="ld-section-desc">Setiap kontribusi yang Anda lakukan akan menambah poin dan membuka badge baru. Semakin aktif, semakin banyak penghargaan!</p>

                <div class="ld-badge-grid">
                    <?php $__currentLoopData = $contohBadge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="ld-badge-card">
                        <div class="ld-badge-card__ikon"><?php echo e($badge['ikon']); ?></div>
                        <div class="ld-badge-card__nama"><?php echo e($badge['nama']); ?></div>
                        <div class="ld-badge-card__desc"><?php echo e($badge['syarat']); ?></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="ld-section-cta">
    <div class="ld-container ld-section-cta__inner">
        <h2 class="ld-section-cta__judul">
            Mulai Berkontribusi Hari Ini!
        </h2>
        <p class="ld-section-cta__desc">
            Bersama-sama kita bangun infrastruktur Indonesia yang lebih baik. Satu laporan bisa membawa perubahan.
        </p>
        <div class="ld-section-cta__aksi">
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('daftar')); ?>" class="ld-btn ld-btn--primer ld-btn--lg">
                    Daftar Sekarang
                </a>
                <a href="<?php echo e(route('eksplorasi')); ?>" class="ld-btn ld-btn--ghost ld-btn--lg">
                    Eksplorasi Laporan
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('laporan.buat')); ?>" class="ld-btn ld-btn--primer ld-btn--lg">
                    Buat Laporan Baru
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/beranda.blade.php ENDPATH**/ ?>