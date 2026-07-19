

<?php $__env->startSection('title', 'Manajemen Artikel'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-earth-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form method="GET" action="<?php echo e(route('admin.articles.index')); ?>" class="w-full sm:w-96 relative">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari judul artikel..." 
                   class="w-full pl-10 pr-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-earth-400">🔍</span>
            </div>
        </form>
        <a href="<?php echo e(route('admin.articles.create')); ?>" class="btn-primary py-2 px-4 text-sm whitespace-nowrap">
            + Tambah Artikel
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-earth-50 text-earth-600 text-sm border-b border-earth-200">
                    <th class="px-6 py-3 font-medium">Judul</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium">Tanggal</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-earth-100 text-sm text-earth-800">
                <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-earth-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-earth-900 mb-1 line-clamp-1"><?php echo e($article->title); ?></div>
                            <div class="text-xs text-earth-500 line-clamp-1"><?php echo e($article->excerpt ?? 'Tidak ada ringkasan'); ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <?php if($article->is_published): ?>
                                <span class="px-2.5 py-1 text-xs font-medium rounded-md bg-green-100 text-green-700">Published</span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 text-xs font-medium rounded-md bg-amber-100 text-amber-700">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-earth-500">
                            <?php echo e($article->created_at->format('d M Y')); ?>

                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.articles.edit', $article)); ?>" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    ✏️
                                </a>
                                <form action="<?php echo e(route('admin.articles.destroy', $article)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-earth-500">
                            Belum ada artikel yang ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($articles->hasPages()): ?>
        <div class="px-6 py-4 border-t border-earth-200">
            <?php echo e($articles->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views/admin/articles/index.blade.php ENDPATH**/ ?>