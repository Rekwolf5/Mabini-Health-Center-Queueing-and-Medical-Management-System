<?php $__env->startSection('title', 'Queue Management - Mabini Health Center'); ?>
<?php $__env->startSection('page-title', 'Queue Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="header-actions">
        <a href="<?php echo e(route('queue.add')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add to Queue
        </a>
    </div>
</div>

<?php if($queue->count() > 0): ?>
<div class="queue-container">
    <?php $__currentLoopData = $queue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="queue-item priority-<?php echo e(strtolower($item->priority)); ?> status-<?php echo e(strtolower($item->status)); ?>">
        <div class="queue-number">
            <?php echo e($item->queue_number); ?>

        </div>
        <div class="queue-info">
            <h4><?php echo e($item->patient->full_name); ?></h4>
            <p>Arrived: <?php echo e($item->arrived_at->format('h:i A')); ?></p>
            <p>Service: <?php echo e($item->service_type); ?></p>
            <span class="priority-badge priority-<?php echo e(strtolower($item->priority)); ?>">
                <?php echo e($item->priority); ?>

            </span>
            <?php if($item->notes): ?>
                <p><small>Notes: <?php echo e($item->notes); ?></small></p>
            <?php endif; ?>
        </div>
        <div class="queue-status">
            <span class="status-badge status-<?php echo e(strtolower($item->status)); ?>">
                <?php echo e($item->status); ?>

            </span>
            <?php if($item->status === 'Waiting'): ?>
                <p><small>Waiting: <?php echo e($item->arrived_at->diffForHumans()); ?></small></p>
            <?php elseif($item->status === 'Consulting'): ?>
                <p><small>Started: <?php echo e($item->started_at->diffForHumans()); ?></small></p>
            <?php elseif($item->status === 'Completed'): ?>
                <p><small>Completed: <?php echo e($item->completed_at->diffForHumans()); ?></small></p>
            <?php endif; ?>
        </div>
        <div class="queue-actions">
            <?php if($item->status === 'Waiting'): ?>
            <form method="POST" action="<?php echo e(route('queue.updateStatus', $item->id)); ?>" style="display: inline;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="status" value="Consulting">
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="fas fa-play"></i>
                    Start
                </button>
            </form>
            <?php endif; ?>
            <?php if($item->status === 'Consulting'): ?>
            <form method="POST" action="<?php echo e(route('queue.updateStatus', $item->id)); ?>" style="display: inline;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="status" value="Completed">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-check"></i>
                    Complete
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php else: ?>
<div class="dashboard-section">
    <div style="text-align: center; padding: 3rem; color: #6b7280;">
        <i class="fas fa-clipboard-list" style="font-size: 3rem; margin-bottom: 1rem; color: #d1d5db;"></i>
        <h3 style="margin-bottom: 0.5rem;">No patients in queue today</h3>
        <p>Add the first patient to get started.</p>
        <a href="<?php echo e(route('queue.add')); ?>" class="btn btn-primary" style="margin-top: 1rem;">
            <i class="fas fa-plus"></i>
            Add Patient to Queue
        </a>
    </div>
</div>
<?php endif; ?>

<style>
.queue-container {
    display: grid;
    gap: 1rem;
}

.queue-item {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    display: grid;
    grid-template-columns: 80px 1fr auto auto;
    gap: 1rem;
    align-items: center;
    transition: all 0.2s ease;
}

.queue-item:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.queue-item.priority-emergency {
    border-left: 4px solid #dc2626;
}

.queue-item.priority-urgent {
    border-left: 4px solid #f59e0b;
}

.queue-item.priority-normal {
    border-left: 4px solid #059669;
}

.queue-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: #1f2937;
    text-align: center;
    background: #f9fafb;
    border-radius: 6px;
    padding: 0.5rem;
}

.queue-info h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.queue-info p {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.priority-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.priority-badge.priority-emergency {
    background: #fef2f2;
    color: #dc2626;
}

.priority-badge.priority-urgent {
    background: #fffbeb;
    color: #f59e0b;
}

.priority-badge.priority-normal {
    background: #ecfdf5;
    color: #059669;
}

.status-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-badge.status-waiting {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.status-consulting {
    background: #dbeafe;
    color: #1e40af;
}

.status-badge.status-completed {
    background: #d1fae5;
    color: #065f46;
}

.queue-actions {
    display: flex;
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .queue-item {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .queue-number {
        font-size: 1.25rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/queue/index.blade.php ENDPATH**/ ?>