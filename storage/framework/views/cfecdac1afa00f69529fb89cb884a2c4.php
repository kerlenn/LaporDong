<?php $__env->startSection('judul', 'Dashboard Admin'); ?>

<?php $__env->startSection('konten'); ?>
<section class="py-8 px-4 min-h-screen" style="background: var(--warna-latar);">
    <div class="max-w-7xl mx-auto">

        
        <div class="mb-8" data-animate="fadeUp">
            <h1 class="text-3xl font-bold" style="color: var(--warna-indigo); font-family: var(--font-display);">
                Dashboard Admin
            </h1>
            <p style="color: var(--warna-teks-muted);">
                Selamat datang, <strong><?php echo e(auth()->user()->nama); ?></strong> —
                <?php echo e(now()->isoFormat('dddd, D MMMM Y')); ?>

            </p>
        </div>

        
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8" data-animate-grid>
            <?php
                $kartuStats = [
                    ['angka' => $stats['total'],         'label' => 'Total Laporan',  'icon' => '📋', 'warna' => 'var(--warna-indigo)'],
                    ['angka' => $stats['menunggu'],      'label' => 'Menunggu Verifikasi','icon' => '⏳', 'warna' => '#F59E0B'],
                    ['angka' => $stats['diproses'],      'label' => 'Sedang Diproses','icon' => '🔧', 'warna' => '#3B82F6'],
                    ['angka' => $stats['selesai_bulan'], 'label' => 'Selesai Bulan Ini','icon' => '✅', 'warna' => '#10B981'],
                    ['angka' => $stats['petugas_aktif'], 'label' => 'Petugas Aktif',  'icon' => '👷', 'warna' => 'var(--warna-cobalt)'],
                ];
            ?>
            <?php $__currentLoopData = $kartuStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kartu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="ld-card p-5"
                    style="border-top: 3px solid <?php echo e($kartu['warna']); ?>;">
                    <div class="text-3xl mb-3"><?php echo e($kartu['icon']); ?></div>
                    <div class="text-3xl font-bold mb-1"
                        style="color: <?php echo e($kartu['warna']); ?>; font-family: var(--font-display);"
                        data-count="<?php echo e($kartu['angka']); ?>"><?php echo e($kartu['angka']); ?></div>
                    <div class="text-sm" style="color: var(--warna-teks-muted);"><?php echo e($kartu['label']); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="grid lg:grid-cols-3 gap-6 mb-8">

            
            <div class="lg:col-span-2 ld-card" data-animate="fadeLeft">
                <div class="p-5 border-b flex items-center justify-between"
                    style="border-color: var(--warna-icy);">
                    <h2 class="text-lg font-bold" style="color: var(--warna-indigo);">
                        ⚡ Laporan Perlu Tindakan
                    </h2>
                    <a href="<?php echo e(route('admin.laporan.daftar', ['status' => 'dikirim'])); ?>"
                        class="ld-btn-ghost ld-btn-sm">Lihat Semua</a>
                </div>
                <div class="divide-y" style="--tw-divide-opacity: 1;">
                    <?php $__empty_1 = true; $__currentLoopData = $laporanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-4 hover:bg-blue-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <?php if($laporan->foto_sebelum): ?>
                                    <img src="<?php echo e(Storage::url(is_array($laporan->foto_sebelum) ? $laporan->foto_sebelum[0] : $laporan->foto_sebelum)); ?>"
                                        alt="Foto" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                <?php else: ?>
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center text-xl flex-shrink-0"
                                        style="background: var(--warna-icy);">🛣️</div>
                                <?php endif; ?>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span class="text-xs font-mono" style="color: var(--warna-cobalt);">
                                            <?php echo e($laporan->kode_laporan); ?>

                                        </span>
                                        <span class="ld-badge ld-badge-<?php echo e($laporan->status); ?>">
                                            <?php echo e($laporan->label_status); ?>

                                        </span>
                                        <?php if($laporan->prioritas_ai): ?>
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded"
                                                style="background: <?php echo e($laporan->warna_prioritas); ?>20; color: <?php echo e($laporan->warna_prioritas); ?>;">
                                                <?php echo e($laporan->label_prioritas); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="font-medium text-sm truncate" style="color: var(--warna-teks);">
                                        <?php echo e($laporan->judul); ?>

                                    </p>
                                    <p class="text-xs" style="color: var(--warna-teks-muted);">
                                        <?php echo e($laporan->kota); ?> · <?php echo e($laporan->pelapor->nama); ?> · <?php echo e($laporan->created_at->diffForHumans()); ?>

                                    </p>
                                </div>
                                <a href="<?php echo e(route('laporan.detail', $laporan)); ?>"
                                    class="ld-btn-outline ld-btn-sm flex-shrink-0">Tinjau</a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-10 text-center">
                            <div class="text-4xl mb-2">🎉</div>
                            <p style="color: var(--warna-teks-muted);">Semua laporan sudah ditangani!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="space-y-6">

                
                <div class="ld-card p-5" data-animate="fadeRight">
                    <h3 class="font-bold mb-4" style="color: var(--warna-indigo);">
                        👷 Petugas Aktif
                    </h3>
                    <?php $__empty_1 = true; $__currentLoopData = $petugasAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $petugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center gap-3 py-2.5 border-b"
                            style="border-color: var(--warna-icy);">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm text-white"
                                style="background: var(--warna-cobalt);">
                                <?php echo e(strtoupper(substr($petugas->nama, 0, 1))); ?>

                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-sm truncate" style="color: var(--warna-teks);">
                                    <?php echo e($petugas->nama); ?>

                                </p>
                                <p class="text-xs" style="color: var(--warna-teks-muted);">
                                    <?php echo e($petugas->tugasSaya()->where('status', 'diproses')->count()); ?> tugas aktif
                                </p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-center py-3" style="color: var(--warna-teks-muted);">
                            Tidak ada petugas
                        </p>
                    <?php endif; ?>
                </div>

                
                <div class="ld-card p-5" data-animate="fadeRight">
                    <h3 class="font-bold mb-4" style="color: var(--warna-indigo);">
                        ⚡ Aksi Cepat
                    </h3>
                    <div class="space-y-2">
                        <a href="<?php echo e(route('admin.laporan.daftar', ['status' => 'dikirim'])); ?>"
                            class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors"
                            style="border: 1px solid var(--warna-icy);">
                            <span class="text-xl">📨</span>
                            <span class="text-sm font-medium" style="color: var(--warna-teks);">
                                Verifikasi Laporan Baru
                            </span>
                            <?php if($stats['menunggu'] > 0): ?>
                                <span class="ml-auto text-xs font-bold px-2 py-0.5 rounded-full text-white"
                                    style="background: #EF4444;"><?php echo e($stats['menunggu']); ?></span>
                            <?php endif; ?>
                        </a>
                        <a href="<?php echo e(route('admin.laporan.daftar', ['status' => 'diverifikasi'])); ?>"
                            class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors"
                            style="border: 1px solid var(--warna-icy);">
                            <span class="text-xl">👷</span>
                            <span class="text-sm font-medium" style="color: var(--warna-teks);">
                                Tugaskan Petugas
                            </span>
                        </a>
                        <a href="<?php echo e(route('statistik')); ?>"
                            class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors"
                            style="border: 1px solid var(--warna-icy);">
                            <span class="text-xl">📊</span>
                            <span class="text-sm font-medium" style="color: var(--warna-teks);">
                                Lihat Statistik Publik
                            </span>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/admin/dasbor.blade.php ENDPATH**/ ?>