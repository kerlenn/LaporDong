 
<?php $__env->startSection('judul', 'LaporDong - Daftar Akun Baru'); ?> 

<?php $__env->startSection('konten'); ?>
<div class="ld-auth-wrapper">

    <div class="ld-auth-container">

        <div class="ld-auth-header">
            <a href="<?php echo e(route('beranda')); ?>" class="ld-logo">
                <img src="<?php echo e(asset('images/logo_1.png')); ?>" alt="Logo LaporDong" class="ld-logo_img_daftar">
            </a>
            <p class="ld-auth-subtext">Bergabung dan bantu bangun Indonesia yang lebih baik!</p>
        </div>

        <div class="ld-card ld-auth-card" data-delay="0.1">
            <div class="ld-card__header">
                <div>
                    <h1 class="ld-auth-title">Buat Akun Baru</h1>
                </div>
            </div>

            <div class="ld-card__body">
                <form method="POST" action="<?php echo e(route('daftar')); ?>" class="ld-auth-form">
                    <?php echo csrf_field(); ?>

                    <div class="ld-form-group">
                        <label for="nama_lengkap" class="ld-label">Nama Lengkap <span>*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                            value="<?php echo e(old('nama_lengkap')); ?>"
                            class="ld-input <?php echo e($errors->has('nama_lengkap') ? 'ld-input--error' : ''); ?>"
                            placeholder="Tuliskan Nama Lengkapmu" required autofocus>
                        <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="ld-form-group">
                        <label for="email" class="ld-label">Alamat Email <span>*</span></label>
                        <input type="email" id="email" name="email"
                            value="<?php echo e(old('email')); ?>"
                            class="ld-input <?php echo e($errors->has('email') ? 'ld-input--error' : ''); ?>"
                            placeholder="Tuliskan Alamat Emailmu" required>
                        <?php $__errorArgs = ['email'];
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
                            <label for="no_telepon" class="ld-label">No. Telepon</label>
                            <input type="tel" id="no_telepon" name="no_telepon"
                                value="<?php echo e(old('no_telepon')); ?>"
                                class="ld-input" placeholder="Tuliskan No. Teleponmu">
                        </div>
                        <div class="ld-form-group">
                            <label for="kota_domisili" class="ld-label">Kota Domisili</label>
                            <input type="text" id="kota_domisili" name="kota_domisili"
                                value="<?php echo e(old('kota_domisili')); ?>"
                                class="ld-input" placeholder="Tuliskan Kota Domisilimu">
                        </div>
                    </div>

                    <div class="ld-form-group">
                        <label for="password" class="ld-label">Password <span>*</span></label>
                        <input type="password" id="password" name="password"
                            class="ld-input <?php echo e($errors->has('password') ? 'ld-input--error' : ''); ?>"
                            placeholder="Minimal 8 karakter" required>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="ld-form-group">
                        <label for="password_confirmation" class="ld-label">Konfirmasi Password <span>*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="ld-input" placeholder="Ulangi password" required>
                    </div>

                    <button type="submit" class="ld-btn ld-btn--primer ld-login-btn">
                        Buat Akun Sekarang
                    </button>
                </form>

                <div class="ld-auth-footer">
                    <p>
                        Sudah punya akun?
                        <a href="<?php echo e(route('masuk')); ?>" class="ld-auth-link">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/auth/daftar.blade.php ENDPATH**/ ?>