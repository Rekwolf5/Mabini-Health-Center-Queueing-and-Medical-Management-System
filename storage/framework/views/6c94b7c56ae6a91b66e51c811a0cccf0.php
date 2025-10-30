<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mabini Health Center</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Create Account</h1>
                <p>Register as Patient, Staff, or Admin</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="error-message">
                    <ul style="margin: 0; padding-left: 1rem;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register')); ?>" class="login-form">
                <?php echo csrf_field(); ?>
                
                <!-- Role Selection -->
                <div class="form-group">
                    <label for="role">Register as *</label>
                    <select id="role" name="role" required onchange="toggleFields()">
                        <option value="">Select Role</option>
                        <option value="patient" <?php echo e(old('role') == 'patient' ? 'selected' : ''); ?>>Patient</option>
                        <option value="staff" <?php echo e(old('role') == 'staff' ? 'selected' : ''); ?>>Staff</option>
                        <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                    </select>
                </div>

                <!-- Basic Information -->
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <!-- Patient-specific fields -->
                <div id="patient-fields" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo e(old('first_name')); ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo e(old('last_name')); ?>">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" id="age" name="age" value="<?php echo e(old('age')); ?>" min="1" max="150">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" <?php echo e(old('gender') == 'male' ? 'selected' : ''); ?>>Male</option>
                                <option value="female" <?php echo e(old('gender') == 'female' ? 'selected' : ''); ?>>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact Number</label>
                        <input type="tel" id="contact" name="contact" value="<?php echo e(old('contact')); ?>">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3"><?php echo e(old('address')); ?></textarea>
                    </div>
                </div>

                <!-- Staff/Admin fields -->
                <div id="staff-fields" style="display: none;">
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo e(old('phone')); ?>">
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-user-plus"></i>
                    Create Account
                </button>
            </form>

            <div style="text-align: center; margin-top: 1.5rem;">
                <p style="color: #718096;">
                    Already have an account? 
                    <a href="<?php echo e(route('login')); ?>" style="color: #48bb78; text-decoration: none;">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
    function toggleFields() {
        const role = document.getElementById('role').value;
        const patientFields = document.getElementById('patient-fields');
        const staffFields = document.getElementById('staff-fields');
        
        // Hide all fields first
        patientFields.style.display = 'none';
        staffFields.style.display = 'none';
        
        // Show relevant fields based on role
        if (role === 'patient') {
            patientFields.style.display = 'block';
            // Make patient fields required
            document.getElementById('first_name').required = true;
            document.getElementById('last_name').required = true;
            document.getElementById('age').required = true;
            document.getElementById('gender').required = true;
            document.getElementById('contact').required = true;
            document.getElementById('address').required = true;
        } else if (role === 'staff' || role === 'admin') {
            staffFields.style.display = 'block';
            // Remove patient field requirements
            document.getElementById('first_name').required = false;
            document.getElementById('last_name').required = false;
            document.getElementById('age').required = false;
            document.getElementById('gender').required = false;
            document.getElementById('contact').required = false;
            document.getElementById('address').required = false;
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleFields();
    });
    </script>
</body>
</html>
<?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/auth/register.blade.php ENDPATH**/ ?>