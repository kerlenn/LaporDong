<?php $__env->startSection('judul', 'Lacak Laporan'); ?>

<?php $__env->startSection('konten'); ?>
<section class="py-10 px-4 min-h-screen" style="background: var(--warna-latar);">
    <div class="max-w-2xl mx-auto">

        
        <div class="text-center mb-10" data-animate="fadeUp">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4"
                style="background: linear-gradient(135deg, var(--warna-indigo), var(--warna-cobalt));">
                <span class="text-3xl">🔍</span>
            </div>
            <h1 class="text-3xl font-bold" style="color: var(--warna-indigo); font-family: var(--font-display);">
                Lacak Laporan
            </h1>
            <p class="mt-2" style="color: var(--warna-teks-muted);">
                Masukkan kode laporan untuk melihat status penanganan secara real-time
            </p>
        </div>

        
        <div class="ld-card p-6 mb-6" data-animate="fadeUp">
            <form method="GET" action="<?php echo e(route('laporan.lacak')); ?>" class="flex gap-3">
                <input type="text" name="kode"
                    value="<?php echo e($kode ?? ''); ?>"
                    placeholder="Contoh: LD-ABC12345"
                    class="ld-input flex-1 font-mono text-lg tracking-widest"
                    style="text-transform: uppercase;"
                    maxlength="20"
                    autocomplete="off">
                <button type="submit" class="ld-btn-primer px-8">Cari</button>
            </form>
            <p class="text-xs mt-3" style="color: var(--warna-teks-muted);">
                💡 Kode laporan dikirim ke email kamu saat pertama kali melaporkan
            </p>
        </div>

        
        <?php if(isset($laporan)): ?>
            <div data-animate="fadeUp">
                
                <div class="ld-card p-6 mb-4"
                    style="border-top: 4px solid var(--warna-cobalt);">

                    <div class="flex flex-col sm:flex-row sm:items-start gap-4 mb-6">
                        <?php if($laporan->foto_sebelum): ?>
                            <img src="<?php echo e(Storage::url(is_array($laporan->foto_sebelum) ? $laporan->foto_sebelum[0] : $laporan->foto_sebelum)); ?>"
                                alt="Foto kerusakan"
                                class="w-24 h-24 object-cover rounded-xl flex-shrink-0"
                                style="border: 2px solid var(--warna-icy);">
                        <?php endif; ?>
                        <div class="flex-1">
                            <div class="flex flex-wrap gap-2 mb-2">
                                <span class="font-mono text-sm px-3 py-1 rounded-full font-semibold"
                                    style="background: var(--warna-icy); color: var(--warna-cobalt);">
                                    <?php echo e($laporan->kode_laporan); ?>

                                </span>
                                <span class="ld-badge ld-badge-<?php echo e($laporan->status); ?>">
                                    <?php echo e($laporan->label_status); ?>

                                </span>
                            </div>
                            <h2 class="text-xl font-bold" style="color: var(--warna-indigo);">
                                <?php echo e($laporan->judul); ?>

                            </h2>
                            <p class="text-sm mt-1" style="color: var(--warna-teks-muted);">
                                📍 <?php echo e($laporan->alamat_lengkap); ?>, <?php echo e($laporan->kota); ?>, <?php echo e($laporan->provinsi); ?>

                            </p>
                            <p class="text-sm" style="color: var(--warna-teks-muted);">
                                📅 Dilaporkan <?php echo e($laporan->created_at->format('d M Y, H:i')); ?> WIB
                            </p>
                        </div>
                    </div>

                    
                    <?php
                        $steps = [
                            'dikirim'     => ['label' => 'Dikirim',     'icon' => '📨'],
                            'diverifikasi'=> ['label' => 'Diverifikasi','icon' => '✅'],
                            'diproses'    => ['label' => 'Diproses',    'icon' => '🔧'],
                            'selesai'     => ['label' => 'Selesai',     'icon' => '🏆'],
                        ];
                        $stepKeys = array_keys($steps);
                        $currentIdx = array_search($laporan->status, $stepKeys);
                        $isDitolak = $laporan->status === 'ditolak';
                    ?>

                    <?php if($isDitolak): ?>
                        <div class="p-4 rounded-xl text-center"
                            style="background: #FEF2F2; border: 1px solid #FECACA;">
                            <span class="text-2xl">❌</span>
                            <p class="font-semibold mt-1" style="color: #DC2626;">Laporan Ditolak</p>
                            <p class="text-sm mt-1" style="color: #991B1B;">
                                Laporan ini tidak memenuhi kriteria verifikasi
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="ld-step-tracker">
                            <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $stepIdx = array_search($key, $stepKeys);
                                    $isDone = $currentIdx !== false && $stepIdx <= $currentIdx;
                                    $isActive = $key === $laporan->status;
                                ?>
                                <div class="ld-step <?php echo e($isDone ? 'selesai' : ''); ?> <?php echo e($isActive ? 'aktif' : ''); ?>">
                                    <div class="ld-step-bulat"><?php echo e($isDone ? '✓' : $step['icon']); ?></div>
                                    <div class="ld-step-label"><?php echo e($step['label']); ?></div>
                                </div>
                                <?php if(!$loop->last): ?>
                                    <div class="ld-step-konektor <?php echo e($isDone && $currentIdx > $stepIdx ? 'selesai' : ''); ?>"></div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>

                
                <?php if($laporan->prioritas_ai): ?>
                    <div class="ld-card p-5 mb-4"
                        style="border-left: 4px solid <?php echo e($laporan->warna_prioritas); ?>;">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="ld-badge-ai">🤖 AI Analysis</span>
                            <span class="font-semibold" style="color: <?php echo e($laporan->warna_prioritas); ?>;">
                                Prioritas <?php echo e($laporan->label_prioritas); ?>

                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span style="color: var(--warna-teks-muted);">Skor Keparahan</span>
                                <p class="font-bold text-lg" style="color: var(--warna-indigo);">
                                    <?php echo e($laporan->skor_keparahan ?? '-'); ?>/100
                                </p>
                            </div>
                            <div>
                                <span style="color: var(--warna-teks-muted);">Estimasi Penanganan</span>
                                <p class="font-bold text-lg" style="color: var(--warna-indigo);">
                                    <?php echo e($laporan->estimasi_hari ?? '-'); ?> Hari
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                
                <?php if($laporan->riwayatStatus->count() > 0): ?>
                    <div class="ld-card p-5" data-animate="fadeUp">
                        <h3 class="font-semibold mb-4" style="color: var(--warna-indigo);">
                            📋 Riwayat Penanganan
                        </h3>
                        <div class="ld-timeline">
                            <?php $__currentLoopData = $laporan->riwayatStatus->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $riwayat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="ld-timeline-item">
                                    <div class="ld-timeline-titik"></div>
                                    <div class="ld-timeline-konten">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="ld-badge ld-badge-<?php echo e($riwayat->status_baru); ?>">
                                                <?php echo e(ucfirst($riwayat->status_baru)); ?>

                                            </span>
                                            <span class="text-xs" style="color: var(--warna-teks-muted);">
                                                <?php echo e($riwayat->created_at->format('d M Y, H:i')); ?>

                                            </span>
                                        </div>
                                        <?php if($riwayat->catatan): ?>
                                            <p class="text-sm" style="color: var(--warna-teks);">
                                                <?php echo e($riwayat->catatan); ?>

                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif(isset($kode) && $kode): ?>
            
            <div class="ld-card p-12 text-center" data-animate="fadeUp">
                <div class="text-5xl mb-4">🔎</div>
                <h3 class="text-xl font-semibold mb-2" style="color: var(--warna-indigo);">Laporan Tidak Ditemukan</h3>
                <p style="color: var(--warna-teks-muted);">
                    Kode <code class="font-mono font-bold"><?php echo e(strtoupper($kode)); ?></code> tidak ada dalam sistem kami.
                </p>
                <p class="text-sm mt-2" style="color: var(--warna-teks-muted);">
                    Pastikan kode yang kamu masukkan benar.
                </p>
            </div>
        <?php endif; ?>

        
        <div class="ld-card p-5 mt-6" data-animate="fadeUp"
            style="background: linear-gradient(135deg, var(--warna-icy) 0%, white 100%);">
            <h3 class="font-semibold mb-3" style="color: var(--warna-indigo);">💡 Tips Pelacakan</h3>
            <ul class="space-y-1.5 text-sm" style="color: var(--warna-teks-muted);">
                <li>• Kode laporan dimulai dengan <strong>LD-</strong> diikuti karakter unik</li>
                <li>• Kode dikirim ke email kamu setelah laporan berhasil dikirim</li>
                <li>• Kamu juga dapat lacak lewat menu <strong>Laporan Saya</strong> jika sudah login</li>
                <li>• Status diperbarui secara real-time oleh petugas di lapangan</li>
            </ul>
        </div>

    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/laporan/lacak.blade.php ENDPATH**/ ?>