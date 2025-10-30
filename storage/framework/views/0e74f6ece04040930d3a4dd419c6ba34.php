<?php $__env->startSection('title', 'Dashboard - Mabini Health Center'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-grid">
    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card patients">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($stats['patients_today']); ?></h3>
                <p>Patients Today</p>
            </div>
        </div>

        <div class="stat-card queue">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($stats['queue_waiting']); ?></h3>
                <p>In Queue</p>
            </div>
        </div>

        <div class="stat-card medicines">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($stats['medicines_low']); ?></h3>
                <p>Low Stock</p>
            </div>
        </div>

        <div class="stat-card reports">
            <div class="stat-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($stats['reports_generated']); ?></h3>
                <p>Reports Generated</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>Recent Patients</h2>
            <a href="<?php echo e(route('patients.index')); ?>" class="btn btn-primary">View All</a>
        </div>
        
        <div class="recent-patients">
            <?php $__currentLoopData = $recent_patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="patient-item">
                <div class="patient-info">
                    <h4><?php echo e($patient['name']); ?></h4>
                    <p><?php echo e($patient['time']); ?></p>
                </div>
                <div class="patient-status status-<?php echo e($patient['status']); ?>">
                    <?php echo e(ucfirst($patient['status'])); ?>

                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>Quick Actions</h2>
        </div>
        
        <div class="quick-actions">
            <a href="<?php echo e(route('patients.create')); ?>" class="action-btn">
                <i class="fas fa-user-plus"></i>
                <span>Add Patient</span>
            </a>
            <a href="<?php echo e(route('queue.add')); ?>" class="action-btn">
                <i class="fas fa-plus"></i>
                <span>Add to Queue</span>
            </a>
            <a href="<?php echo e(route('medicines.create')); ?>" class="action-btn">
                <i class="fas fa-pills"></i>
                <span>Add Medicine</span>
            </a>
            <a href="<?php echo e(route('reports.index')); ?>" class="action-btn">
                <i class="fas fa-chart-bar"></i>
                <span>Generate Report</span>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/dashboard.blade.php ENDPATH**/ ?>