<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'POCYCLE')); ?> Admin — <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen bg-earth-100" x-data="{ sidebarOpen: window.innerWidth >= 768 }">

    <div class="flex min-h-screen">

        
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-earth-900/50 z-40 md:hidden" x-cloak></div>

        
        <aside class="bg-earth-800 text-earth-300 flex flex-col flex-shrink-0 fixed md:sticky top-0 h-screen transition-all duration-300 z-50"
               :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-64 -translate-x-full md:translate-x-0 md:w-20'"
               x-cloak>

            
            <div class="px-5 py-6 border-b border-earth-700">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-leaf-500 to-leaf-700 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <span class="text-white text-lg">🌿</span>
                    </div>
                    <div x-show="sidebarOpen" x-transition>
                        <span class="text-lg font-bold text-white tracking-tight">POCYCLE</span>
                        <span class="block text-xs text-leaf-400 -mt-0.5">Admin Panel</span>
                    </div>
                </a>
            </div>

            
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="<?php echo e(route('admin.dashboard')); ?>"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all text-base font-medium
                          <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-leaf-600/20 text-leaf-400' : 'text-earth-400 hover:bg-earth-700 hover:text-white'); ?>">
                    <span class="text-xl flex-shrink-0">📊</span>
                    <span x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>
                <a href="<?php echo e(route('admin.articles.index')); ?>"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all text-base font-medium
                          <?php echo e(request()->routeIs('admin.articles.*') ? 'bg-leaf-600/20 text-leaf-400' : 'text-earth-400 hover:bg-earth-700 hover:text-white'); ?>">
                    <span class="text-xl flex-shrink-0">📖</span>
                    <span x-show="sidebarOpen" x-transition>Artikel</span>
                </a>
                <a href="<?php echo e(route('admin.scans.index')); ?>"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all text-base font-medium
                          <?php echo e(request()->routeIs('admin.scans.*') ? 'bg-leaf-600/20 text-leaf-400' : 'text-earth-400 hover:bg-earth-700 hover:text-white'); ?>">
                    <span class="text-xl flex-shrink-0">🧪</span>
                    <span x-show="sidebarOpen" x-transition>Data Pupuk</span>
                </a>
                <a href="<?php echo e(route('admin.users.index')); ?>"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all text-base font-medium
                          <?php echo e(request()->routeIs('admin.users.*') ? 'bg-leaf-600/20 text-leaf-400' : 'text-earth-400 hover:bg-earth-700 hover:text-white'); ?>">
                    <span class="text-xl flex-shrink-0">👥</span>
                    <span x-show="sidebarOpen" x-transition>Users</span>
                </a>

                <hr class="border-earth-700 my-3">

                <a href="<?php echo e(route('home')); ?>"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all text-base font-medium text-earth-400 hover:bg-earth-700 hover:text-white">
                    <span class="text-xl flex-shrink-0">🌐</span>
                    <span x-show="sidebarOpen" x-transition>Lihat Website</span>
                </a>
            </nav>

            
            <div class="px-3 py-4 border-t border-earth-700">
                <div class="flex items-center gap-3 px-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-leaf-400 to-leaf-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                    </div>
                    <div x-show="sidebarOpen" x-transition class="min-w-0">
                        <p class="text-sm font-medium text-white truncate"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-xs text-earth-500 truncate">Admin</p>
                    </div>
                </div>
            </div>
        </aside>

        
        <div class="flex-1 flex flex-col min-w-0">

            
            <header class="bg-white border-b border-earth-200 px-6 py-4 flex items-center justify-between sticky top-0 z-40">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-earth-100 text-earth-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-xl font-semibold text-earth-800"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
                </div>
                <div class="flex items-center gap-3">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-sm text-earth-500 hover:text-red-600 transition-colors font-medium">
                            🚪 Keluar
                        </button>
                    </form>
                </div>
            </header>

            
            <?php if(session('success')): ?>
                <div class="mx-6 mt-4">
                    <div class="alert-success flex items-center gap-3">
                        <span class="text-xl">✅</span>
                        <span><?php echo e(session('success')); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="mx-6 mt-4">
                    <div class="alert-error flex items-center gap-3">
                        <span class="text-xl">⚠️</span>
                        <span><?php echo e(session('error')); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            
            <main class="flex-1 p-6">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

</body>
</html>
<?php /**PATH E:\Kuliah\pkm\web-edu-pocycle\pkmpm-pocycle-pnc\resources\views/admin/layouts/admin.blade.php ENDPATH**/ ?>