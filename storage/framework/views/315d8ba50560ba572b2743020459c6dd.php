

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
    
    <div class="bg-white rounded-2xl p-6 border border-earth-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-leaf-100 text-leaf-600 rounded-xl flex items-center justify-center text-2xl">
                👥
            </div>
            <div>
                <p class="text-sm font-medium text-earth-500">Total Users</p>
                <p class="text-2xl font-bold text-earth-900"><?php echo e(number_format($stats['totalUsers'])); ?></p>
            </div>
        </div>
    </div>
    
    
    <div class="bg-white rounded-2xl p-6 border border-earth-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-leaf-100 text-leaf-600 rounded-xl flex items-center justify-center text-2xl">
                📖
            </div>
            <div>
                <p class="text-sm font-medium text-earth-500">Total Artikel</p>
                <p class="text-2xl font-bold text-earth-900"><?php echo e(number_format($stats['totalArticles'])); ?></p>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl p-6 border border-earth-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-2xl">
                📝
            </div>
            <div>
                <p class="text-sm font-medium text-earth-500">Artikel Draft</p>
                <p class="text-2xl font-bold text-earth-900"><?php echo e(number_format($stats['draftArticles'])); ?></p>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl p-6 border border-earth-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-leaf-100 text-leaf-600 rounded-xl flex items-center justify-center text-2xl">
                📷
            </div>
            <div>
                <p class="text-sm font-medium text-earth-500">Total Scan</p>
                <p class="text-2xl font-bold text-earth-900"><?php echo e(number_format($stats['totalScans'])); ?></p>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl p-6 border border-earth-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-2xl">
                🫙
            </div>
            <div>
                <p class="text-sm font-medium text-earth-500">Galon Aktif</p>
                <p class="text-2xl font-bold text-earth-900"><?php echo e(number_format($stats['activeBatches'])); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-earth-200 flex justify-between items-center">
            <h2 class="text-lg font-bold text-earth-800">Artikel Terbaru</h2>
            <a href="<?php echo e(route('admin.articles.index')); ?>" class="text-sm text-leaf-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-earth-100">
            <?php $__empty_1 = true; $__currentLoopData = $recentArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="px-6 py-4 flex justify-between items-center hover:bg-earth-50 transition">
                    <div>
                        <h3 class="text-sm font-semibold text-earth-900 line-clamp-1"><?php echo e($article->title); ?></h3>
                        <p class="text-xs text-earth-500 mt-1"><?php echo e($article->created_at->format('d M Y')); ?></p>
                    </div>
                    <div>
                        <?php if($article->is_published): ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-md bg-green-100 text-green-700">Published</span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-md bg-amber-100 text-amber-700">Draft</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-6 py-8 text-center text-earth-500 text-sm">Belum ada artikel</div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-earth-200 flex justify-between items-center">
            <h2 class="text-lg font-bold text-earth-800">User Terbaru</h2>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="text-sm text-leaf-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-earth-100">
            <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="px-6 py-4 flex justify-between items-center hover:bg-earth-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-earth-200 text-earth-600 flex items-center justify-center text-xs font-bold">
                            <?php echo e(substr($user->name, 0, 1)); ?>

                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-earth-900"><?php echo e($user->name); ?></h3>
                            <p class="text-xs text-earth-500 mt-1"><?php echo e($user->phone); ?></p>
                        </div>
                    </div>
                    <div class="text-xs text-earth-400">
                        <?php echo e($user->created_at->diffForHumans()); ?>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-6 py-8 text-center text-earth-500 text-sm">Belum ada user</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>