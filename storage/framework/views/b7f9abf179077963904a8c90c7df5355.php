<?php $__env->startSection('title', 'Detail Scan #' . $scan->id); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">

    
    <div class="mb-6">
        <a href="<?php echo e(route('admin.scans.index')); ?>" class="inline-flex items-center gap-2 text-sm text-earth-500 hover:text-leaf-600 transition-colors">
            ← Kembali ke Data Pupuk
        </a>
    </div>

    
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-earth-200 to-earth-300 text-earth-700 flex items-center justify-center font-bold text-lg flex-shrink-0">
                    <?php echo e(substr($scan->user->name ?? '?', 0, 1)); ?>

                </div>
                <div>
                    <h2 class="text-lg font-bold text-earth-900"><?php echo e($scan->user->name ?? 'User Terhapus'); ?></h2>
                    <p class="text-sm text-earth-500"><?php echo e($scan->user->email ?? '-'); ?></p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-earth-500">Scan ID: <span class="font-mono font-medium text-earth-700">#<?php echo e($scan->id); ?></span></p>
                <p class="text-sm text-earth-500"><?php echo e($scan->created_at->translatedFormat('d F Y, H:i')); ?> WIB</p>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl border-2 shadow-sm p-8 mb-6 <?php echo e($scan->status_color); ?>">
        <div class="text-center">
            <div class="text-5xl mb-3">
                <?php switch($scan->status):
                    case ('normal'): ?> ✅ <?php break; ?>
                    <?php case ('needs_stirring'): ?> ⚠️ <?php break; ?>
                    <?php case ('contaminated'): ?> 🚫 <?php break; ?>
                    <?php default: ?> ❓
                <?php endswitch; ?>
            </div>
            <h3 class="text-2xl font-bold mb-2"><?php echo e($scan->status_label); ?></h3>
            <p class="text-lg">
                <?php switch($scan->status):
                    case ('normal'): ?>
                        <span class="text-green-700">Proses fermentasi pupuk berjalan dengan baik.</span>
                        <?php break; ?>
                    <?php case ('needs_stirring'): ?>
                        <span class="text-amber-700">Pupuk memerlukan penanganan segera.</span>
                        <?php break; ?>
                    <?php case ('contaminated'): ?>
                        <span class="text-red-700">Pupuk terdeteksi bermasalah atau terkontaminasi!</span>
                        <?php break; ?>
                <?php endswitch; ?>
            </p>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        
        <div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-earth-200">
                <h3 class="font-semibold text-earth-800 flex items-center gap-2">📷 Foto Pupuk</h3>
            </div>
            <div class="p-4">
                <div class="rounded-xl overflow-hidden bg-earth-100">
                    <img src="<?php echo e(asset('storage/' . $scan->image_path)); ?>"
                         alt="Foto pupuk scan #<?php echo e($scan->id); ?>"
                         class="w-full max-h-96 object-contain">
                </div>
            </div>
        </div>

        
        <div class="space-y-4">
            
            <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-leaf-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">🎨</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-earth-500 mb-1">Warna Cairan Terdeteksi</h4>
                        <p class="text-lg font-semibold text-earth-800"><?php echo e($scan->detected_color); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-leaf-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">🌡️</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-earth-500 mb-1">Suhu Saat Scan</h4>
                        <p class="text-lg font-semibold text-earth-800">
                            <?php echo e($scan->temperature); ?>°C
                            <?php if($scan->temperature >= 25 && $scan->temperature <= 35): ?>
                                <span class="text-green-600 text-sm ml-2">✅ Ideal</span>
                            <?php else: ?>
                                <span class="text-amber-600 text-sm ml-2">⚠️ Di luar rentang ideal</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">🤖</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-earth-500 mb-1">Provider AI</h4>
                        <p class="text-lg font-semibold text-earth-800"><?php echo e($scan->api_provider ?? 'N/A'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl border border-leaf-200 shadow-sm p-6 mb-6 bg-leaf-50">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-leaf-200 rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="text-2xl">💡</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-leaf-800 mb-2">Rekomendasi Penanganan dari AI</h3>
                <p class="text-leaf-900 leading-relaxed"><?php echo e($scan->recommendation); ?></p>
            </div>
        </div>
    </div>

    
    <?php if($scan->ai_raw_response): ?>
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden mb-6" x-data="{ open: false }">
        <button @click="open = !open"
                class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-earth-50 transition-colors">
            <h3 class="font-semibold text-earth-800 flex items-center gap-2">
                🔬 Respons AI Mentah (Debug)
            </h3>
            <svg class="w-5 h-5 text-earth-400 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-collapse x-cloak>
            <div class="px-6 pb-6">
                <pre class="bg-earth-900 text-green-400 rounded-xl p-4 text-xs overflow-x-auto max-h-96 overflow-y-auto font-mono leading-relaxed"><?php echo e(json_encode($scan->ai_raw_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views/admin/scans/show.blade.php ENDPATH**/ ?>