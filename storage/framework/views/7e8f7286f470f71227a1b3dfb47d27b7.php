<?php $__env->startSection('judul', 'Kelola Laporan'); ?>

<?php $__env->startSection('konten'); ?>
<section class="py-8 px-4 min-h-screen" style="background: var(--warna-latar);">
    <div class="max-w-7xl mx-auto">

        
        <div class="mb-6" data-animate="fadeUp">
            <h1 class="text-3xl font-bold" style="color: var(--warna-indigo); font-family: var(--font-display);">
                Kelola Laporan
            </h1>
            <p style="color: var(--warna-teks-muted);">
                Total <strong><?php echo e($laporan->total()); ?></strong> laporan ditemukan
            </p>
        </div>

        
        <div class="ld-card p-5 mb-6" data-animate="fadeUp">
            <form method="GET" action="<?php echo e(route('admin.laporan.daftar')); ?>"
                class="flex flex-wrap gap-3 items-end">
                <div class="flex-1" style="min-width: 200px;">
                    <label class="ld-label">Cari</label>
                    <input type="text" name="cari" value="<?php echo e(request('cari')); ?>"
                        placeholder="Judul, kode, nama pelapor..."
                        class="ld-input mt-1">
                </div>
                <div style="min-width: 140px;">
                    <label class="ld-label">Status</label>
                    <select name="status" class="ld-input mt-1">
                        <option value="">Semua Status</option>
                        <?php $__currentLoopData = ['dikirim','diverifikasi','diproses','selesai','ditolak']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($s)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="min-width: 140px;">
                    <label class="ld-label">Prioritas</label>
                    <select name="prioritas" class="ld-input mt-1">
                        <option value="">Semua Prioritas</option>
                        <?php $__currentLoopData = ['tinggi','sedang','rendah']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p); ?>" <?php echo e(request('prioritas') === $p ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($p)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="min-width: 180px;">
                    <label class="ld-label">Kota / Provinsi</label>
                    <input type="text" name="kota" value="<?php echo e(request('kota')); ?>"
                        placeholder="Cth: Bandung" class="ld-input mt-1">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="ld-btn-primer ld-btn-sm">Filter</button>
                    <?php if(request()->hasAny(['cari','status','prioritas','kota'])): ?>
                        <a href="<?php echo e(route('admin.laporan.daftar')); ?>" class="ld-btn-ghost ld-btn-sm">Reset</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        
        <div class="ld-card overflow-hidden" data-animate="fadeUp">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="background: var(--warna-latar-kartu-2); border-bottom: 2px solid var(--warna-icy);">
                            <th class="text-left py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Laporan</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Pelapor</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Status</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Prioritas</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Petugas</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold" style="color: var(--warna-teks-muted);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-blue-50 transition-colors"
                                style="border-bottom: 1px solid var(--warna-icy);">

                                
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <?php if($item->foto_sebelum): ?>
                                            <img src="<?php echo e(Storage::url(is_array($item->foto_sebelum) ? $item->foto_sebelum[0] : $item->foto_sebelum)); ?>"
                                                alt="Foto" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                        <?php else: ?>
                                            <div class="w-12 h-12 rounded-lg flex items-center justify-center text-xl"
                                                style="background: var(--warna-icy);">🛣️</div>
                                        <?php endif; ?>
                                        <div>
                                            <p class="font-medium text-sm max-w-xs truncate" style="color: var(--warna-teks);">
                                                <?php echo e($item->judul); ?>

                                            </p>
                                            <p class="text-xs font-mono" style="color: var(--warna-cobalt);">
                                                <?php echo e($item->kode_laporan); ?>

                                            </p>
                                            <p class="text-xs" style="color: var(--warna-teks-muted);">
                                                📍 <?php echo e($item->kota); ?>, <?php echo e($item->provinsi); ?>

                                            </p>
                                        </div>
                                    </div>
                                </td>

                                
                                <td class="py-3 px-4">
                                    <p class="text-sm font-medium" style="color: var(--warna-teks);">
                                        <?php echo e($item->pelapor->nama); ?>

                                    </p>
                                    <p class="text-xs" style="color: var(--warna-teks-muted);">
                                        <?php echo e($item->created_at->format('d M Y')); ?>

                                    </p>
                                </td>

                                
                                <td class="py-3 px-4 text-center">
                                    <span class="ld-badge ld-badge-<?php echo e($item->status); ?>">
                                        <?php echo e($item->label_status); ?>

                                    </span>
                                </td>

                                
                                <td class="py-3 px-4 text-center">
                                    <?php if($item->prioritas_ai): ?>
                                        <span class="text-xs font-semibold px-2 py-1 rounded-full"
                                            style="background: <?php echo e($item->warna_prioritas); ?>20; color: <?php echo e($item->warna_prioritas); ?>;">
                                            <?php echo e($item->label_prioritas); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-xs" style="color: var(--warna-teks-muted);">—</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="py-3 px-4">
                                    <?php if($item->petugas): ?>
                                        <p class="text-sm font-medium" style="color: var(--warna-teks);">
                                            <?php echo e($item->petugas->nama); ?>

                                        </p>
                                    <?php else: ?>
                                        <span class="text-xs" style="color: var(--warna-teks-muted);">Belum ditugaskan</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="py-3 px-4">
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        <a href="<?php echo e(route('laporan.detail', $item)); ?>"
                                            class="ld-btn-ghost ld-btn-sm">Detail</a>

                                        <?php if($item->status === 'dikirim'): ?>
                                            <form method="POST" action="<?php echo e(route('admin.laporan.verifikasi', $item)); ?>" class="inline">
                                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                <input type="hidden" name="aksi" value="terima">
                                                <button type="submit" class="ld-btn-primer ld-btn-sm"
                                                    data-konfirmasi="Verifikasi laporan ini?">
                                                    ✅ Verifikasi
                                                </button>
                                            </form>
                                            <form method="POST" action="<?php echo e(route('admin.laporan.verifikasi', $item)); ?>" class="inline">
                                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                <input type="hidden" name="aksi" value="tolak">
                                                <button type="submit" class="ld-btn-danger ld-btn-sm"
                                                    data-konfirmasi="Tolak laporan ini?">
                                                    ❌ Tolak
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if($item->status === 'diverifikasi'): ?>
                                            <button type="button"
                                                class="ld-btn-outline ld-btn-sm"
                                                onclick="bukaModalTugaskan(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->judul)); ?>')">
                                                👷 Tugaskan
                                            </button>
                                        <?php endif; ?>

                                        <?php if($item->status === 'diproses'): ?>
                                            <button type="button"
                                                class="ld-btn-primer ld-btn-sm"
                                                onclick="bukaModalSelesai(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->judul)); ?>')">
                                                🏆 Selesaikan
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <div class="text-4xl mb-3">🔍</div>
                                    <p style="color: var(--warna-teks-muted);">
                                        Tidak ada laporan yang sesuai filter
                                    </p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($laporan->hasPages()): ?>
                <div class="p-5 border-t" style="border-color: var(--warna-icy);">
                    <?php echo e($laporan->withQueryString()->links()); ?>

                </div>
            <?php endif; ?>
        </div>

    </div>
