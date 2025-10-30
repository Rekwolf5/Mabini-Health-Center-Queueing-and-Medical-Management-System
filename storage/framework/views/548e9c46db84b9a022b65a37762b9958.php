<?php $__env->startSection('title', 'Patients - Mabini Health Center'); ?>
<?php $__env->startSection('page-title', 'Patients'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="header-actions">
        <a href="<?php echo e(route('patients.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add New Patient
        </a>
    </div>
</div>

<div class="data-table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div class="patient-name">
                        <i class="fas fa-user-circle"></i>
                        <?php echo e($patient->full_name); ?>

                    </div>
                </td>
                <td><?php echo e($patient->age); ?></td>
                <td><?php echo e(ucfirst($patient->gender)); ?></td>
                <td><?php echo e($patient->contact); ?></td>
                <td><?php echo e($patient->address); ?></td>
                <td><?php echo e($patient->created_at->format('M d, Y')); ?></td>
                <td>
                    <div class="action-buttons">
                        <a href="<?php echo e(route('patients.show', $patient->id)); ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?php echo e(route('patients.edit', $patient->id)); ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="<?php echo e(route('patients.destroy', $patient->id)); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align: center; padding: 2rem; color: #718096;">
                    No patients found. <a href="<?php echo e(route('patients.create')); ?>">Add the first patient</a>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if($patients->hasPages()): ?>
<div style="margin-top: 2rem;">
    <?php echo e($patients->links()); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/patients/index.blade.php ENDPATH**/ ?>