<?php $__env->startSection('judul', 'LaporDong - Eksplorasi Laporan'); ?>

<?php $__env->startSection('konten'); ?>


<section style="padding: 4rem 1rem 5rem; background: linear-gradient(135deg, var(--warna-indigo) 0%, var(--warna-cobalt) 60%, #0EA5E9 100%); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -80px; right: -80px; width: 300px; height: 300px; border-radius: 50%; background: rgba(255,255,255,0.05);"></div>
    <div style="position: absolute; bottom: -60px; left: 10%; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,0.04);"></div>
    <div style="max-width: 700px; margin: 0 auto; text-align: center; position: relative;">
        <h1 style="ld-hero__judul"> 
            Eksplorasi Laporan
        </h1>
        <p style="ld-hero__desc">
            Pantau kerusakan jalan di seluruh Indonesia, beri ulasan, dan nilai kinerja pemerintah daerahmu.
        </p>

        
        <form method="GET" action="<?php echo e(route('eksplorasi')); ?>">
            <div style="display: flex; gap: 0.5rem; max-width: 500px; margin: 0 auto;">
                <input type="text" name="cari" value="<?php echo e(request('cari')); ?>"
                    placeholder="Cari nama jalan, kota, atau daerah..."
                    style="flex: 1; padding: 0.875rem 1.25rem; border-radius: 100px; border: none; font-size: 0.9375rem; outline: none; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <button type="submit" style="padding: 0.875rem 1.5rem; background: white; color: var(--warna-indigo); border: none; border-radius: 100px; font-weight: 700; cursor: pointer; white-space: nowrap;">
                    🔍 Cari
                </button>
            </div>
        </form>
    </div>
</section>

