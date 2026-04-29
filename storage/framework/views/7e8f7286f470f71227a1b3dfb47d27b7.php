<?php $__env->startSection('judul', 'LaporDong - Kelola Laporan'); ?>

<?php $__env->startSection('konten'); ?>

<div class="ld-manage-wrapper">
    <div class="ld-container">

        
        <div class="ld-back-wrapper" data-animate="fadeUp">
            <a href="<?php echo e(route('admin.dasbor')); ?>" class="ld-btn ld-btn--ghost ld-btn--back ld-btn-back-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Kembali
            </a> 
        </div>

        
        <div class="ld-header-flex" data-animate="fadeUp">
            <div class="ld-header-title-box">
                <div>
                    <h1 class="ld-page-title">Kelola Laporan</h1>
                    <div class="ld-page-subtitle">
                        Total <?php echo e($laporan->total()); ?> laporan
                    </div>
                </div>
            </div>
        </div>

        
        <div class="ld-card" style="margin-bottom:1rem;" data-animate="fadeUp">
            <div class="ld-card__body">
                <form method="GET" action="<?php echo e(route('admin.laporan.daftar')); ?>" class="ld-filter-form">
                    <input type="text" name="cari" value="<?php echo e(request('cari')); ?>"
                        placeholder="Cari laporan..."
                        class="ld-input ld-filter-input-search">

                    <select name="prioritas" class="ld-input">
                        <option value="">Semua Prioritas</option>
                        <?php $__currentLoopData = ['tinggi','sedang','rendah']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p); ?>" <?php echo e(request('prioritas') === $p ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($p)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <button class="ld-btn ld-btn--primer">Cari</button>

                    <?php if(request()->hasAny(['cari','prioritas'])): ?>
                        <a href="<?php echo e(route('admin.laporan.daftar')); ?>" class="ld-btn ld-btn--ghost">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        
        <div class="ld-tabs-container" data-animate="fadeUp">
            <?php
                $statusList = [
                    '' => 'Semua',
                    'dikirim' => 'Dikirim',
                    'diverifikasi' => 'Verifikasi',
                    'diproses' => 'Diproses',
                    'selesai' => 'Selesai'
                ];
            ?>

            <?php $__currentLoopData = $statusList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('admin.laporan.daftar', array_merge(request()->all(), ['status' => $key]))); ?>"
                   class="ld-btn <?php echo e(request('status') == $key ? 'ld-btn--primer' : 'ld-btn--ghost'); ?>">
                    <?php echo e($label); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="ld-card" data-animate="fadeUp">
            <div class="ld-card__header">
                <h2 style="font-weight:700;">Daftar Laporan</h2>
            </div>

            <div>
                <?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="ld-report-item">

                    
                    <div class="ld-report-img-container">
                        <?php if($item->foto_sebelum): ?>
                            <img src="<?php echo e(Storage::url(is_array($item->foto_sebelum) ? $item->foto_sebelum[0] : $item->foto_sebelum)); ?>">
                        <?php else: ?>
                            <div class="ld-report-img-placeholder">🛣️</div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="ld-report-content">
                        <div class="ld-report-title">
                            <?php echo e($item->judul); ?>

                        </div>
                        <div class="ld-report-meta">
                            <?php echo e($item->kota); ?> · <?php echo e($item->created_at->diffForHumans()); ?>

                        </div>
                        <div class="ld-report-code">
                            <?php echo e($item->kode_laporan); ?>

                        </div>
                        <span class="ld-badge ld-badge--outline">
                            <?php echo e(ucfirst($item->prioritas)); ?>

                        </span>
                    </div>

                    
                    <span class="ld-badge ld-badge--<?php echo e($item->status); ?>">
                        <?php echo e($item->label_status); ?>

                    </span>

                    
                    <div class="ld-action-group">
                        <a href="<?php echo e(route('laporan.detail', $item)); ?>"
                           class="ld-btn ld-btn--ghost ld-btn--sm">
                            Detail
                        </a>

                        <?php if($item->status === 'dikirim'): ?>
                            <form method="POST" action="<?php echo e(route('admin.laporan.verifikasi', $item)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="aksi" value="verifikasi">
                                <button class="ld-btn ld-btn--primer ld-btn--sm">Terima</button>
                            </form>

                            <form method="POST" action="<?php echo e(route('admin.laporan.verifikasi', $item)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="aksi" value="tolak">
                                <button class="ld-btn ld-btn--danger ld-btn--sm">Tolak</button>
                            </form>
                        <?php endif; ?>

                        <?php if($item->status === 'diverifikasi'): ?>
                            <form method="POST" action="<?php echo e(route('admin.laporan.proses', $item)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button class="ld-btn ld-btn--primer ld-btn--sm">Proses</button>
                            </form>
                        <?php endif; ?>

                        <?php if($item->status === 'diproses'): ?>
                            <button onclick="bukaModal(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->judul)); ?>')"
                                class="ld-btn ld-btn--primer ld-btn--sm">
                                Selesai
                            </button>
                        <?php endif; ?>
                    </div>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="ld-empty-state">
                    Tidak ada laporan
                </div>
                <?php endif; ?>
            </div>

            
            <?php if($laporan->hasPages()): ?>
                <div class="ld-pagination-wrapper">
                    <?php echo e($laporan->withQueryString()->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="ld-modal-overlay" id="modalSelesai">
    <div class="ld-modal-card">
        <h3 class="ld-modal-title">Selesaikan Laporan</h3>
        
        <form id="formSelesai" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <input type="hidden" name="id" id="laporan_id">

            <div style="margin-bottom:1rem;">
                <label style="font-size:0.8rem; font-weight: 600; display: block; margin-bottom: 0.5rem;">Upload Bukti Foto Perbaikan</label>
                <input type="file" name="foto_sesudah[]" multiple class="ld-input" required>
            </div>

            <div style="font-size:0.7rem; color:var(--ld-text-muted); margin-bottom:1.5rem;">
                * Maksimal 5 foto
            </div>

            <div class="ld-modal-footer">
                <button type="button" onclick="tutupModal()" class="ld-btn ld-btn--ghost">
                    Batal
                </button>
                <button type="submit" class="ld-btn ld-btn--primer">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/admin/daftar-laporan.blade.php ENDPATH**/ ?>