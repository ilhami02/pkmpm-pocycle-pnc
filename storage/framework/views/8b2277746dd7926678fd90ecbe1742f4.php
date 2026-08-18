

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


<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-6">
        <h2 class="text-lg font-bold text-earth-800 mb-4">Status Seluruh Galon</h2>
        <div class="relative h-64">
            <canvas id="batchStatusChart"></canvas>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-6">
        <h2 class="text-lg font-bold text-earth-800 mb-4">Umur Galon Aktif (Minggu)</h2>
        <div class="relative h-64">
            <canvas id="batchAgeChart"></canvas>
        </div>
    </div>
</div>


<div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-earth-200 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-bold text-earth-800">5 Galon Aktif (Update Terbaru)</h2>
            <p class="text-xs text-earth-500 mt-1">Daftar galon yang sedang difermentasi berdasarkan aktivitas terakhir.</p>
        </div>
        <a href="<?php echo e(route('admin.batches.active')); ?>" class="text-sm text-leaf-600 font-medium hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-earth-50 text-earth-600 text-xs border-b border-earth-200">
                    <th class="px-6 py-2 font-medium">User & Galon</th>
                    <th class="px-6 py-2 font-medium">Umur</th>
                    <th class="px-6 py-2 font-medium">Update Terakhir</th>
                    <th class="px-6 py-2 font-medium">Status Scan Terakhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-earth-100 text-sm text-earth-800">
                <?php $__empty_1 = true; $__currentLoopData = $recentActiveBatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $day = $batch->getFermentationDay();
                        $latestScan = $batch->scanHistories->first();
                    ?>
                    <tr class="hover:bg-earth-50 transition-colors">
                        <td class="px-6 py-3">
                            <div class="font-semibold text-earth-900"><?php echo e($batch->user->name ?? 'User Terhapus'); ?></div>
                            <div class="text-xs font-medium text-leaf-600 mt-0.5">🫙 <?php echo e($batch->name); ?></div>
                        </td>
                        <td class="px-6 py-3">
                            Hari ke-<?php echo e($day); ?>

                        </td>
                        <td class="px-6 py-3">
                            <div class="text-earth-800"><?php echo e($batch->updated_at->format('d M Y')); ?></div>
                            <div class="text-xs text-earth-500"><?php echo e($batch->updated_at->diffForHumans()); ?></div>
                        </td>
                        <td class="px-6 py-3">
                            <?php if($latestScan): ?>
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md border <?php echo e($latestScan->status_color); ?>">
                                    <?php echo e($latestScan->status_label); ?>

                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-500 border border-gray-200">
                                    ⚪ Belum ada scan
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-earth-500">
                            <div class="text-2xl mb-1">🫙</div>
                            <p class="text-sm">Tidak ada galon aktif.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data Status Galon
        const statusCtx = document.getElementById('batchStatusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Aktif', 'Dipanen', 'Gagal'],
                    datasets: [{
                        data: [
                            <?php echo e($chartBatchStatus['active']); ?>, 
                            <?php echo e($chartBatchStatus['harvested']); ?>, 
                            <?php echo e($chartBatchStatus['failed']); ?>

                        ],
                        backgroundColor: ['#3b82f6', '#10b981', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // Data Umur Galon Aktif
        const ageCtx = document.getElementById('batchAgeChart');
        if (ageCtx) {
            new Chart(ageCtx, {
                type: 'bar',
                data: {
                    labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4+'],
                    datasets: [{
                        label: 'Jumlah Galon Aktif',
                        data: [
                            <?php echo e($chartBatchAge['Minggu 1']); ?>,
                            <?php echo e($chartBatchAge['Minggu 2']); ?>,
                            <?php echo e($chartBatchAge['Minggu 3']); ?>,
                            <?php echo e($chartBatchAge['Minggu 4+']); ?>

                        ],
                        backgroundColor: '#059669',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>