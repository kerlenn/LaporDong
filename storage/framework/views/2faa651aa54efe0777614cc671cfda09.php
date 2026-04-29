<?php $__env->startSection('judul', 'LaporDong - Buat Laporan Baru'); ?>

<?php $__env->startSection('konten'); ?>
<div class="ld-page-wrapper">
    <div class="ld-container ld-container--narrow">

        
        <div class="ld-header-section" data-animate="fadeUp">
            <a href="<?php echo e(url()->previous()); ?>" class="ld-btn ld-btn--ghost ld-btn--back ld-btn-back-link">
               <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Kembali
            </a> 
            <h1 class="ld-page-title">Buat Laporan Baru</h1>
            <p class="ld-page-subtitle">Lengkapi formulir di bawah. AI kami akan menganalisis foto dan menentukan prioritas secara otomatis.</p>
        </div>

        
        <form method="POST" action="<?php echo e(route('laporan.kirim')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            
            <div class="ld-card ld-card--mb" data-animate="fadeUp" data-delay="0.15">
                <div class="ld-card__header">
                    <div>
                        <h2 class="ld-section-title">Informasi Laporan</h2>
                        <p class="ld-section-subtitle">Deskripsikan kerusakan yang Anda temukan</p>
                    </div>
                </div>
                <div class="ld-card__body ld-card-body--stacked">

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
                        <textarea id="deskripsi" name="deskripsi" rows="5"
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

            
            <div class="ld-card ld-card--mb" data-animate="fadeUp" data-delay="0.2">
                <div class="ld-card__header">
                    <div>
                        <h2 class="ld-section-title">Lokasi Kejadian</h2>
                    </div>
                    <button type="button" id="tombolAmbilLokasi" class="ld-btn ld-btn--primer ld-btn--gps">
                        Ambil Lokasi GPS
                    </button>
                </div>
                <div class="ld-card__body ld-card-body--stacked">

                    <p id="statusGPS" class="ld-gps-status"></p>

                    
                    <div class="ld-map-container">
                        <label class="ld-label">Cari atau Geser Pin pada Peta</label>
                        <div class="ld-map-search-wrap">
                            <input type="text" id="mapSearchInput" class="ld-input" placeholder="Ketik nama jalan atau daerah...">
                            <button type="button" id="btnSearchMap" class="ld-btn ld-btn--primer ">Cari</button>
                        </div>
                        <div id="mapLocation" class="ld-map-view"></div>
                        <p class="ld-map-instruction">Klik atau tarik pin biru di atas untuk menentukan titik persis kerusakan.</p>
                    </div>

                    
                    <div class="ld-grid-half ld-mt-1rem">
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

                    <div class="ld-grid-half">
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

                    <div class="ld-grid-third">
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

            
            <div class="ld-card ld-card--mb-lg" data-animate="fadeUp" data-delay="0.25">
                <div class="ld-card__header">
                    <div>
                        <h2 class="ld-section-title">Foto Bukti Kerusakan</h2>
                        <p class="ld-section-subtitle">1-5 foto · Max 5MB per foto · JPG/PNG/WebP</p>
                    </div>
                </div>

                <div class="ld-card__body">
                    <div class="ld-upload-area">
                        <input type="file" name="foto_sebelum" id="inputFoto" accept="image/*" class="sr-only">
                        <div class="ld-upload-teks">
                            <div class="ld-upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#234A89" class="bi bi-image" viewBox="0 0 16 16">
                                  <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                  <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
                                </svg>
                            </div>
                            <p class="ld-upload-title">Klik atau seret foto ke sini</p>
                            <p class="ld-upload-subtitle">Foto yang jelas membantu AI menganalisis lebih akurat</p>
                        </div>
                        <div class="ld-upload-preview ld-upload-preview-container"></div>
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

            
            <div class="ld-form-actions" data-animate="fadeUp" data-delay="0.3">
                <a href="<?php echo e(route('dasbor.warga')); ?>" class="ld-btn ld-btn--ghost">Batal</a>
                <button type="submit" class="ld-btn ld-btn--primer ld-btn--lg">
                    Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/laporan/buat.blade.php ENDPATH**/ ?>