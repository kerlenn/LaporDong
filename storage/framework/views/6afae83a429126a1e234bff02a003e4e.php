<?php $__env->startSection('judul', 'Laporan Saya'); ?>

<?php $__env->startSection('konten'); ?>
<section class="py-10 px-4 min-h-screen" style="background: var(--warna-latar);">
    <div class="max-w-5xl mx-auto">

        
        <div class="mb-8" data-animate="fadeUp">
            <h1 class="text-3xl font-bold" style="color: var(--warna-indigo); font-family: var(--font-display);">
                Laporan Saya
            </h1>
            <p class="mt-1" style="color: var(--warna-teks-muted);">
                Pantau semua laporan kerusakan yang pernah kamu kirimkan
            </p>
        </div>

        
        <div class="ld-card mb-6 p-4" data-animate="fadeUp">
            <form method="GET" action="<?php echo e(route('laporan.daftar-saya')); ?>" class="flex flex-wrap gap-3 items-center">
                <select name="status" class="ld-input" style="width: auto; min-width: 160px;">
                    <option value="">Semua Status</option>
                    <?php $__currentLoopData = ['dikirim','diverifikasi','diproses','selesai','ditolak']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst($s)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <input type="text" name="cari" value="<?php echo e(request('cari')); ?>" placeholder="Cari judul atau kode..."
                    class="ld-input flex-1" style="min-width: 200px;">
                <button type="submit" class="ld-btn-primer ld-btn-sm">Filter</button>
                <?php if(request()->hasAny(['status','cari'])): ?>
                    <a href="<?php echo e(route('laporan.daftar-saya')); ?>" class="ld-btn-ghost ld-btn-sm">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        
        <?php if($laporan->isEmpty()): ?>
            <div class="ld-card p-16 text-center" data-animate="fadeUp">
                <div class="text-6xl mb-4">📋</div>
                <h3 class="text-xl font-semibold mb-2" style="color: var(--warna-indigo);">Belum Ada Laporan</h3>
                <p style="color: var(--warna-teks-muted);" class="mb-6">
                    Kamu belum pernah mengirimkan laporan kerusakan jalan.
                </p>
                <a href="<?php echo e(route('laporan.buat')); ?>" class="ld-btn-primer">
                    + Buat Laporan Pertama
                </a>
            </div>
        <?php else: ?>
            <div class="space-y-4" data-animate-grid>
                <?php $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="ld-card p-5 hover:shadow-lg transition-all duration-300" style="border-left: 4px solid var(--warna-cobalt);">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">

                            
                            <?php if($item->foto_sebelum): ?>
                                <div class="flex-shrink-0">
                                    <img src="<?php echo e(Storage::url(is_array($item->foto_sebelum) ? $item->foto_sebelum[0] : $item->foto_sebelum)); ?>"
                                        alt="Foto kerusakan"
                                        class="w-20 h-20 object-cover rounded-xl"
                                        style="border: 2px solid var(--warna-icy);">
                                </div>
                            <?php else: ?>
                                <div class="flex-shrink-0 w-20 h-20 rounded-xl flex items-center justify-center text-3xl"
                                    style="background: var(--warna-icy);">🛣️</div>
                            <?php endif; ?>

                            
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap gap-2 items-center mb-1">
                                    <span class="text-xs font-mono px-2 py-0.5 rounded"
                                        style="background: var(--warna-icy); color: var(--warna-cobalt);">
                                        <?php echo e($item->kode_laporan); ?>

                                    </span>
                                    <span class="ld-badge ld-badge-<?php echo e($item->status); ?>">
                                        <?php echo e($item->label_status); ?>

                                    </span>
                                    <?php if($item->prioritas_ai): ?>
                                        <span class="ld-badge"
                                            style="background: <?php echo e($item->warna_prioritas); ?>20; color: <?php echo e($item->warna_prioritas); ?>; border: 1px solid <?php echo e($item->warna_prioritas); ?>40;">
                                            <?php echo e($item->label_prioritas); ?> Priority
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="font-semibold text-lg truncate" style="color: var(--warna-indigo);">
                                    <?php echo e($item->judul); ?>

                                </h3>
                                <p class="text-sm mt-0.5" style="color: var(--warna-teks-muted);">
                                    📍 <?php echo e($item->kota); ?>, <?php echo e($item->provinsi); ?>

                                    &nbsp;·&nbsp;
                                    🕐 <?php echo e($item->created_at->diffForHumans()); ?>

                                </p>
                            </div>

                            
                            <div class="flex flex-col gap-2 flex-shrink-0">
                                <a href="<?php echo e(route('laporan.detail', $item)); ?>" class="ld-btn-primer ld-btn-sm text-center">
                                    Lihat Detail
                                </a>
                                <?php if($item->status === 'selesai' && !$item->ulasan): ?>
                                    <a href="<?php echo e(route('laporan.ulasan.form', $item)); ?>" class="ld-btn-outline ld-btn-sm text-center">
                                        ⭐ Beri Ulasan
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <?php
                            $steps = ['dikirim','diverifikasi','diproses','selesai'];
                            $currentStep = array_search($item->status, $steps);
                            $progress = $item->status === 'ditolak' ? 0 : (($currentStep + 1) / count($steps)) * 100;
                        ?>
                        <?php if($item->status !== 'ditolak'): ?>
                            <div class="mt-3">
                                <div class="h-1.5 rounded-full" style="background: var(--warna-icy);">
                                    <div class="h-1.5 rounded-full transition-all duration-700"
                                        style="width: <?php echo e($progress); ?>%; background: linear-gradient(90deg, var(--warna-indigo), var(--warna-cobalt));">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="mt-8">
                <?php echo e($laporan->withQueryString()->links()); ?>

            </div>
        <?php endif; ?>

    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/laporan/daftar-saya.blade.php ENDPATH**/ ?>