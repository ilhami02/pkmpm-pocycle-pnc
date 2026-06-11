<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>

    
    <section class="relative overflow-hidden bg-gradient-to-br from-leaf-600 via-leaf-700 to-leaf-800 text-white">
        
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 text-8xl">🌿</div>
            <div class="absolute top-20 right-20 text-6xl">🍃</div>
            <div class="absolute bottom-10 left-1/3 text-7xl">🌱</div>
            <div class="absolute bottom-20 right-10 text-5xl">♻️</div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-20 md:py-28">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6 animate-fade-in-up">
                    Ubah Limbah Makanan<br>
                    Jadi <span class="text-leaf-200">Pupuk Organik</span> 🌿
                </h1>
                <p class="text-xl md:text-2xl text-leaf-100 leading-relaxed mb-10 animate-fade-in-up stagger-1">
                    POCYCLE membantu Anda memantau pembuatan Pupuk Organik Cair (POC) dari sisa makanan bergizi.
                    Cukup foto galon, dan kami analisis kondisinya!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up stagger-2">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('scan.create')); ?>" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-10 py-5">
                            📷 Scan Pupuk Sekarang
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('register')); ?>" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-10 py-5">
                            📷 Mulai Scan Pupuk
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('articles.index')); ?>" class="btn-secondary border-white/30 text-white hover:bg-white/10 text-xl px-10 py-5">
                        📖 Baca Panduan
                    </a>
                </div>
            </div>
        </div>
    </section>

    
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
        <div class="text-center mb-12">
            <h2 class="text-earth-900 mb-3">Cara Kerja POCYCLE</h2>
            <p class="text-earth-500 text-xl">Tiga langkah mudah memantau pupuk Anda</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            
            <div class="card card-body text-center group hover:border-leaf-300 transition-colors">
                <div class="w-20 h-20 mx-auto mb-6 bg-leaf-100 rounded-2xl flex items-center justify-center group-hover:bg-leaf-200 transition-colors">
                    <span class="text-4xl">📷</span>
                </div>
                <h3 class="mb-3">1. Foto Galon</h3>
                <p class="text-earth-500">
                    Ambil foto kondisi pupuk di dalam galon Le Minerale 15 liter Anda.
                </p>
            </div>

            
            <div class="card card-body text-center group hover:border-leaf-300 transition-colors">
                <div class="w-20 h-20 mx-auto mb-6 bg-leaf-100 rounded-2xl flex items-center justify-center group-hover:bg-leaf-200 transition-colors">
                    <span class="text-4xl">🌡️</span>
                </div>
                <h3 class="mb-3">2. Input Suhu</h3>
                <p class="text-earth-500">
                    Masukkan suhu saat ini dalam Celcius. Suhu ideal fermentasi antara 25-35°C.
                </p>
            </div>

            
            <div class="card card-body text-center group hover:border-leaf-300 transition-colors">
                <div class="w-20 h-20 mx-auto mb-6 bg-leaf-100 rounded-2xl flex items-center justify-center group-hover:bg-leaf-200 transition-colors">
                    <span class="text-4xl">✅</span>
                </div>
                <h3 class="mb-3">3. Lihat Hasil</h3>
                <p class="text-earth-500">
                    Dapatkan status pupuk beserta rekomendasi penanganan yang mudah dipahami.
                </p>
            </div>
        </div>
    </section>

    
    <?php if($articles->count() > 0): ?>
    <section class="bg-sage-50 py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-earth-900 mb-2">📖 Panduan & Edukasi</h2>
                    <p class="text-earth-500 text-xl">Pelajari cara membuat pupuk organik yang benar</p>
                </div>
                <a href="<?php echo e(route('articles.index')); ?>" class="btn-outline-leaf btn-sm hidden sm:inline-flex">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('articles.show', $article)); ?>" class="card group hover:border-leaf-300 transition-all hover:-translate-y-1">
                        <?php if($article->cover_image): ?>
                            <div class="aspect-video bg-earth-200 rounded-t-2xl overflow-hidden">
                                <img src="<?php echo e(asset('storage/' . $article->cover_image)); ?>" alt="<?php echo e($article->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        <?php else: ?>
                            <div class="aspect-video bg-gradient-to-br from-leaf-100 to-sage-200 rounded-t-2xl flex items-center justify-center">
                                <span class="text-5xl">📖</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <p class="text-sm text-earth-400 mb-2"><?php echo e($article->published_at?->translatedFormat('d M Y') ?? $article->created_at->translatedFormat('d M Y')); ?></p>
                            <h3 class="text-xl font-semibold text-earth-800 mb-2 group-hover:text-leaf-700 transition-colors line-clamp-2"><?php echo e($article->title); ?></h3>
                            <p class="text-earth-500 text-base line-clamp-2"><?php echo e($article->excerpt); ?></p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="text-center mt-8 sm:hidden">
                <a href="<?php echo e(route('articles.index')); ?>" class="btn-outline-leaf">Lihat Semua Artikel →</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
        <div class="bg-gradient-to-r from-leaf-600 to-leaf-700 rounded-3xl p-10 md:p-16 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-5 right-10 text-6xl">🌿</div>
                <div class="absolute bottom-5 left-10 text-6xl">♻️</div>
            </div>
            <div class="relative">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Siap Membuat Pupuk Organik? 🌱
                </h2>
                <p class="text-xl text-leaf-100 mb-8 max-w-2xl mx-auto">
                    Bergabung dengan ibu-ibu PKK Tritih Wetan dalam gerakan mengolah limbah makanan menjadi pupuk organik cair yang bermanfaat.
                </p>
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('register')); ?>" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-12 py-5">
                        Daftar Gratis Sekarang ✨
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('scan.create')); ?>" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-12 py-5">
                        Scan Pupuk Sekarang 📷
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ilham/web-edu-pkm/resources/views/welcome.blade.php ENDPATH**/ ?>