
<?php $__env->startSection('title', 'Masuk'); ?>

<?php $__env->startSection('content'); ?>
    <h2 class="text-center mb-6">Masuk ke Akun</h2>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
        <?php echo csrf_field(); ?>

        
        <div>
            <label for="login" class="input-label">👤 Username atau 📱 Nomor HP</label>
            <input id="login" type="text" name="login" value="<?php echo e(old('login')); ?>" required autofocus autocomplete="username"
                   class="input-field" placeholder="Masukkan Username atau Nomor HP">
            <?php $__errorArgs = ['login'];
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

        
        <div x-data="{ show: false }">
            <label for="password" class="input-label">🔒 Password</label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                       class="input-field pr-12" placeholder="Masukkan password">
                <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-xl focus:outline-none text-earth-500 hover:text-earth-700">
                    <span x-show="!show">👁️</span>
                    <span x-show="show" style="display: none;">🙈</span>
                </button>
            </div>
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

        <div class="flex items-center justify-between mt-4 mb-2">
            
            <div class="flex items-center">
                <input id="remember" type="checkbox" name="remember" class="w-5 h-5 text-leaf-600 border-earth-300 rounded focus:ring-leaf-500">
                <label for="remember" class="ml-3 text-earth-600 text-lg">Ingat saya</label>
            </div>

            
            <div>
                <a href="<?php echo e(route('password.request')); ?>" class="text-leaf-600 hover:text-leaf-700 font-semibold text-lg">Lupa password?</a>
            </div>
        </div>

        
        <button type="submit" class="btn-primary w-full text-xl py-5">
            Masuk 🔑
        </button>
    </form>

    
    <div class="text-center mt-6 pt-6 border-t border-earth-200">
        <p class="text-earth-500 text-lg">
            Belum punya akun?
            <a href="<?php echo e(route('register')); ?>" class="text-leaf-600 hover:text-leaf-700 font-semibold">Daftar di sini</a>
        </p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views/auth/login.blade.php ENDPATH**/ ?>