<?php $__env->startSection('judul', 'LaporDong - Eksplorasi Laporan'); ?>

<?php $__env->startSection('konten'); ?>

<div class="ld-page-wrapper">
    <div class="ld-container ld-container-wide">

        
        <div class="ld-hero-wrapper">
            <h1 class="ld-hero__judul">
                <span class="aksen">Eksplorasi Laporan</span>
            </h1>
            <p class="ld-hero__desc ld-hero__desc-custom">
                Pantau kerusakan jalan di seluruh Indonesia, beri ulasan, dan nilai kinerja pemerintah.
            </p>

            
            <form method="GET" action="<?php echo e(route('eksplorasi')); ?>" class="ld-search" style="margin-top: 2rem;">
                <div class="ld-search__wrapper">
                    <input 
                        type="text" 
                        name="cari" 
                        value="<?php echo e(request('cari')); ?>"
                        placeholder="Cari nama jalan, kota, atau daerah..."
                        class="ld-search__input"
                    >
                    <button type="submit" class="ld-btn ld-btn--primer">Cari</button>
                </div>
            </form>
        </div>

        
        <div class="ld-eksplorasi__grid" style="margin-top: 0;">

            
            <aside class="ld-filter">
                <form method="GET" action="<?php echo e(route('eksplorasi')); ?>" id="filterForm" class="ld-filter__card">

                    <?php if(request('cari')): ?>
                        <input type="hidden" name="cari" value="<?php echo e(request('cari')); ?>">
                    <?php endif; ?>

                    <h3 class="ld-filter__title">Filter</h3>

                    <div class="ld-filter__group">
                        <label>Provinsi</label>
                        <select name="provinsi" onchange="this.form.submit()" class="ld-input">
                            <option value="">Semua Provinsi</option>
                            <?php $__currentLoopData = $daftarProvinsi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($prov); ?>" <?php echo e(request('provinsi') === $prov ? 'selected' : ''); ?>><?php echo e($prov); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="ld-filter__group">
                        <label>Kota / Kabupaten</label>
                        <select name="kota" onchange="this.form.submit()" class="ld-input">
                            <option value="">Semua Kota</option>
                            <?php $__currentLoopData = $daftarKota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($kota); ?>" <?php echo e(request('kota') === $kota ? 'selected' : ''); ?>><?php echo e($kota); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="ld-filter__group">
                        <label>Status</label>
                        <?php
                            $statusList = [
                                '' => 'Semua Status',
                                'dikirim' => 'Dikirim',
                                'diverifikasi' => 'Diverifikasi',
                                'diproses' => 'Diproses',
                                'selesai' => 'Selesai',
                            ];
                        ?>
                        <?php $__currentLoopData = $statusList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="ld-radio">
                                <input type="radio" name="status" value="<?php echo e($val); ?>"
                                    <?php echo e(request('status','') === $val ? 'checked' : ''); ?>

                                    onchange="this.form.submit()">
                                <span><?php echo e($label); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="ld-filter__group">
                        <label>Urutkan</label>
                        <select name="sort" onchange="this.form.submit()" class="ld-input">
                            <option value="terbaru" <?php echo e(request('sort','terbaru') === 'terbaru' ? 'selected' : ''); ?>>Terbaru</option>
                            <option value="tertua" <?php echo e(request('sort') === 'tertua' ? 'selected' : ''); ?>>Terlama</option>
                            <option value="bintang" <?php echo e(request('sort') === 'bintang' ? 'selected' : ''); ?>>Rating Tertinggi</option>
                        </select>
                    </div>

                    <?php if(request()->hasAny(['kota','provinsi','status','cari','sort'])): ?>
                        <div style="margin-top: 1.5rem;">
                            <a href="<?php echo e(route('eksplorasi')); ?>" class="ld-btn ld-btn--ghost" style="width: 100%; text-align: center;">Reset Filter</a>
                        </div>
                    <?php endif; ?>
                </form>
            </aside>

            
            <main class="ld-feed">

                <div class="ld-feed__info">
                    Menampilkan <strong><?php echo e($laporan->total()); ?></strong> laporan
                </div>

                <?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $statusColor = match($item->status) {
                        'dikirim'     => 'ld-badge--dikirim',
                        'diverifikasi'=> 'ld-badge--diverifikasi',
                        'diproses'    => 'ld-badge--diproses',
                        'selesai'     => 'ld-badge--selesai',
                        'ditolak'     => 'ld-badge--ditolak',
                        default       => '',
                    };
                    $prioritasColor = match($item->prioritas_ai) {
                        'tinggi' => 'ld-priority--high',
                        'sedang' => 'ld-priority--medium',
                        'rendah' => 'ld-priority--low',
                        default  => '',
                    };
                    $foto = is_array($item->foto_sebelum) ? ($item->foto_sebelum[0] ?? null) : $item->foto_sebelum;
                ?>

                <article class="ld-card-eksplorasi">

                    
                    <div class="ld-card__head">
                        <div class="ld-card__media">
                            <?php if($foto): ?>
                                <img src="<?php echo e(asset('storage/' . $foto)); ?>" class="ld-card__img" alt="Foto laporan">
                            <?php else: ?>
                                <div class="ld-card__img ld-card__img--placeholder">
                                    <span>🛣️</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="ld-card__content">
                            <div class="ld-card__top">
                                <div class="ld-card__badges">
                                    <span class="ld-badge <?php echo e($statusColor); ?>"><?php echo e($item->label_status); ?></span>
                                    <?php if($item->prioritas_ai): ?>
                                        <span class="ld-priority <?php echo e($prioritasColor); ?>"><?php echo e($item->label_prioritas); ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="ld-time"><?php echo e($item->created_at->diffForHumans()); ?></span>
                            </div>
                            <h3 class="ld-card__title"><?php echo e($item->judul); ?></h3>
                            <p class="ld-location"><?php echo e($item->kecamatan); ?>, <?php echo e($item->kota); ?>, <?php echo e($item->provinsi); ?></p>
                        </div>
                    </div>

                    
                    <p class="ld-card__desc"><?php echo e(Str::limit($item->deskripsi, 150)); ?></p>
                    

                    <div class="ld-divider"></div>

                    
                    <div class="ld-card__footer">
                        <div class="ld-user">
                            <div class="ld-user__avatar">
                                <?php echo e(strtoupper(substr($item->pelapor?->nama_lengkap ?? 'U', 0, 1))); ?>

                            </div>
                            <span class="ld-user__name"><?php echo e($item->pelapor?->nama_lengkap); ?></span>
                        </div>

                        <div class="ld-rating-display">
                            <?php if($item->ulasan?->bintang): ?>
                                <div class="ld-stars">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="ld-star <?php echo e($item->ulasan->bintang >= $i ? 'is-active' : ''); ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                                <span class="ld-rating__value"><?php echo e($item->ulasan->bintang); ?>/5</span>
                            <?php else: ?>
                                <span class="ld-rating__empty">Belum ada ulasan</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="ld-divider"></div>

                    
                    <div class="ld-card__action">

                        <a href="<?php echo e(route('laporan.detail', $item->id)); ?>" class="ld-btn ld-btn--primer">
                            Lihat Detail
                        </a>

                        <?php if(auth()->guard()->guest()): ?>
                            
                            <?php if($item->status === 'selesai'): ?>
                                <div class="ld-gate">
                                    <span class="ld-gate__text">Mau kasih ulasan atau rating?</span>
                                    <a href="<?php echo e(route('masuk')); ?>" class="ld-gate__link">Masuk dulu</a>
                                </div>
                            <?php else: ?>
                                <div class="ld-gate">
                                    <span class="ld-gate__text">
                                        Laporan sedang <strong><?php echo e($item->label_status); ?></strong>. Ulasan bisa diberikan setelah status <strong>Selesai</strong>.
                                    </span>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if(auth()->guard()->check()): ?>
                            
                            <?php if($item->status === 'selesai'): ?>
                                <div class="ld-comment-form__label">Beri ulasanmu</div>
                                
                                
                                <?php if($errors->any()): ?>
                                    <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 0.9rem;">
                                        Gagal mengirim ulasan. Pastikan bintang dan komentar sudah diisi!
                                    </div>
                                <?php endif; ?>

                                <form method="POST" action="<?php echo e(route('eksplorasi.ulasan', $item->id)); ?>" class="ld-comment-form">
                                    <?php echo csrf_field(); ?>
                                    <div class="ld-stars-input" data-form="<?php echo e($item->id); ?>" style="display: flex; gap: 4px; margin-bottom: 5px;">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <span class="ld-star-input" data-value="<?php echo e($i); ?>" style="cursor: pointer; font-size: 24px; color: #E2E8F0;">★</span>
                                        <?php endfor; ?>
                                        <input type="hidden" name="bintang" required>
                                    </div>
                                    <?php $__errorArgs = ['bintang'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div style="color: red; font-size: 0.85rem; margin-bottom: 10px;"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                    <textarea name="komentar" placeholder="Tulis pengalamanmu tentang perbaikan jalan ini..." rows="2" class="ld-textarea" style="min-height: 80px;"></textarea>
                                    <?php $__errorArgs = ['komentar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div style="color: red; font-size: 0.85rem; margin-top: 5px;"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                    <div class="ld-comment-form__row" style="justify-content: flex-end; margin-top: 10px;">
                                        <button type="submit" class="ld-btn ld-btn--primer">
                                            Kirim
                                        </button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <div class="ld-gate">
                                    <span class="ld-gate__text">
                                        Laporan sedang <strong><?php echo e($item->label_status); ?></strong>. Ulasan bisa diberikan setelah status <strong>Selesai</strong>.
                                    </span>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        
                        <?php if($item->ulasanList && $item->ulasanList->count() > 0): ?>
                            <div style="margin-top: 15px; text-align: center;">
                                
                                <button type="button" onclick="toggleUlasan('komentar-<?php echo e($item->id); ?>', this)" class="ld-btn ld-btn--ghost" style="width: 100%; border: 1px dashed #cbd5e1;">
                                    Lihat <?php echo e($item->ulasanList->count()); ?> Ulasan ▼
                                </button>
                            </div>

                            
                            <div id="komentar-<?php echo e($item->id); ?>" class="ld-comments" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                                <?php $__currentLoopData = $item->ulasanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ulasan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="ld-comment">
                                        <div class="ld-comment__avatar">
                                            <?php echo e(strtoupper(substr($ulasan->user?->nama_lengkap ?? 'U', 0, 1))); ?>

                                        </div>

                                        <div class="ld-comment__body">
                                            <div class="ld-comment__header">
                                                <span class="ld-comment__who">
                                                    
                                                    <?php echo e($ulasan->user?->nama_lengkap); ?>

                                                </span>

                                                <div class="ld-comment__stars">
                                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                                        <span class="<?php echo e($ulasan->bintang >= $i ? 'on' : 'off'); ?>">★</span>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>

                                            <p class="ld-comment__text"><?php echo e($ulasan->komentar); ?></p>

                                            <span class="ld-comment__time">
                                                <?php echo e($ulasan->created_at->diffForHumans()); ?>

                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                    </div>

                </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="ld-empty">
                    <p>Tidak ada laporan ditemukan.</p>
                </div>
                <?php endif; ?>

                <?php if($laporan->hasPages()): ?>
                    <div class="ld-pagination-wrapper">
                        <?php echo e($laporan->links()); ?>

                    </div>
                <?php endif; ?>

            </main>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/eksplorasi/index.blade.php ENDPATH**/ ?>