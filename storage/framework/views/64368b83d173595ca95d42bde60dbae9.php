<?php $__env->startSection('judul', 'LaporDong - Masuk'); ?>

<?php $__env->startSection('konten'); ?>
<div class="ld-auth-wrapper">

    <div class="ld-auth-container">

        <div class="ld-auth-header">
            <a href="<?php echo e(route('beranda')); ?>" class="ld-logo">
                <img src="<?php echo e(asset('images/logo_1.png')); ?>" alt="Logo LaporDong" class="ld-logo_img_daftar">
            </a>
            <p class="ld-auth-subtext">Selamat datang kembali!</p>
        </div>

        <div class="ld-card ld-auth-card" data-delay="0.1">
            <div class="ld-card__header">
                <div>
                    <h1 class="ld-auth-title">Masuk ke Akun</h1>
                </div>
            </div>

            <div class="ld-card__body">
                <form method="POST" action="<?php echo e(route('masuk')); ?>" class="ld-auth-form">
                    <?php echo csrf_field(); ?>

                    <div class="ld-form-group">
                        <label for="email" class="ld-label">Alamat Email <span>*</span></label>
                        <input type="email" id="email" name="email"
                            value="<?php echo e(old('email')); ?>"
                            class="ld-input <?php echo e($errors->has('email') ? 'ld-input--error' : ''); ?>"
                            placeholder="Tuliskan Alamat Emailmu" required autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="ld-form-group">
                        <div class="ld-password-header">
                            <label for="password" class="ld-label">Password <span>*</span></label>
                        </div>
                        <input type="password" id="password" name="password"
                            class="ld-input <?php echo e($errors->has('password') ? 'ld-input--error' : ''); ?>"
                            placeholder="Masukkan password" required>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="ld-error-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="ld-remember">
                        <input type="checkbox" id="ingat_saya" name="ingat_saya" class="ld-checkbox">
                        <label for="ingat_saya" class="ld-remember-label">Ingat saya</label>
                    </div>

                    <button type="submit" class="ld-btn ld-btn--primer ld-login-btn">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="ld-auth-footer">
                    <p>
                        Belum punya akun?
                        <a href="<?php echo e(route('daftar')); ?>" class="ld-auth-link">Daftar gratis</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.utama', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lapordong\resources\views/pages/auth/masuk.blade.php ENDPATH**/ ?>