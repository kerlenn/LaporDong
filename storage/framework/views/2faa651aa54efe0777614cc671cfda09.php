<?php $__env->startSection('judul', 'Buat Laporan Baru — LaporDong'); ?>

<?php $__env->startSection('konten'); ?>
<div style="padding-top: 6rem; padding-bottom: 4rem; background: var(--ld-bg-soft); min-height: 100vh;">
    <div class="ld-container" style="max-width: 760px;">

        
        <div style="margin-bottom: 2rem;" data-animate="fadeUp">
            <a href="<?php echo e(route('dasbor.warga')); ?>" style="font-size: 0.875rem; color: var(--ld-cobalt); text-decoration: none; display: inline-flex; align-items: center; gap: 0.375rem; margin-bottom: 1.5rem;">
                ← Kembali ke Dasbor
            </a>
            <h1 style="font-family: var(--ld-font-display); font-size: 1.875rem; font-weight: 800; color: var(--ld-text); letter-spacing: -0.02em;">Buat Laporan Baru</h1>
            <p style="color: var(--ld-text-muted); margin-top: 0.5rem;">Lengkapi formulir di bawah. AI kami akan menganalisis foto dan menentukan prioritas secara otomatis.</p>
        </div>

        
        <div class="ld-ai-badge" style="display: flex; margin-bottom: 1.5rem; width: fit-content;" data-animate="fadeUp" data-delay="0.1">
            Gemini AI akan menganalisis foto Anda secara otomatis — validasi + prioritas SLA
        </div>

        
        <form method="POST" action="<?php echo e(route('laporan.kirim')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            
            <div class="ld-card" style="margin-bottom: 1.5rem;" data-animate="fadeUp" data-delay="0.15">
                <div class="ld-card__header">
                    <div>
                        <h2 style="font-family: var(--ld-font-display); font-size: 1rem; font-weight: 700;">📋 Informasi Laporan</h2>
                        <p style="font-size: 0.8rem; color: var(--ld-text-muted); margin-top: 2px;">Deskripsikan kerusakan yang Anda temukan</p>
                    </div>
                </div>
                <div class="ld-card__body" style="display: flex; flex-direction: column; gap: 1.25rem;">

                    <div class="ld-form-group">
                        <label for="judul" class="ld-label">Judul Laporan <span>*</span></label>
                        <input type="text" id="judul" name="judul" value="<?php echo e(old('judul')); ?>"
                            class="ld-input <?php echo e($errors->has('judul') ? 'ld-input--error' : ''); ?>"
                            placeholder="Cth: Lubang Besar di Jl. Sudirman Depan Toko Maju" required maxlength="200">
                        <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="ld-form-group">
                        <label for="deskripsi" class="ld-label">Deskripsi Kerusakan <span>*</span></label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="ld-textarea <?php echo e($errors->has('deskripsi') ? 'ld-input--error' : ''); ?>"
                            placeholder="Jelaskan kondisi kerusakan, ukuran perkiraan, dampak terhadap pengendara, dll. (min. 20 karakter)" required minlength="20" maxlength="2000"><?php echo e(old('deskripsi')); ?></textarea>
                        <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="ld-card" style="margin-bottom: 1.5rem;" data-animate="fadeUp" data-delay="0.2">
                <div class="ld-card__header">
                    <div>
                        <h2 style="font-family: var(--ld-font-display); font-size: 1rem; font-weight: 700;">📍 Lokasi Kejadian</h2>
                    </div>
                    <button type="button" id="tombolAmbilLokasi" class="ld-btn ld-btn--ghost ld-btn--sm"
                        style="background: rgba(53,117,175,0.08); border-color: rgba(53,117,175,0.2); color: var(--ld-cobalt);">
                        📡 Ambil Lokasi GPS
                    </button>
                </div>
                <div class="ld-card__body" style="display: flex; flex-direction: column; gap: 1.25rem;">

                    <p id="statusGPS" style="font-size: 0.8125rem; color: var(--ld-text-muted);"></p>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="ld-form-group">
                            <label for="latitude" class="ld-label">Latitude <span>*</span></label>
                            <input type="number" id="latitude" name="latitude" value="<?php echo e(old('latitude')); ?>"
                                class="ld-input <?php echo e($errors->has('latitude') ? 'ld-input--error' : ''); ?>"
                                placeholder="-6.9175" step="any" required>
                            <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="ld-form-group">
                            <label for="longitude" class="ld-label">Longitude <span>*</span></label>
                            <input type="number" id="longitude" name="longitude" value="<?php echo e(old('longitude')); ?>"
                                class="ld-input <?php echo e($errors->has('longitude') ? 'ld-input--error' : ''); ?>"
                                placeholder="107.6191" step="any" required>
                            <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="ld-form-group">
                        <label for="alamat_lengkap" class="ld-label">Alamat Lengkap <span>*</span></label>
                        <input type="text" id="alamat_lengkap" name="alamat_lengkap" value="<?php echo e(old('alamat_lengkap')); ?>"
                            class="ld-input <?php echo e($errors->has('alamat_lengkap') ? 'ld-input--error' : ''); ?>"
                            placeholder="Jl. Nama Jalan No. XX, RT/RW" required>
                        <?php $__errorArgs = ['alamat_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="ld-form-group">
                            <label for="kelurahan" class="ld-label">Kelurahan <span>*</span></label>
                            <input type="text" id="kelurahan" name="kelurahan" value="<?php echo e(old('kelurahan')); ?>"
                                class="ld-input" placeholder="Nama Kelurahan" required>
                        </div>
                        <div class="ld-form-group">
                            <label for="kecamatan" class="ld-label">Kecamatan <span>*</span></label>
                            <input type="text" id="kecamatan" name="kecamatan" value="<?php echo e(old('kecamatan')); ?>"
                                class="ld-input" placeholder="Nama Kecamatan" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                        <div class="ld-form-group">
                            <label for="kota" class="ld-label">Kota/Kabupaten <span>*</span></label>
                            <input type="text" id="kota" name="kota" value="<?php echo e(old('kota')); ?>"
                                class="ld-input" placeholder="Bandung" required>
                        </div>
                        <div class="ld-form-group">
                            <label for="provinsi" class="ld-label">Provinsi <span>*</span></label>
                            <input type="text" id="provinsi" name="provinsi" value="<?php echo e(old('provinsi')); ?>"
                                class="ld-input" placeholder="Jawa Barat" required>
                        </div>
                        <div class="ld-form-group">
                            <label for="kode_pos" class="ld-label">Kode Pos</label>
                            <input type="text" id="kode_pos" name="kode_pos" value="<?php echo e(old('kode_pos')); ?>"
                                class="ld-input" placeholder="40111">
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="ld-card" style="margin-bottom: 2rem;" data-animate="fadeUp" data-delay="0.25">
                <div class="ld-card__header">
                    <div>
                        <h2 style="font-family: var(--ld-font-display); font-size: 1rem; font-weight: 700;">📸 Foto Bukti Kerusakan</h2>
                        <p style="font-size: 0.8rem; color: var(--ld-text-muted); margin-top: 2px;">1-5 foto · Max 5MB per foto · JPG/PNG/WebP</p>
                    </div>
                    <div class="ld-ai-badge" style="font-size: 0.75rem;">AI akan menganalisis</div>
                </div>

                <div class="ld-card__body">
                    <div class="ld-upload-area">
                        <input type="file" name="foto_sebelum" id="inputFoto" accept="image/*" class="sr-only">
                        <div class="ld-upload-teks">
                            <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🖼️</div>
                            <p style="font-weight: 600; color: var(--ld-text); margin-bottom: 0.25rem;">Klik atau seret foto ke sini</p>
                            <p style="font-size: 0.8125rem; color: var(--ld-text-muted);">Foto yang jelas membantu AI menganalisis lebih akurat</p>
                        </div>
                        <div class="ld-upload-preview" style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1rem;"></div>
                    </div>
                    <?php $__errorArgs = ['foto_sebelum'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg mt-2 block"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['foto_sebelum.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg mt-2 block"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            
            <div style="display: flex; gap: 1rem; align-items: center; justify-content: flex-end;" data-animate="fadeUp" data-delay="0.3">
                <a href="<?php echo e(route('dasbor.warga')); ?>" class="ld-btn ld-btn--ghost">Batal</a>
                <button type="submit" class="ld-btn ld-btn--primer ld-btn--lg">
                    🚀 Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.ld-upload-preview__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
}
.ld-upload-preview__item img {
    width: 96px;
    height: 96px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid var(--ld-icy);
}
.ld-upload-preview__label {
    font-size: 0.6875rem;
    color: var(--ld-text-muted);
}
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    overflow: hidden;
    clip: rect(0,0,0,0);
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/laporan/buat.blade.php ENDPATH**/ ?>