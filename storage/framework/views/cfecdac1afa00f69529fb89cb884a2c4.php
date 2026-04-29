<?php $__env->startSection('judul', 'LaporDong - Dashboard Pemerintah'); ?>

<?php $__env->startSection('konten'); ?>
<div class="dashboard-wrapper">
    <div class="ld-container">

        
        <div class="header-container" data-animate="fadeUp">
            <div>
                <div class="header-subtitle">Dashboard Pemerintah</div>
                <h1 class="header-title">
                    Halo, <?php echo e(auth()->user()->nama_lengkap); ?>

                </h1>
            </div>

            <a href="<?php echo e(route('admin.laporan.daftar')); ?>" class="ld-btn ld-btn--primer ld-btn--lg">
                Kelola Laporan
            </a>
        </div>

        
        <div class="stats-grid" data-animate-grid>
            <?php
                $kartuStats = [
                    [
                        'angka' => $stats['total'], 
                        'label' => 'Total Laporan', 
                        'ikon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-file-earmark-fill" viewBox="0 0 16 16"><path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2z"/></svg>', 
                        'warna' => '#234A89'
                    ],
                    [
                        'angka' => $stats['menunggu'], 
                        'label' => 'Menunggu Verifikasi', 
                        'ikon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16"><path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/></svg>', 
                        'warna' => '#234A89'
                    ],
                    [
                        'angka' => $stats['diproses'], 
                        'label' => 'Sedang Diproses', 
                        'ikon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-wrench" viewBox="0 0 16 16"><path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/></svg>', 
                        'warna' => '#234A89'
                    ],
                    [
                        'angka' => $stats['selesai_bulan'], 
                        'label' => 'Laporan Selesai', 
                        'ikon' => '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16"><path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/></svg>', 
                        'warna' => '#234A89'
                    ],
                ];
            ?>

            <?php $__currentLoopData = $kartuStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="ld-card">
                <div class="ld-card__body stat-card-body">
                    
                    <div class="stat-icon" style="color: <?php echo e($stat['warna']); ?>;">
                        <?php echo $stat['ikon']; ?>

                    </div>
                    <div>
                        <div class="stat-number" style="color: <?php echo e($stat['warna']); ?>;">
                            <?php echo e(number_format($stat['angka'])); ?>

                        </div>
                        <div class="stat-label">
                            <?php echo e($stat['label']); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="main-grid">

            
            <div class="ld-card" data-animate="fadeUp" data-delay="0.2">
                <div class="ld-card__header">
                    <h2 class="list-header-title">Laporan Perlu Tindakan</h2>
                    <a href="<?php echo e(route('admin.laporan.daftar', ['status'=>'dikirim'])); ?>" class="list-header-link">
                        Lihat semua
                    </a>
                </div>

                <div class="list-body-container">
                    <?php $__empty_1 = true; $__currentLoopData = $laporanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('laporan.detail', $laporan)); ?>" class="laporan-item">

                        <div class="laporan-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#234A89" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
                        </div>

                        <div class="laporan-text-container">
                            <div class="laporan-title">
                                <?php echo e($laporan->judul); ?>

                            </div>
                            <div class="laporan-subtitle">
                                <?php echo e($laporan->kota); ?> · <?php echo e($laporan->created_at->diffForHumans()); ?>

                            </div>
                        </div>

                        <div class="laporan-badge-container">
                            <span class="ld-badge ld-badge--<?php echo e($laporan->status); ?>">
                                <?php echo e($laporan->label_status); ?>

                            </span>
                        </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty-state">
                        <p class="empty-title">Semua aman!</p>
                        <p class="empty-subtitle">Belum ada laporan yang perlu ditindaklanjuti.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="right-panel">

                
                <div class="ld-card" data-animate="fadeRight" data-delay="0.15">
                    <div class="ld-card__header">
                        <h2 class="quick-action-title">Aksi Cepat</h2>
                    </div>

                    <div class="ld-card__body quick-action-body">
                        <a href="<?php echo e(route('admin.laporan.daftar',['status'=>'dikirim'])); ?>" class="ld-btn ld-btn--ghost quick-action-btn">
                            Verifikasi Laporan
                        </a>

                        <a href="<?php echo e(route('admin.laporan.daftar',['status'=>'diproses'])); ?>" class="ld-btn ld-btn--ghost quick-action-btn">
                            Proses & Selesaikan Laporan
                        </a>

                        <a href="<?php echo e(route('admin.laporan.daftar',['status'=>'selesai'])); ?>" class="ld-btn ld-btn--ghost quick-action-btn">
                            Lihat Laporan Selesai
                        </a>
                    </div>
                </div>

                
                <div class="ld-card" data-animate="fadeRight" data-delay="0.25">
                    <div class="ld-card__body info-card-body">
                        <div class="info-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#234A89" class="bi bi-patch-check-fill" viewBox="0 0 16 16">  <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708"/></svg>
                        </div>
                        <p class="info-text">
                            Pantau dan kelola laporan masyarakat secara efisien.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/admin/dasbor.blade.php ENDPATH**/ ?>