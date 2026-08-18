

<?php $__env->startSection('title', $isEdit ? 'Edit Artikel' : 'Tambah Artikel Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
    <form action="<?php echo e($isEdit ? route('admin.articles.update', $article) : route('admin.articles.store')); ?>" 
          method="POST" enctype="multipart/form-data" class="p-6">
        <?php echo csrf_field(); ?>
        <?php if($isEdit): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="space-y-6">
            
            <div>
                <label for="title" class="block text-sm font-medium text-earth-700 mb-1">Judul Artikel *</label>
                <input type="text" id="title" name="title" value="<?php echo e(old('title', $article->title)); ?>" required
                       class="w-full px-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-earth-900">
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="excerpt" class="block text-sm font-medium text-earth-700 mb-1">Ringkasan (Excerpt)</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          class="w-full px-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-earth-900"
                          placeholder="Ringkasan singkat untuk ditampilkan di daftar artikel"><?php echo e(old('excerpt', $article->excerpt)); ?></textarea>
                <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="body" class="block text-sm font-medium text-earth-700 mb-1">Konten Artikel (Bisa gunakan HTML/Markdown) *</label>
                <textarea id="body" name="body" rows="15" required
                          class="w-full px-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-earth-900 font-mono text-sm"
                          placeholder="Tulis konten artikel di sini..."><?php echo e(old('body', $article->body)); ?></textarea>
                <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p class="mt-1 text-xs text-earth-500">Anda dapat menggunakan tag HTML dasar seperti &lt;h2&gt;, &lt;p&gt;, &lt;strong&gt;, dll.</p>
            </div>

            
            <div>
                <label for="cover_image" class="block text-sm font-medium text-earth-700 mb-1">Cover Image</label>
                <?php if($isEdit && $article->cover_image): ?>
                    <div class="mb-3">
                        <img src="<?php echo e(Storage::url($article->cover_image)); ?>" alt="Cover" class="h-32 rounded-lg object-cover border border-earth-200">
                    </div>
                <?php endif; ?>
                <input type="file" id="cover_image" name="cover_image" accept="image/*"
                       class="w-full px-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-earth-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-leaf-50 file:text-leaf-700 hover:file:bg-leaf-100">
                <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="flex items-center gap-3 bg-earth-50 p-4 rounded-xl border border-earth-100">
                <input type="checkbox" id="is_published" name="is_published" value="1" 
                       <?php echo e(old('is_published', $article->is_published) ? 'checked' : ''); ?>

                       class="w-5 h-5 text-leaf-600 border-earth-300 rounded focus:ring-leaf-500">
                <label for="is_published" class="text-sm font-medium text-earth-800">
                    Publish Artikel Ini Sekarang
                    <span class="block text-xs text-earth-500 font-normal">Jika tidak dicentang, artikel akan disimpan sebagai draft.</span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <button type="submit" class="btn-primary px-6">
                <?php echo e($isEdit ? 'Simpan Perubahan' : 'Buat Artikel'); ?>

            </button>
            <a href="<?php echo e(route('admin.articles.index')); ?>" class="btn-secondary px-6">
                Batal
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views\admin\articles\form.blade.php ENDPATH**/ ?>