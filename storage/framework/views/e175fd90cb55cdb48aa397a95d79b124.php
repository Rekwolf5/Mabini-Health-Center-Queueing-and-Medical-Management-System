<?php $__env->startSection('title', 'Patient Details - Mabini Health Center'); ?>
<?php $__env->startSection('page-title', 'Patient Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="patient-profile">
    <div class="profile-header">
        <div class="patient-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="patient-basic-info">
            <h2><?php echo e($patient->full_name); ?></h2>
            <p>Age: <?php echo e($patient->age); ?> | Gender: <?php echo e(ucfirst($patient->gender)); ?></p>
            <p>Contact: <?php echo e($patient->contact); ?></p>
            <p>Address: <?php echo e($patient->address); ?></p>
        </div>
        <div class="profile-actions">
            <a href="<?php echo e(route('patients.edit', $patient->id)); ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Patient
            </a>
        </div>
    </div>

    <div class="profile-content">
        <div class="medical-history">
            <h3>Medical History</h3>
            <?php if($patient->medicalRecords->count() > 0): ?>
                <div class="history-timeline">
                    <?php $__currentLoopData = $patient->medicalRecords->sortByDesc('visit_date'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="history-item">
                        <div class="history-date"><?php echo e($record->visit_date->format('M d, Y')); ?></div>
                        <div class="history-details">
                            <h4><?php echo e($record->diagnosis); ?></h4>
                            <p><?php echo e($record->treatment); ?></p>
                            <?php if($record->notes): ?>
                                <p><strong>Notes:</strong> <?php echo e($record->notes); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p style="color: #718096; text-align: center; padding: 2rem;">
                    No medical records found for this patient.
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/patients/show.blade.php ENDPATH**/ ?>