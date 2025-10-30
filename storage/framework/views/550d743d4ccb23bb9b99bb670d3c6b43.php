<?php $__env->startSection('title', 'Add Medicine - Mabini Health Center'); ?>
<?php $__env->startSection('page-title', 'Add New Medicine'); ?>

<?php $__env->startSection('content'); ?>
<div class="form-container">
    <?php if($errors->any()): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 0; padding-left: 1rem;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('medicines.store')); ?>" method="POST" class="medicine-form">
        <?php echo csrf_field(); ?>
        
        <div class="form-section">
            <h3>Medicine Information</h3>
            
            <div class="form-group">
                <label for="name">Medicine Name *</label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="dosage">Dosage *</label>
                    <input type="text" id="dosage" name="dosage" value="<?php echo e(old('dosage')); ?>" placeholder="e.g., 500mg" required>
                </div>
                <div class="form-group">
                    <label for="type">Type *</label>
                    <select id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="Tablet" <?php echo e(old('type') == 'Tablet' ? 'selected' : ''); ?>>Tablet</option>
                        <option value="Capsule" <?php echo e(old('type') == 'Capsule' ? 'selected' : ''); ?>>Capsule</option>
                        <option value="Syrup" <?php echo e(old('type') == 'Syrup' ? 'selected' : ''); ?>>Syrup</option>
                        <option value="Injection" <?php echo e(old('type') == 'Injection' ? 'selected' : ''); ?>>Injection</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="stock">Initial Stock *</label>
                    <input type="number" id="stock" name="stock" value="<?php echo e(old('stock')); ?>" min="0" required>
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date *</label>
                    <input type="date" id="expiry_date" name="expiry_date" value="<?php echo e(old('expiry_date')); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description (Optional)</label>
                <textarea id="description" name="description" rows="3"><?php echo e(old('description')); ?></textarea>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('medicines.index')); ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Save Medicine
            </button>
        </div>
    </form>
</div>

<script>
// Debug form submission
document.querySelector('.medicine-form').addEventListener('submit', function(e) {
    console.log('Medicine form submitted');
    console.log('Form data:', new FormData(this));
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/medicines/create.blade.php ENDPATH**/ ?>