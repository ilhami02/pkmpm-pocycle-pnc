<?php $__env->startSection('title', 'Galon Aktif (On-Progress)'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden mb-6">
    
    <div class="p-6 border-b border-earth-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-earth-800">Daftar Galon Sedang Fermentasi</h2>
            <p class="text-sm text-earth-500 mt-1">Galon diurutkan berdasarkan aktivitas (update/scan) terbaru.</p>
        </div>
        <form method="GET" action="<?php echo e(route('admin.batches.active')); ?>" class="w-full sm:w-80 relative">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama user atau galon..."
                   class="w-full pl-10 pr-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-earth-400">🔍</span>
            </div>
        </form>
    </div>

    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-earth-50 text-earth-600 text-sm border-b border-earth-200">
                    <th class="px-6 py-3 font-medium">Pengguna & Galon</th>
                    <th class="px-6 py-3 font-medium">Umur (Minggu)</th>
                    <th class="px-6 py-3 font-medium">Update Terakhir</th>
                    <th class="px-6 py-3 font-medium">Status Scan Terakhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-earth-100 text-sm text-earth-800">
                <?php $__empty_1 = true; $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $day = $batch->getFermentationDay();
                        $week = ceil($day / 7);
                        $latestScan = $batch->scanHistories->first();
                    ?>
                    <tr class="hover:bg-earth-50 transition-colors">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-700 flex items-center justify-center font-bold text-sm flex-shrink-0">
                                    <?php echo e(substr($batch->user->name ?? '?', 0, 1)); ?>

                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-earth-900 truncate"><?php echo e($batch->user->name ?? 'User Terhapus'); ?></div>
                                    <div class="text-xs font-medium text-leaf-600 truncate mt-0.5">
                                        🫙 <?php echo e($batch->name); ?>

                                    </div>
                                </div>
                            </div>
                        </td>

                        
                        <td class="px-6 py-4">
                            <span class="font-medium text-earth-800">Hari ke-<?php echo e($day); ?></span>
                            <div class="text-xs text-earth-500 mt-0.5">Minggu ke-<?php echo e($week); ?></div>
                        </td>

                        
                        <td class="px-6 py-4">
                            <div class="text-earth-800"><?php echo e($batch->updated_at->format('d M Y')); ?></div>
                            <div class="text-xs text-earth-500 mt-0.5"><?php echo e($batch->updated_at->diffForHumans()); ?></div>
                        </td>

                        
                        <td class="px-6 py-4">
                            <?php if($latestScan): ?>
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-md border <?php echo e($latestScan->status_color); ?>">
                                    <?php echo e($latestScan->status_label); ?>

                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-500 border border-gray-200">
                                    ⚪ Belum ada scan
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-earth-500">
                            <div class="text-4xl mb-2">🫙</div>
                            <p class="font-medium">Tidak ada galon aktif saat ini.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if($batches->hasPages()): ?>
        <div class="px-6 py-4 border-t border-earth-200">
            <?php echo e($batches->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views\admin\batches\index.blade.php ENDPATH**/ ?>