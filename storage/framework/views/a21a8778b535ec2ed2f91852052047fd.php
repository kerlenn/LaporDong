<?php $__env->startSection('judul', 'Dasbor — LaporDong'); ?>

<?php $__env->startSection('konten'); ?>
<div style="padding-top: 6rem; padding-bottom: 4rem; background: var(--ld-bg-soft); min-height: 100vh;">
    <div class="ld-container">

        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;" data-animate="fadeUp">
            <div>
                <div style="font-size: 0.875rem; color: var(--ld-text-muted); margin-bottom: 0.25rem;">Selamat datang,</div>
                <h1 style="font-family: var(--ld-font-display); font-size: 1.75rem; font-weight: 800; color: var(--ld-text); letter-spacing: -0.02em;"><?php echo e($pengguna->nama_lengkap); ?> 👋</h1>
                <div style="display: flex; align-items: center; gap: 0.625rem; margin-top: 0.5rem;">
                    <span style="font-size: 0.8rem; font-weight: 600; background: var(--ld-grad-light); color: var(--ld-cobalt); padding: 0.25rem 0.75rem; border-radius: 100px; border: 1px solid var(--ld-icy);">
                        <?php echo e($pengguna->level); ?>

                    </span>
                    <span style="font-size: 0.8125rem; color: var(--ld-text-muted);"><?php echo e(number_format($pengguna->total_poin)); ?> poin</span>
                </div>
            </div>
            <a href="<?php echo e(route('laporan.buat')); ?>" class="ld-btn ld-btn--primer ld-btn--lg">
                📷 Buat Laporan Baru
            </a>
        </div>

        
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;" data-animate-grid>
            <?php
            $kartaStat = [
                ['angka' => $ringkasan['total'],    'label' => 'Total Laporan', 'ikon' => '📊', 'warna' => 'var(--ld-cobalt)'],
                ['angka' => $ringkasan['diproses'],  'label' => 'Sedang Diproses', 'ikon' => '🔧', 'warna' => '#D97706'],
                ['angka' => $ringkasan['selesai'],   'label' => 'Selesai', 'ikon' => '✅', 'warna' => '#16A34A'],
                ['angka' => $pengguna->total_poin,   'label' => 'Total Poin', 'ikon' => '⭐', 'warna' => 'var(--ld-indigo)'],
            ];
            ?>

            <?php $__currentLoopData = $kartaStat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="ld-card">
                <div class="ld-card__body" style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; background: var(--ld-grad-light); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.375rem; flex-shrink: 0;">
                        <?php echo e($stat['ikon']); ?>

                    </div>
                    <div>
                        <div style="font-family: var(--ld-font-display); font-size: 1.625rem; font-weight: 800; color: <?php echo e($stat['warna']); ?>; line-height: 1;">
                            <?php echo e(number_format($stat['angka'])); ?>

                        </div>
                        <div style="font-size: 0.7875rem; color: var(--ld-text-muted); margin-top: 2px;"><?php echo e($stat['label']); ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">

            
            <div class="ld-card" data-animate="fadeUp" data-delay="0.2">
                <div class="ld-card__header">
                    <h2 style="font-family: var(--ld-font-display); font-size: 1rem; font-weight: 700;">Laporan Terkini</h2>
                    <a href="<?php echo e(route('laporan.daftar-saya')); ?>" style="font-size: 0.8125rem; color: var(--ld-cobalt); text-decoration: none; font-weight: 500;">Lihat semua →</a>
                </div>

                <div style="overflow: hidden;">
                    <?php $__empty_1 = true; $__currentLoopData = $laporanTerkini; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('laporan.detail', $laporan->kode_laporan)); ?>" style="display: flex; gap: 1rem; padding: 1rem 1.5rem; border-bottom: 1px solid var(--ld-border); text-decoration: none; transition: background 0.15s;" onmouseover="this.style.background='var(--ld-bg-soft)'" onmouseout="this.style.background=''">
                        <div style="width: 44px; height: 44px; background: var(--ld-grad-light); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;">
                            <?php if($laporan->status === 'selesai'): ?> ✅
                            <?php elseif($laporan->status === 'diproses'): ?> 🔧
                            <?php elseif($laporan->status === 'diverifikasi'): ?> ✔️
                            <?php elseif($laporan->status === 'ditolak'): ?> ❌
                            <?php else: ?> 📤
                            <?php endif; ?>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 0.875rem; font-weight: 600; color: var(--ld-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($laporan->judul); ?></div>
                            <div style="font-size: 0.775rem; color: var(--ld-text-muted); margin-top: 2px;">
                                <?php echo e($laporan->kecamatan); ?>, <?php echo e($laporan->kota); ?> · <?php echo e($laporan->created_at->diffForHumans()); ?>

                            </div>
                        </div>
                        <div style="flex-shrink: 0;">
                            <span class="ld-badge ld-badge--<?php echo e($laporan->status); ?>"><?php echo e($laporan->label_status); ?></span>
                        </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div style="padding: 3rem; text-align: center; color: var(--ld-text-muted);">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                        <p style="font-weight: 600;">Belum ada laporan</p>
                        <p style="font-size: 0.875rem; margin-top: 0.25rem;">Mulai dengan membuat laporan pertama Anda!</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                
                <div class="ld-card" data-animate="fadeRight" data-delay="0.15">
                    <div class="ld-card__body" style="text-align: center; padding: 2rem 1.5rem;">
                        <img src="<?php echo e($pengguna->avatar_url); ?>" alt="Foto Profil"
                            style="width: 72px; height: 72px; border-radius: 50%; border: 3px solid var(--ld-icy); margin-bottom: 1rem; object-fit: cover;">
                        <div style="font-weight: 700; font-size: 1rem; color: var(--ld-text);"><?php echo e($pengguna->nama_lengkap); ?></div>
                        <div style="font-size: 0.8125rem; color: var(--ld-text-muted); margin-top: 2px;"><?php echo e($pengguna->email); ?></div>

                        
                        <div style="margin-top: 1.25rem;">
                            <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--ld-text-muted); margin-bottom: 0.375rem;">
                                <span><?php echo e($pengguna->level); ?></span>
                                <span><?php echo e(number_format($pengguna->total_poin)); ?> poin</span>
                            </div>
                            <?php
                            $poinSelanjutnya = match(true) {
                                $pengguna->total_poin < 100  => 100,
                                $pengguna->total_poin < 500  => 500,
                                $pengguna->total_poin < 2000 => 2000,
                                $pengguna->total_poin < 5000 => 5000,
                                default                      => 5000,
                            };
                            $persen = min(100, round(($pengguna->total_poin / $poinSelanjutnya) * 100));
                            ?>
                            <div style="height: 8px; background: var(--ld-border); border-radius: 100px; overflow: hidden;">
                                <div style="height: 100%; width: <?php echo e($persen); ?>%; background: var(--ld-grad-primary); border-radius: 100px; transition: width 1s var(--ld-ease-spring);"></div>
                            </div>
                            <div style="font-size: 0.7rem; color: var(--ld-text-muted); margin-top: 0.375rem; text-align: right;">
                                Target: <?php echo e(number_format($poinSelanjutnya)); ?> poin
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="ld-card" data-animate="fadeRight" data-delay="0.25">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">🏅 Badge Saya</h2>
                        <a href="<?php echo e(route('dasbor.profil')); ?>" style="font-size: 0.8rem; color: var(--ld-cobalt); text-decoration: none;">Lihat semua</a>
                    </div>
                    <div class="ld-card__body">
                        <?php if($pengguna->badge->count() > 0): ?>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
                            <?php $__currentLoopData = $pengguna->badge->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="ld-badge-card">
                                <div class="ld-badge-card__ikon"><?php echo e($badge->ikon); ?></div>
                                <div class="ld-badge-card__nama"><?php echo e($badge->nama); ?></div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php else: ?>
                        <div style="text-align: center; padding: 1.5rem; color: var(--ld-text-muted);">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔒</div>
                            <p style="font-size: 0.8125rem;">Kirim laporan pertama untuk mendapat badge!</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/dashboard/warga.blade.php ENDPATH**/ ?>