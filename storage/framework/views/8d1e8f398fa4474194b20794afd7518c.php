
<?php $__env->startSection('title', 'Hasil Scan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    
    <div class="text-center mb-8">
        <h1 class="mb-3">Hasil Analisis - <?php echo e($scan->batch->name ?? 'Galon'); ?></h1>
        <p class="text-earth-500 text-lg">Scan tanggal <?php echo e($scan->created_at->translatedFormat('d F Y, H:i')); ?> WIB</p>
    </div>

    
    <div class="card mb-8 border-2 <?php echo e($scan->status_color); ?>">
        <div class="card-body text-center py-10">
            <div class="text-6xl mb-4">
                <?php switch($scan->status):
                    case ('normal'): ?> ✅ <?php break; ?>
                    <?php case ('needs_stirring'): ?> ⚠️ <?php break; ?>
                    <?php case ('contaminated'): ?> 🚫 <?php break; ?>
                    <?php default: ?> ❓
                <?php endswitch; ?>
            </div>
            <h2 class="text-2xl font-bold mb-2">
                <?php echo e($scan->status_label); ?>

            </h2>
            <p class="text-lg">
                <?php switch($scan->status):
                    case ('normal'): ?>
                        <span class="text-green-700">Pupuk Anda dalam kondisi baik!</span>
                        <?php break; ?>
                    <?php case ('needs_stirring'): ?>
                        <span class="text-amber-700">Pupuk memerlukan penanganan.</span>
                        <?php break; ?>
                    <?php case ('contaminated'): ?>
                        <span class="text-red-700">Pupuk terdeteksi bermasalah!</span>
                        <?php break; ?>
                <?php endswitch; ?>
            </p>
        </div>
    </div>

    
    <div class="space-y-6">

        
        <div class="card card-body">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-leaf-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">🎨</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-earth-700 mb-1">Warna Cairan</h3>
                    <p class="text-earth-800 text-xl"><?php echo e($scan->detected_color); ?></p>
                </div>
            </div>
        </div>

        
        <div class="card card-body">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-leaf-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">🌡️</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-earth-700 mb-1">Suhu Saat Scan</h3>
                    <p class="text-earth-800 text-xl"><?php echo e($scan->temperature); ?>°C
                        <?php if($scan->temperature >= 25 && $scan->temperature <= 35): ?>
                            <span class="text-green-600 text-base ml-2">✅ Ideal</span>
                        <?php else: ?>
                            <span class="text-amber-600 text-base ml-2">⚠️ Di luar rentang ideal (25-35°C)</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        
        <div class="card card-body bg-leaf-50 border-leaf-200">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-leaf-200 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">💡</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-leaf-800 mb-2">Rekomendasi Penanganan</h3>
                    <?php
                        // 1. Sanitasi teks dari XSS
                        $formattedText = e($scan->recommendation);
                        // 2. Ubah newline bawaan AI menjadi <br>
                        $formattedText = nl2br($formattedText);
                        // 3. Deteksi pola "1. ", "2. ", dst., lalu berikan jarak paragraf (<br><br>) dan tebalkan angkanya
                        $formattedText = preg_replace('/(?:\s|<br\s*\/?>)*(?<!\d)(\d+\.\s)/i', "<br><br><strong class='text-leaf-900'>$1</strong>", $formattedText);
                        // 4. Bersihkan jika kelebihan <br> di awal teks
                        $formattedText = preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $formattedText);
                    ?>
                    <p class="text-leaf-900 text-lg leading-relaxed"><?php echo $formattedText; ?></p>
                </div>
            </div>
        </div>

        
        <div class="card card-body">
            <h3 class="text-lg font-semibold text-earth-700 mb-3">📷 Foto yang Diunggah</h3>
            <div class="rounded-xl overflow-hidden bg-earth-100">
                <img src="<?php echo e(asset('storage/' . $scan->image_path)); ?>" alt="Foto pupuk scan" class="w-full max-h-80 object-contain">
            </div>
        </div>
    </div>

    
    <div class="flex flex-col sm:flex-row gap-4 mt-10">
        <?php if($scan->status === 'contaminated'): ?>
            <form action="<?php echo e(route('scan.restart')); ?>" method="POST" class="flex-1 flex">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="batch_id" value="<?php echo e($scan->fermentation_batch_id); ?>">
                <button type="submit" class="btn-primary flex-1 text-center text-xl py-5 bg-red-600 hover:bg-red-700 border-red-600 hover:border-red-700">
                    🔄 Buat Ulang Pupuk
                </button>
            </form>
        <?php else: ?>
            <a href="<?php echo e(route('scan.create')); ?>" class="btn-primary flex-1 text-center text-xl py-5">
                📷 Scan Ulang
            </a>
        <?php endif; ?>
        <a href="<?php echo e(route('history.index')); ?>" class="btn-secondary flex-1 text-center text-xl py-5">
            📋 Lihat Riwayat
        </a>
    </div>
    
    <div class="mt-4 text-center">
        <a href="<?php echo e(route('scan.create')); ?>" class="text-leaf-600 hover:text-leaf-800 font-semibold underline">
            📷 Scan Galon Lainnya
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views/scan/result.blade.php ENDPATH**/ ?>