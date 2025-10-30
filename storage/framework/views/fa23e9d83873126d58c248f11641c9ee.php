<?php $__env->startSection('title', 'Medicine Inventory - Mabini Health Center'); ?>
<?php $__env->startSection('page-title', 'Medicine Inventory'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="header-actions">
        <a href="<?php echo e(route('medicines.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add Medicine
        </a>
    </div>
</div>

<div class="medicines-grid">
    <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="medicine-card status-<?php echo e(strtolower(str_replace(' ', '-', $medicine['status']))); ?>">
        <div class="medicine-header">
            <h4><?php echo e($medicine['name']); ?></h4>
            <span class="status-badge status-<?php echo e(strtolower(str_replace(' ', '-', $medicine['status']))); ?>">
                <?php echo e($medicine['status']); ?>

            </span>
        </div>
        
        <div class="medicine-details">
            <div class="detail-item">
                <i class="fas fa-boxes"></i>
                <span>Stock: <?php echo e($medicine['stock']); ?></span>
            </div>
            <div class="detail-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Expires: <?php echo e($medicine['expiry_date']); ?></span>
            </div>
        </div>

        <div class="medicine-actions">
            <button class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i>
                Restock
            </button>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/medicines/index.blade.php ENDPATH**/ ?>