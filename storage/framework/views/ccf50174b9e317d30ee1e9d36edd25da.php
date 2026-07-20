
<?php $__env->startSection('title', 'Daftar'); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="text-center mb-6">Daftar Akun Baru</h2>

    <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-5">
        <?php echo csrf_field(); ?>

        
        <div>
            <label for="name" class="input-label">👤 Nama Lengkap</label>
            <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus autocomplete="name"
                   class="input-field" placeholder="Masukkan nama Anda">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="input-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="username" class="input-label">🏷️ Username</label>
            <input id="username" type="text" name="username" value="<?php echo e(old('username')); ?>" required autocomplete="username"
                   class="input-field" placeholder="contoh_username">
            <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="input-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="phone" class="input-label">📱 Nomor HP</label>
            <input id="phone" type="tel" name="phone" value="<?php echo e(old('phone')); ?>" required autocomplete="tel"
                   class="input-field" placeholder="08xxxxxxxxxx">
            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="input-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="password" class="input-label">🔒 Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="input-field" placeholder="Minimal 8 karakter">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="input-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div>
            <label for="password_confirmation" class="input-label">🔒 Ulangi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="input-field" placeholder="Masukkan ulang password">
            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="input-error"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <button type="submit" class="btn-primary w-full text-xl py-5">
            Daftar Sekarang ✨
        </button>
    </form>

    
    <div class="text-center mt-6 pt-6 border-t border-earth-200">
        <p class="text-earth-500 text-lg">
            Sudah punya akun?
            <a href="<?php echo e(route('login')); ?>" class="text-leaf-600 hover:text-leaf-700 font-semibold">Masuk di sini</a>
        </p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views/auth/register.blade.php ENDPATH**/ ?>