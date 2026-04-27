<?php $__env->startSection('judul', 'Detail Laporan ' . $laporan->kode_laporan . ' — LaporDong'); ?>

<?php $__env->startSection('konten'); ?>
<div style="padding-top: 6rem; padding-bottom: 4rem; background: var(--ld-bg-soft); min-height: 100vh;">
    <div class="ld-container" style="max-width: 900px;">

        
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--ld-text-muted);" data-animate="fadeUp">
            <a href="<?php echo e(route('laporan.daftar-saya')); ?>" style="color: var(--ld-cobalt); text-decoration: none;">← Laporan Saya</a>
            <span>/</span>
            <span><?php echo e($laporan->kode_laporan); ?></span>
        </div>

        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;" data-animate="fadeUp">
            <div>
                <h1 style="font-family: var(--ld-font-display); font-size: 1.5rem; font-weight: 800; color: var(--ld-text); letter-spacing: -0.02em;"><?php echo e($laporan->judul); ?></h1>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 0.625rem; flex-wrap: wrap;">
                    <span style="font-size: 0.8rem; color: var(--ld-text-muted); font-family: monospace; background: var(--ld-bg-soft); padding: 0.25rem 0.5rem; border-radius: 6px; border: 1px solid var(--ld-border);"><?php echo e($laporan->kode_laporan); ?></span>
                    <span class="ld-badge ld-badge--<?php echo e($laporan->status); ?>"><?php echo e($laporan->label_status); ?></span>
                    <?php if($laporan->prioritas_ai): ?>
                        <span class="ld-badge ld-badge--prioritas-<?php echo e($laporan->prioritas_ai); ?>"><?php echo e($laporan->label_prioritas); ?></span>
                    <?php endif; ?>
                    <span style="font-size: 0.8rem; color: var(--ld-text-muted);"><?php echo e($laporan->created_at->diffForHumans()); ?></span>
                </div>
            </div>
            <?php if($laporan->bisaDiulas()): ?>
                <a href="<?php echo e(route('laporan.ulasan.form', $laporan->kode_laporan)); ?>" class="ld-btn ld-btn--primer ld-btn--sm">
                    ⭐ Beri Ulasan
                </a>
            <?php endif; ?>
        </div>

        
        <div class="ld-step-tracker" style="margin-bottom: 1.5rem;" data-animate="fadeUp" data-delay="0.1">
            <?php
            $tahapan = [
                ['kode' => 'dikirim',      'label' => 'Dikirim',   'ikon' => '📤'],
                ['kode' => 'diverifikasi', 'label' => 'Diverifikasi', 'ikon' => '✔️'],
                ['kode' => 'diproses',     'label' => 'Diproses',  'ikon' => '🔧'],
                ['kode' => 'selesai',      'label' => 'Selesai',   'ikon' => '✅'],
            ];
            $urutanStatus = array_column($tahapan, 'kode');
            $indeksSekarang = array_search($laporan->status, $urutanStatus);
            ?>

            <?php $__currentLoopData = $tahapan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $tahap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $lewat   = $indeksSekarang !== false && $i < $indeksSekarang;
                    $aktif   = $i === $indeksSekarang;
                ?>
                <div class="ld-step <?php echo e($lewat ? 'ld-step--lewat' : ''); ?> <?php echo e($aktif ? 'ld-step--sekarang' : ''); ?>">
                    <div class="ld-step__nomor">
                        <?php if($lewat): ?> <?php echo e($tahap['ikon']); ?>

                        <?php elseif($aktif): ?> <?php echo e($tahap['ikon']); ?>

                        <?php else: ?> <?php echo e($i + 1); ?>

                        <?php endif; ?>
                    </div>
                    <div class="ld-step__label"><?php echo e($tahap['label']); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">

            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                
                <?php if($laporan->prioritas_ai): ?>
                <div class="ld-card" data-animate="fadeUp" data-delay="0.15" style="border: 1px solid rgba(53,117,175,0.2); background: linear-gradient(135deg, #F0F7FF, #E8F4FD);">
                    <div class="ld-card__body">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                            <div style="width: 40px; height: 40px; background: var(--ld-grad-primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">✨</div>
                            <div>
                                <div style="font-weight: 700; font-size: 0.9rem; color: var(--ld-indigo);">Analisis AI Gemini</div>
                                <div style="font-size: 0.75rem; color: var(--ld-cobalt);">Penilaian otomatis berdasarkan foto</div>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                            <div style="text-align: center; background: white; padding: 0.875rem; border-radius: 12px;">
                                <div style="font-family: var(--ld-font-display); font-size: 1.25rem; font-weight: 800; color: var(--ld-indigo);"><?php echo e($laporan->label_prioritas); ?></div>
                                <div style="font-size: 0.7rem; color: var(--ld-text-muted); margin-top: 2px;">Prioritas</div>
                            </div>
                            <div style="text-align: center; background: white; padding: 0.875rem; border-radius: 12px;">
                                <div style="font-family: var(--ld-font-display); font-size: 1.25rem; font-weight: 800; color: var(--ld-indigo);"><?php echo e($laporan->skor_keparahan_ai ?? '-'); ?></div>
                                <div style="font-size: 0.7rem; color: var(--ld-text-muted); margin-top: 2px;">Skor Keparahan</div>
                            </div>
                            <div style="text-align: center; background: white; padding: 0.875rem; border-radius: 12px;">
                                <div style="font-size: 0.75rem; font-weight: 600; color: var(--ld-indigo); line-height: 1.4;"><?php echo e($laporan->catatan_ai ?? 'Tidak tersedia'); ?></div>
                                <div style="font-size: 0.7rem; color: var(--ld-text-muted); margin-top: 4px;">Catatan AI</div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                
                <div class="ld-card" data-animate="fadeUp" data-delay="0.2">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">📋 Deskripsi Kerusakan</h2>
                    </div>
                    <div class="ld-card__body">
                        <p style="font-size: 0.9rem; color: var(--ld-text); line-height: 1.7;"><?php echo e($laporan->deskripsi); ?></p>
                    </div>
                </div>

                
                <?php if($laporan->foto_sebelum && count($laporan->foto_sebelum) > 0): ?>
                <div class="ld-card" data-animate="fadeUp" data-delay="0.25">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">📸 Foto Kerusakan (Sebelum)</h2>
                    </div>
                    <div class="ld-card__body">
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 0.75rem;">
                            <?php $__currentLoopData = $laporan->foto_sebelum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e(asset('storage/' . $foto)); ?>" alt="Foto sebelum"
                                style="width: 100%; height: 120px; object-fit: cover; border-radius: 10px; cursor: pointer; border: 1px solid var(--ld-border);"
                                onclick="bukaGambarBesar(this.src)">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if($laporan->foto_sesudah && count($laporan->foto_sesudah) > 0): ?>
                <div class="ld-card" data-animate="fadeUp" data-delay="0.3" style="border-color: #BBF7D0;">
                    <div class="ld-card__header" style="background: #F0FDF4;">
                        <h2 style="font-size: 0.9rem; font-weight: 700; color: #15803D;">✅ Foto Bukti Perbaikan (Sesudah)</h2>
                    </div>
                    <div class="ld-card__body">
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 0.75rem;">
                            <?php $__currentLoopData = $laporan->foto_sesudah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e(asset('storage/' . $foto)); ?>" alt="Foto sesudah"
                                style="width: 100%; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid #BBF7D0;">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php if($laporan->catatan_petugas): ?>
                        <div style="margin-top: 1rem; padding: 0.875rem; background: #F0FDF4; border-radius: 10px; border-left: 3px solid #16A34A;">
                            <div style="font-size: 0.75rem; font-weight: 600; color: #15803D; margin-bottom: 0.375rem;">Catatan Petugas:</div>
                            <p style="font-size: 0.875rem; color: #166534;"><?php echo e($laporan->catatan_petugas); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                
                <?php if($laporan->ulasan): ?>
                <div class="ld-card" data-animate="fadeUp" data-delay="0.35">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">⭐ Ulasan Pelapor</h2>
                    </div>
                    <div class="ld-card__body">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <?php for($b = 1; $b <= 5; $b++): ?>
                                <span style="font-size: 1.25rem; color: <?php echo e($b <= $laporan->ulasan->bintang ? '#F59E0B' : '#E2E8F0'); ?>;">★</span>
                            <?php endfor; ?>
                            <span style="font-size: 0.875rem; font-weight: 600; color: var(--ld-text);"><?php echo e($laporan->ulasan->bintang); ?>/5</span>
                            <span style="font-size: 0.8rem; color: var(--ld-text-muted);">oleh <?php echo e($laporan->ulasan->nama_penulis); ?></span>
                        </div>
                        <?php if($laporan->ulasan->komentar): ?>
                        <p style="font-size: 0.875rem; color: var(--ld-text); line-height: 1.6; font-style: italic;">"<?php echo e($laporan->ulasan->komentar); ?>"</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                
                <div class="ld-card" data-animate="fadeRight" data-delay="0.15">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">📍 Lokasi</h2>
                    </div>
                    <div class="ld-card__body" style="font-size: 0.8625rem;">
                        <div style="display: flex; flex-direction: column; gap: 0.625rem;">
                            <div><strong>Alamat:</strong><br><?php echo e($laporan->alamat_lengkap); ?></div>
                            <div><strong>Kelurahan:</strong> <?php echo e($laporan->kelurahan); ?></div>
                            <div><strong>Kecamatan:</strong> <?php echo e($laporan->kecamatan); ?></div>
                            <div><strong>Kota:</strong> <?php echo e($laporan->kota); ?></div>
                            <div><strong>Provinsi:</strong> <?php echo e($laporan->provinsi); ?></div>
                            <div style="padding: 0.5rem; background: var(--ld-bg-soft); border-radius: 8px; font-family: monospace; font-size: 0.775rem;">
                                <?php echo e($laporan->latitude); ?>, <?php echo e($laporan->longitude); ?>

                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="ld-card" data-animate="fadeRight" data-delay="0.2">
                    <div class="ld-card__header">
                        <h2 style="font-size: 0.9rem; font-weight: 700;">🕐 Riwayat Status</h2>
                    </div>
                    <div class="ld-card__body">
                        <div class="ld-timeline">
                            <?php $__currentLoopData = $laporan->riwayatStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $riwayat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $isLast = $i === $laporan->riwayatStatus->count() - 1; ?>
                            <div class="ld-timeline__item <?php echo e($isLast ? 'ld-timeline__item--aktif' : ''); ?>">
                                <div class="ld-timeline__dot <?php echo e($isLast ? 'ld-timeline__dot--aktif' : 'ld-timeline__dot--selesai'); ?>">
                                    <?php if($riwayat->status_baru === 'selesai'): ?> ✅
                                    <?php elseif($riwayat->status_baru === 'diproses'): ?> 🔧
                                    <?php elseif($riwayat->status_baru === 'diverifikasi'): ?> ✔️
                                    <?php elseif($riwayat->status_baru === 'ditolak'): ?> ❌
                                    <?php else: ?> 📤
                                    <?php endif; ?>
                                </div>
                                <div class="ld-timeline__konten">
                                    <div class="ld-timeline__label"><?php echo e(ucfirst($riwayat->status_baru)); ?></div>
                                    <div class="ld-timeline__waktu">
                                        <?php echo e($riwayat->created_at->format('d M Y, H:i')); ?>

                                        <?php if($riwayat->pengubah): ?>· <?php echo e($riwayat->pengubah->nama_lengkap); ?><?php endif; ?>
                                    </div>
                                    <?php if($riwayat->catatan): ?>
                                    <div class="ld-timeline__catatan"><?php echo e($riwayat->catatan); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="lightboxGambar" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 9999; align-items: center; justify-content: center; cursor: zoom-out;" onclick="tutupGambarBesar()">
    <img id="lightboxGambarImg" src="" alt="" style="max-width: 90vw; max-height: 90vh; object-fit: contain; border-radius: 12px;">
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function bukaGambarBesar(src) {
    document.getElementById('lightboxGambarImg').src = src;
    const lb = document.getElementById('lightboxGambar');
    lb.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function tutupGambarBesar() {
    document.getElementById('lightboxGambar').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') tutupGambarBesar();
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/laporan/detail.blade.php ENDPATH**/ ?>