<div style="background: var(--warna-latar); padding: 2rem 1rem 4rem; min-height: 60vh;">
    <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 280px 1fr; gap: 2rem; margin-top: -2rem;">

        
        <div style="position: sticky; top: 6rem; height: fit-content;">
            <form method="GET" action="<?php echo e(route('eksplorasi')); ?>" id="filterForm">
                <?php if(request('cari')): ?>
                    <input type="hidden" name="cari" value="<?php echo e(request('cari')); ?>">
                <?php endif; ?>

                
                <div style="background: white; border-radius: 16px; padding: 1.25rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 1rem;">
                    <h3 style="font-weight: 700; font-size: 0.875rem; color: var(--warna-indigo); margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">🔽 Filter</h3>

                    <div style="margin-bottom: 1rem;">
                        <label style="font-size: 0.8125rem; font-weight: 600; color: var(--warna-teks); display: block; margin-bottom: 0.375rem;">Provinsi</label>
                        <select name="provinsi" onchange="document.getElementById('filterForm').submit()"
                            style="width: 100%; padding: 0.5rem 0.75rem; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 0.875rem; outline: none;">
                            <option value="">Semua Provinsi</option>
                            <?php $__currentLoopData = $daftarProvinsi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($prov); ?>" <?php echo e(request('provinsi') === $prov ? 'selected' : ''); ?>><?php echo e($prov); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="font-size: 0.8125rem; font-weight: 600; color: var(--warna-teks); display: block; margin-bottom: 0.375rem;">Kota / Kabupaten</label>
                        <select name="kota" onchange="document.getElementById('filterForm').submit()"
                            style="width: 100%; padding: 0.5rem 0.75rem; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 0.875rem; outline: none;">
                            <option value="">Semua Kota</option>
                            <?php $__currentLoopData = $daftarKota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($kota); ?>" <?php echo e(request('kota') === $kota ? 'selected' : ''); ?>><?php echo e($kota); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="font-size: 0.8125rem; font-weight: 600; color: var(--warna-teks); display: block; margin-bottom: 0.375rem;">Status</label>
                        <?php
                            $statusList = [
                                ''             => 'Semua Status',
                                'dikirim'      => '📤 Dikirim',
                                'diverifikasi' => '✔️ Diverifikasi',
                                'diproses'     => '🔧 Diproses',
                                'selesai'      => '✅ Selesai',
                            ];
                        ?>
                        <?php $__currentLoopData = $statusList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.375rem 0; cursor: pointer; font-size: 0.875rem;">
                                <input type="radio" name="status" value="<?php echo e($val); ?>"
                                    <?php echo e(request('status', '') === $val ? 'checked' : ''); ?>

                                    onchange="document.getElementById('filterForm').submit()">
                                <?php echo e($label); ?>

                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 600; color: var(--warna-teks); display: block; margin-bottom: 0.375rem;">Urutkan</label>
                        <select name="sort" onchange="document.getElementById('filterForm').submit()"
                            style="width: 100%; padding: 0.5rem 0.75rem; border: 1.5px solid #E5E7EB; border-radius: 10px; font-size: 0.875rem; outline: none;">
                            <option value="terbaru" <?php echo e(request('sort','terbaru') === 'terbaru' ? 'selected' : ''); ?>>🕐 Terbaru</option>
                            <option value="tertua" <?php echo e(request('sort') === 'tertua' ? 'selected' : ''); ?>>📅 Terlama</option>
                            <option value="bintang" <?php echo e(request('sort') === 'bintang' ? 'selected' : ''); ?>>⭐ Rating Tertinggi</option>
                        </select>
                    </div>
                </div>

                
                <?php if(request()->hasAny(['kota','provinsi','status','cari','sort'])): ?>
                    <a href="<?php echo e(route('eksplorasi')); ?>" style="display: block; text-align: center; padding: 0.625rem; background: #FEF2F2; color: #DC2626; border-radius: 10px; font-size: 0.875rem; font-weight: 600; text-decoration: none;">
                        ✕ Reset Filter
                    </a>
                <?php endif; ?>
            </form>
        </div>

        
        <div>
            
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="font-size: 0.875rem; color: var(--warna-teks-muted);">
                    Menampilkan <strong style="color: var(--warna-indigo);"><?php echo e($laporan->total()); ?></strong> laporan
                    <?php if(request('kota')): ?> di <strong><?php echo e(request('kota')); ?></strong> <?php endif; ?>
                    <?php if(request('provinsi')): ?> · <strong><?php echo e(request('provinsi')); ?></strong> <?php endif; ?>
                </div>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $statusColor = match($item->status) {
                    'selesai'      => ['bg' => '#ECFDF5', 'text' => '#065F46', 'border' => '#6EE7B7'],
                    'diproses'     => ['bg' => '#FFF7ED', 'text' => '#9A3412', 'border' => '#FED7AA'],
                    'diverifikasi' => ['bg' => '#EFF6FF', 'text' => '#1E40AF', 'border' => '#BFDBFE'],
                    default        => ['bg' => '#F9FAFB', 'text' => '#374151', 'border' => '#E5E7EB'],
                };
                $prioritasColor = match($item->prioritas_ai) {
                    'tinggi' => '#DC2626',
                    'sedang' => '#D97706',
                    'rendah' => '#059669',
                    default  => '#6B7280',
                };
                $foto = is_array($item->foto_sebelum) ? ($item->foto_sebelum[0] ?? null) : $item->foto_sebelum;
            ?>

            <div style="background: white; border-radius: 16px; padding: 1.25rem; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 1rem; border: 1px solid #F3F4F6; transition: box-shadow 0.2s;"
                onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.1)'"
                onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)'">

                
                <div style="display: flex; gap: 1rem; align-items: flex-start;">
                    
                    <?php if($foto): ?>
                        <img src="<?php echo e(asset('storage/' . $foto)); ?>" alt="Foto"
                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px; flex-shrink: 0; border: 1px solid #F3F4F6;">
                    <?php else: ?>
                        <div style="width: 80px; height: 80px; background: #F3F4F6; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; flex-shrink: 0;">🛣️</div>
                    <?php endif; ?>

                    <div style="flex: 1; min-width: 0;">
                        
                        <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.5rem;">
                            <span style="font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.625rem; border-radius: 100px; background: <?php echo e($statusColor['bg']); ?>; color: <?php echo e($statusColor['text']); ?>; border: 1px solid <?php echo e($statusColor['border']); ?>;">
                                <?php echo e($item->label_status); ?>

                            </span>
                            <?php if($item->prioritas_ai): ?>
                                <span style="font-size: 0.7rem; font-weight: 600; color: <?php echo e($prioritasColor); ?>;">
                                    ● <?php echo e($item->label_prioritas); ?>

                                </span>
                            <?php endif; ?>
                            <span style="font-size: 0.7rem; color: var(--warna-teks-muted); margin-left: auto;">
                                <?php echo e($item->created_at->diffForHumans()); ?>

                            </span>
                        </div>

                        
                        <h3 style="font-weight: 700; font-size: 0.9375rem; color: var(--warna-teks); line-height: 1.4; margin-bottom: 0.375rem;">
                            <?php echo e($item->judul); ?>

                        </h3>

                        
                        <div style="font-size: 0.8125rem; color: var(--warna-teks-muted);">
                            📍 <?php echo e($item->kecamatan); ?>, <?php echo e($item->kota); ?>, <?php echo e($item->provinsi); ?>

                        </div>
                    </div>
                </div>

                
                <p style="font-size: 0.875rem; color: var(--warna-teks-muted); margin: 0.875rem 0; line-height: 1.6;">
                    <?php echo e(Str::limit($item->deskripsi, 150)); ?>

                </p>

                
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; padding-top: 0.875rem; border-top: 1px solid #F9FAFB;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        
                        <div style="display: flex; align-items: center; gap: 0.375rem;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--warna-indigo); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.65rem; font-weight: 700;">
                                <?php echo e(strtoupper(substr($item->pelapor?->nama ?? 'A', 0, 1))); ?>

                            </div>
                            <span style="font-size: 0.8rem; color: var(--warna-teks-muted);"><?php echo e($item->pelapor?->nama ?? 'Anonim'); ?></span>
                        </div>

                        
                        <?php if($item->ulasan): ?>
                            <div style="display: flex; align-items: center; gap: 0.25rem; font-size: 0.8rem;">
                                <span style="color: #F59E0B;">★</span>
                                <span style="font-weight: 600; color: var(--warna-teks);"><?php echo e($item->ulasan->bintang); ?>/5</span>
                                <span style="color: var(--warna-teks-muted);">rating warga</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div style="display: flex; gap: 0.5rem;">
                        <?php if(auth()->guard()->check()): ?>
                            <?php if($item->status === 'selesai' && !$item->ulasan): ?>
                                <button onclick="toggleUlasan('ulasan-<?php echo e($item->id); ?>')"
                                    style="padding: 0.375rem 0.875rem; background: #FFF7ED; color: #D97706; border: 1px solid #FED7AA; border-radius: 100px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                                    ⭐ Beri Ulasan
                                </button>
                            <?php elseif($item->status === 'selesai' && $item->ulasan): ?>
                                <span style="padding: 0.375rem 0.875rem; background: #ECFDF5; color: #065F46; border: 1px solid #6EE7B7; border-radius: 100px; font-size: 0.8rem; font-weight: 600;">
                                    ✓ Sudah Diulas
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if($item->status === 'selesai'): ?>
                                <a href="<?php echo e(route('masuk')); ?>"
                                    style="padding: 0.375rem 0.875rem; background: #F3F4F6; color: var(--warna-teks-muted); border-radius: 100px; font-size: 0.8rem; text-decoration: none;">
                                    Login untuk beri ulasan
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php if(auth()->guard()->check()): ?>
                <?php if($item->status === 'selesai' && !$item->ulasan): ?>
                <div id="ulasan-<?php echo e($item->id); ?>" style="display: none; margin-top: 1rem; padding: 1rem; background: #FFFBEB; border-radius: 12px; border: 1px solid #FCD34D;">
                    <form method="POST" action="<?php echo e(route('eksplorasi.ulasan', $item->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <div style="margin-bottom: 0.75rem;">
                            <label style="font-size: 0.8125rem; font-weight: 600; color: var(--warna-teks); display: block; margin-bottom: 0.5rem;">
                                Beri Bintang untuk Penanganan di <?php echo e($item->kota); ?>:
                            </label>
                            <div style="display: flex; gap: 0.375rem;" id="stars-<?php echo e($item->id); ?>">
                                <?php for($s = 1; $s <= 5; $s++): ?>
                                    <label style="cursor: pointer; font-size: 1.5rem; color: #D1D5DB;" class="star-label">
                                        <input type="radio" name="bintang" value="<?php echo e($s); ?>" required style="display: none;"
                                            onchange="highlightStars('stars-<?php echo e($item->id); ?>', <?php echo e($s); ?>)">
                                        ★
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <textarea name="komentar" placeholder="Tulis komentar (opsional)..."
                            style="width: 100%; padding: 0.625rem 0.875rem; border: 1.5px solid #FCD34D; border-radius: 10px; font-size: 0.875rem; resize: none; outline: none; box-sizing: border-box;"
                            rows="2"></textarea>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 0.625rem; flex-wrap: wrap; gap: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.375rem; font-size: 0.8125rem; color: var(--warna-teks-muted); cursor: pointer;">
                                <input type="checkbox" name="is_anonim" value="1"> Kirim anonim
                            </label>
                            <div style="display: flex; gap: 0.5rem;">
                                <button type="button" onclick="toggleUlasan('ulasan-<?php echo e($item->id); ?>')"
                                    style="padding: 0.375rem 0.875rem; background: white; border: 1px solid #E5E7EB; border-radius: 100px; font-size: 0.8rem; cursor: pointer;">
                                    Batal
                                </button>
                                <button type="submit"
                                    style="padding: 0.375rem 0.875rem; background: var(--warna-indigo); color: white; border: none; border-radius: 100px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                                    Kirim Ulasan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
                <?php endif; ?>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 16px;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                <h3 style="font-weight: 700; color: var(--warna-indigo); margin-bottom: 0.5rem;">Tidak ada laporan ditemukan</h3>
                <p style="color: var(--warna-teks-muted); font-size: 0.9rem;">Coba ubah filter atau kata kunci pencarianmu.</p>
                <a href="<?php echo e(route('eksplorasi')); ?>" style="display: inline-block; margin-top: 1rem; padding: 0.625rem 1.25rem; background: var(--warna-indigo); color: white; border-radius: 100px; font-size: 0.875rem; font-weight: 600; text-decoration: none;">
                    Lihat Semua Laporan
                </a>
            </div>
            <?php endif; ?>

            
            <?php if($laporan->hasPages()): ?>
                <div style="margin-top: 1.5rem;">
                    <?php echo e($laporan->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleUlasan(id) {
    const el = document.getElementById(id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

function highlightStars(containerId, rating) {
    const container = document.getElementById(containerId);
    const labels = container.querySelectorAll('.star-label');
    labels.forEach((label, idx) => {
        label.style.color = idx < rating ? '#F59E0B' : '#D1D5DB';
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/eksplorasi/index.blade.php ENDPATH**/ ?>