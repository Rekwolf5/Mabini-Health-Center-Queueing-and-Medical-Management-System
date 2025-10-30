<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Mabini Health Center'); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Health Center System</h2>
            </div>
            
            <ul class="sidebar-menu">
                <li class="<?php echo e(request()->routeIs('staff.dashboard') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('staff.dashboard')); ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?php echo e(request()->routeIs('patients.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('patients.index')); ?>">
                        <i class="fas fa-user-injured"></i>
                        <span>Patients</span>
                    </a>
                </li>
                <li class="<?php echo e(request()->routeIs('queue.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('queue.index')); ?>">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Queue</span>
                    </a>
                </li>
                <li class="<?php echo e(request()->routeIs('medicines.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('medicines.index')); ?>">
                        <i class="fas fa-capsules"></i>
                        <span>Medicines</span>
                    </a>
                </li>
                <li class="<?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('reports.index')); ?>">
                        <i class="fas fa-file-medical-alt"></i>
                        <span>Reports</span>
                    </a>
                </li>
                
                <?php if(Auth::user()->role === 'staff' || Auth::user()->role === 'admin'): ?>
                <li class="<?php echo e(request()->routeIs('staff.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('staff.queue.management')); ?>">
                        <i class="fas fa-tasks"></i>
                        <span>Staff Tools</span>
                    </a>
                </li>
                <?php endif; ?>
                
                <?php if(Auth::user()->role === 'admin'): ?>
                <li class="<?php echo e(request()->routeIs('admin.*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="fas fa-cog"></i>
                        <span>Admin Panel</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <h1><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <i class="fas fa-user-md"></i>
                        <span><?php echo e(Auth::user()->name); ?></span>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="content">
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/layouts/app.blade.php ENDPATH**/ ?>