<?php $__env->startSection('title', 'Add Patient - Mabini Health Center'); ?>
<?php $__env->startSection('page-title', 'Add New Patient'); ?>

<?php $__env->startSection('content'); ?>
<div class="form-container">
    <?php if($errors->any()): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <strong>Please fix the following errors:</strong>
            <ul style="margin: 0.5rem 0 0 1rem;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('patients.store')); ?>" method="POST" class="patient-form" id="patientForm">
        <?php echo csrf_field(); ?>
        
        <div class="form-section">
            <h3>Personal Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo e(old('first_name')); ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo e(old('last_name')); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="age">Age *</label>
                    <input type="number" id="age" name="age" value="<?php echo e(old('age')); ?>" min="1" max="150" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender *</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male" <?php echo e(old('gender') == 'male' ? 'selected' : ''); ?>>Male</option>
                        <option value="female" <?php echo e(old('gender') == 'female' ? 'selected' : ''); ?>>Female</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number *</label>
                <input type="tel" id="contact" name="contact" value="<?php echo e(old('contact')); ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address *</label>
                <textarea id="address" name="address" rows="3" required><?php echo e(old('address')); ?></textarea>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('patients.index')); ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save"></i>
                Save Patient
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('patientForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        console.log('Form submission started');
        
        // Disable button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        
        // Re-enable after 10 seconds as fallback
        setTimeout(function() {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Save Patient';
        }, 10000);
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/patients/create.blade.php ENDPATH**/ ?>