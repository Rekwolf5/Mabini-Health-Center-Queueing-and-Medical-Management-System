<?php $__env->startSection('title', 'Patient Dashboard - Mabini Health Center'); ?>
<?php $__env->startSection('page-title', 'My Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="patient-dashboard">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h2>Welcome, <?php echo e($patient->full_name); ?>!</h2>
        <p>Manage your health records and appointments</p>
    </div>

    <!-- Current Queue Status -->
    <?php if($currentQueue): ?>
    <div class="queue-status-card priority-<?php echo e(strtolower($currentQueue->priority)); ?>">
        <div class="queue-status-header">
            <h3>
                <i class="fas fa-clock"></i>
                Current Queue Status
            </h3>
            <span class="queue-number"><?php echo e($currentQueue->queue_number); ?></span>
        </div>
        
        <div class="queue-status-body">
            <div class="status-info">
                <span class="status-badge status-<?php echo e(strtolower($currentQueue->status)); ?>">
                    <?php echo e($currentQueue->status); ?>

                </span>
                <span class="priority-badge priority-<?php echo e(strtolower($currentQueue->priority)); ?>">
                    <?php echo e($currentQueue->priority); ?> Priority
                </span>
            </div>
            
            <?php if($currentQueue->status === 'Waiting' && $queuePosition): ?>
                <p><strong>Your position in queue: #<?php echo e($queuePosition); ?></strong></p>
                <p>Estimated wait time: <?php echo e($queuePosition * 15); ?> minutes</p>
            <?php elseif($currentQueue->status === 'Consulting'): ?>
                <p><strong>You are currently being consulted</strong></p>
                <p>Please proceed to the consultation room</p>
            <?php endif; ?>
            
            <p>Service: <?php echo e($currentQueue->service_type); ?></p>
            <p>Arrived: <?php echo e($currentQueue->arrived_at->format('h:i A')); ?></p>
        </div>
    </div>
    <?php else: ?>
    <div class="no-queue-card">
        <i class="fas fa-calendar-plus"></i>
        <h3>No Active Queue</h3>
        <p>You don't have any active queue today. Visit the health center to join the queue.</p>
    </div>
    <?php endif; ?>

    <!-- Quick Stats -->
    <div class="patient-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-file-medical"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($recentHistory->count()); ?></h3>
                <p>Medical Records</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($upcomingAppointments->count()); ?></h3>
                <p>Upcoming Visits</p>
            </div>
        </div>
    </div>

    <!-- Recent Medical History -->
    <?php if($recentHistory->count() > 0): ?>
    <div class="dashboard-section">
        <div class="section-header">
            <h3>Recent Medical History</h3>
            <a href="<?php echo e(route('patient.medical-history')); ?>" class="btn btn-primary">View All</a>
        </div>
        
        <div class="medical-history-list">
            <?php $__currentLoopData = $recentHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="history-item">
                <div class="history-date">
                    <?php echo e($record->visit_date->format('M d, Y')); ?>

                </div>
                <div class="history-details">
                    <h4><?php echo e($record->diagnosis); ?></h4>
                    <p><?php echo e($record->treatment); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.patient-dashboard {
    display: grid;
    gap: 1.5rem;
}

.welcome-section {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
    padding: 2rem;
    border-radius: 8px;
    text-align: center;
}

.welcome-section h2 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.queue-status-card {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    border-left: 4px solid #059669;
}

.queue-status-card.priority-emergency {
    border-left-color: #dc2626;
}

.queue-status-card.priority-urgent {
    border-left-color: #f59e0b;
}

.queue-status-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.queue-status-header h3 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #1f2937;
}

.queue-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: #059669;
    background: #ecfdf5;
    padding: 0.5rem 1rem;
    border-radius: 6px;
}

.status-info {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.no-queue-card {
    background: white;
    border-radius: 8px;
    padding: 3rem;
    text-align: center;
    border: 1px solid #e5e7eb;
    color: #6b7280;
}

.no-queue-card i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #d1d5db;
}

.patient-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.medical-history-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.history-item {
    background: #f9fafb;
    padding: 1rem;
    border-radius: 6px;
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.history-date {
    background: #059669;
    color: white;
    padding: 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 500;
    white-space: nowrap;
}

.history-details h4 {
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.history-details p {
    color: #6b7280;
    font-size: 0.875rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patient', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/patient/dashboard.blade.php ENDPATH**/ ?>