</section>


<div id="modalTugaskan" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
    style="background: rgba(0,0,0,0.5);">
    <div class="ld-card p-6 w-full max-w-md" data-animate="fadeUp">
        <h3 class="text-xl font-bold mb-2" style="color: var(--warna-indigo);">
            👷 Tugaskan Petugas
        </h3>
        <p class="text-sm mb-4" id="judulTugaskan" style="color: var(--warna-teks-muted);"></p>
        <form method="POST" id="formTugaskan" action="">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <div class="mb-4">
                <label class="ld-label">Pilih Petugas</label>
                <select name="petugas_id" class="ld-input mt-1" required>
                    <option value="">— Pilih Petugas —</option>
                    <?php $__currentLoopData = $semuaPetugas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $petugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($petugas->id); ?>">
                            <?php echo e($petugas->nama); ?> (<?php echo e($petugas->tugasSaya()->where('status','diproses')->count()); ?> tugas aktif)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="ld-label">Catatan (Opsional)</label>
                <textarea name="catatan" rows="2" class="ld-input mt-1"
                    placeholder="Instruksi khusus untuk petugas..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="ld-btn-primer flex-1">Tugaskan</button>
                <button type="button" onclick="tutupModal('modalTugaskan')"
                    class="ld-btn-ghost flex-1">Batal</button>
            </div>
        </form>
    </div>
</div>


<div id="modalSelesai" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
    style="background: rgba(0,0,0,0.5);">
    <div class="ld-card p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-2" style="color: var(--warna-indigo);">
            🏆 Selesaikan Laporan
        </h3>
        <p class="text-sm mb-4" id="judulSelesai" style="color: var(--warna-teks-muted);"></p>
        <form method="POST" id="formSelesai" action="" enctype="multipart/form-data">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <div class="mb-4">
                <label class="ld-label">Foto Sesudah Perbaikan <span style="color: #EF4444;">*</span></label>
                <div class="ld-upload-area mt-1" id="uploadSelesai">
                    <input type="file" name="foto_sesudah" id="fotoSelesai" accept="image/*" required class="sr-only">
                    <label for="fotoSelesai" class="cursor-pointer block text-center p-6">
                        <div class="text-3xl mb-2">📸</div>
                        <p class="text-sm font-medium" style="color: var(--warna-cobalt);">
                            Klik untuk unggah foto sesudah
                        </p>
                    </label>
                    <img id="previewSelesai" class="hidden w-full rounded-xl mt-2 max-h-48 object-cover">
                </div>
            </div>
            <div class="mb-4">
                <label class="ld-label">Catatan Penyelesaian</label>
                <textarea name="catatan" rows="2" class="ld-input mt-1"
                    placeholder="Deskripsi pekerjaan yang telah dilakukan..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="ld-btn-primer flex-1">Tandai Selesai</button>
                <button type="button" onclick="tutupModal('modalSelesai')"
                    class="ld-btn-ghost flex-1">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function bukaModalTugaskan(id, judul) {
    document.getElementById('judulTugaskan').textContent = judul;
    document.getElementById('formTugaskan').action = `/admin/laporan/${id}/tugaskan`;
    const modal = document.getElementById('modalTugaskan');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function bukaModalSelesai(id, judul) {
    document.getElementById('judulSelesai').textContent = judul;
    document.getElementById('formSelesai').action = `/admin/laporan/${id}/selesaikan`;
    const modal = document.getElementById('modalSelesai');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function tutupModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Preview foto sesudah
document.getElementById('fotoSelesai').addEventListener('change', function(e) {
    if (e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = (ev) => {
            const img = document.getElementById('previewSelesai');
            img.src = ev.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

// Tutup modal klik luar
['modalTugaskan','modalSelesai'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) tutupModal(id);
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/admin/daftar-laporan.blade.php ENDPATH**/ ?>