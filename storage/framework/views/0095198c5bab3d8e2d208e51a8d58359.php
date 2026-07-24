<?php $__env->startSection('title', 'Data Pupuk'); ?>

<?php $__env->startSection('content'); ?>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-earth-200 p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-earth-100 rounded-xl flex items-center justify-center">
                <span class="text-xl">📊</span>
            </div>
            <div>
                <p class="text-2xl font-bold text-earth-800"><?php echo e($stats['total']); ?></p>
                <p class="text-xs text-earth-500">Total Scan</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-green-200 p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                <span class="text-xl">✅</span>
            </div>
            <div>
                <p class="text-2xl font-bold text-green-700"><?php echo e($stats['normal']); ?></p>
                <p class="text-xs text-green-600">Normal</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-amber-200 p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                <span class="text-xl">⚠️</span>
            </div>
            <div>
                <p class="text-2xl font-bold text-amber-700"><?php echo e($stats['needs_stirring']); ?></p>
                <p class="text-xs text-amber-600">Perlu Diaduk</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-red-200 p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                <span class="text-xl">🚫</span>
            </div>
            <div>
                <p class="text-2xl font-bold text-red-700"><?php echo e($stats['contaminated']); ?></p>
                <p class="text-xs text-red-600">Terkontaminasi</p>
            </div>
        </div>
    </div>
</div>


<div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">

    
    <div class="p-6 border-b border-earth-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form method="GET" action="<?php echo e(route('admin.scans.index')); ?>" class="w-full sm:w-96 relative">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama user atau warna..."
                   class="w-full pl-10 pr-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-earth-400">🔍</span>
            </div>
            <?php if(request('status')): ?>
                <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
            <?php endif; ?>
        </form>

        
        <div class="flex items-center gap-2 flex-wrap">
            <a href="<?php echo e(route('admin.scans.index', array_merge(request()->except('status', 'page')))); ?>"
               class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors <?php echo e(!request('status') ? 'bg-earth-800 text-white' : 'bg-earth-100 text-earth-600 hover:bg-earth-200'); ?>">
                Semua
            </a>
            <a href="<?php echo e(route('admin.scans.index', array_merge(request()->except('page'), ['status' => 'normal']))); ?>"
               class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors <?php echo e(request('status') === 'normal' ? 'bg-green-600 text-white' : 'bg-green-50 text-green-700 hover:bg-green-100'); ?>">
                ✅ Normal
            </a>
            <a href="<?php echo e(route('admin.scans.index', array_merge(request()->except('page'), ['status' => 'needs_stirring']))); ?>"
               class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors <?php echo e(request('status') === 'needs_stirring' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100'); ?>">
                ⚠️ Perlu Diaduk
            </a>
            <a href="<?php echo e(route('admin.scans.index', array_merge(request()->except('page'), ['status' => 'contaminated']))); ?>"
               class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors <?php echo e(request('status') === 'contaminated' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100'); ?>">
                🚫 Terkontaminasi
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-earth-50 text-earth-600 text-sm border-b border-earth-200">
                    <th class="px-6 py-3 font-medium">Pengguna</th>
                    <th class="px-6 py-3 font-medium">Tanggal Scan</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium">Warna</th>
                    <th class="px-6 py-3 font-medium">Suhu</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-earth-100 text-sm text-earth-800">
                <?php $__empty_1 = true; $__currentLoopData = $scans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-earth-50 transition-colors">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-earth-200 to-earth-300 text-earth-700 flex items-center justify-center font-bold text-sm flex-shrink-0">
                                    <?php echo e(substr($scan->user->name ?? '?', 0, 1)); ?>

                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-earth-900 truncate"><?php echo e($scan->user->name ?? 'User Terhapus'); ?></div>
                                    <div class="text-xs text-earth-500 truncate"><?php echo e($scan->user->phone ?? '-'); ?></div>
                                </div>
                            </div>
                        </td>

                        
                        <td class="px-6 py-4">
                            <div class="text-earth-800"><?php echo e($scan->created_at->format('d M Y')); ?></div>
                            <div class="text-xs text-earth-500"><?php echo e($scan->created_at->format('H:i')); ?> WIB</div>
                        </td>

                        
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-md border <?php echo e($scan->status_color); ?>">
                                <?php echo e($scan->status_label); ?>

                            </span>
                        </td>

                        
                        <td class="px-6 py-4 text-earth-600 max-w-[150px] truncate" title="<?php echo e($scan->detected_color); ?>">
                            <?php echo e($scan->detected_color); ?>

                        </td>

                        
                        <td class="px-6 py-4">
                            <span class="font-medium text-earth-800"><?php echo e($scan->temperature); ?>°C</span>
                            <?php if($scan->temperature >= 25 && $scan->temperature <= 35): ?>
                                <span class="text-green-500 text-xs ml-1">✓</span>
                            <?php else: ?>
                                <span class="text-amber-500 text-xs ml-1">!</span>
                            <?php endif; ?>
                        </td>

                        
                        <td class="px-6 py-4 text-right">
                            <a href="<?php echo e(route('admin.scans.show', $scan)); ?>"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-leaf-50 text-leaf-700 hover:bg-leaf-100 transition-colors">
                                🔎 Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-earth-500">
                            <div class="text-4xl mb-2">🧪</div>
                            <p class="font-medium">Belum ada data scan pupuk.</p>
                            <p class="text-xs mt-1">Data akan muncul setelah pengguna melakukan scan pertama.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($scans->hasPages()): ?>
        <div class="px-6 py-4 border-t border-earth-200">
            <?php echo e($scans->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views/admin/scans/index.blade.php ENDPATH**/ ?>