<?php $__env->startSection('title', 'Notifikasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

    
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="mb-2">🔔 Notifikasi</h1>
            <p class="text-earth-500 text-lg">
                <?php if($unreadCount > 0): ?>
                    Anda memiliki <span class="font-bold text-leaf-700"><?php echo e($unreadCount); ?></span> notifikasi belum dibaca
                <?php else: ?>
                    Semua notifikasi sudah dibaca
                <?php endif; ?>
            </p>
        </div>
        <?php if($unreadCount > 0): ?>
            <form method="POST" action="<?php echo e(route('notifications.readAll')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-outline-leaf btn-sm">
                    ✅ Tandai Semua Dibaca
                </button>
            </form>
        <?php endif; ?>
    </div>

    <?php if($notifications->isEmpty()): ?>
        
        <div class="card card-body text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-earth-100 rounded-full flex items-center justify-center">
                <span class="text-5xl">🔔</span>
            </div>
            <h3 class="text-earth-600 mb-3">Belum Ada Notifikasi</h3>
            <p class="text-earth-400 text-lg">Anda akan mendapat reminder berkala untuk mengecek pupuk.</p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card <?php echo e($notification->read_at ? 'opacity-75' : 'border-leaf-300 bg-leaf-50/30'); ?>">
                    <div class="card-body">
                        <div class="flex items-start gap-4">
                            
                            <div class="w-12 h-12 <?php echo e($notification->read_at ? 'bg-earth-100' : 'bg-leaf-100'); ?> rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-2xl"><?php echo e($notification->data['title'] ? '🌿' : '🔔'); ?></span>
                            </div>

                            
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold <?php echo e($notification->read_at ? 'text-earth-600' : 'text-earth-800'); ?>">
                                    <?php echo e($notification->data['title'] ?? 'Notifikasi'); ?>

                                </h3>
                                <p class="text-earth-600 text-base mt-1">
                                    <?php echo e($notification->data['message'] ?? ''); ?>

                                </p>
                                <p class="text-earth-400 text-sm mt-2">
                                    <?php echo e($notification->created_at->diffForHumans()); ?>

                                </p>
                            </div>

                            
                            <?php if(!$notification->read_at): ?>
                                <form method="POST" action="<?php echo e(route('notifications.read', $notification->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn-primary btn-sm" title="Tandai dibaca & buka scan">
                                        <?php echo e($notification->data['action_text'] ?? 'Lihat'); ?>

                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="mt-8">
            <?php echo e($notifications->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ilham/web-edu-pkm/resources/views/notifications/index.blade.php ENDPATH**/ ?>