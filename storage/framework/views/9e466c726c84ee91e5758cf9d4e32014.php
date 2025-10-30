<?php $__env->startSection('title', 'Reports - Mabini Health Center'); ?>
<?php $__env->startSection('page-title', 'Reports & Analytics'); ?>

<?php $__env->startSection('content'); ?>
<div class="reports-container">
    <!-- Report Stats -->
    <div class="stats-row">
        <div class="stat-card patients">
            <div class="stat-icon">
                <i class="fas fa-user-injured"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($reportStats['total_patients']); ?></h3>
                <p>Total Patients</p>
            </div>
        </div>

        <div class="stat-card consultations">
            <div class="stat-icon">
                <i class="fas fa-stethoscope"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($reportStats['consultations_today']); ?></h3>
                <p>Consultations Today</p>
            </div>
        </div>

        <div class="stat-card medicines">
            <div class="stat-icon">
                <i class="fas fa-capsules"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($reportStats['medicines_dispensed']); ?></h3>
                <p>Medicines Dispensed</p>
            </div>
        </div>

        <div class="stat-card queue">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo e($reportStats['queue_average_wait']); ?></h3>
                <p>Avg Wait Time</p>
            </div>
        </div>
    </div>

    <!-- Report Categories -->
    <div class="reports-grid">
        <div class="report-category">
            <div class="category-header">
                <i class="fas fa-user-injured"></i>
                <h3>Patient Reports</h3>
            </div>
            <div class="category-content">
                <p>Generate patient statistics, demographics, and medical history reports.</p>
                <div class="category-actions">
                    <a href="<?php echo e(route('reports.patients')); ?>" class="btn btn-primary">
                        <i class="fas fa-eye"></i>
                        View Details
                    </a>
                    <button class="btn btn-secondary" onclick="generateReport('patients')">
                        <i class="fas fa-download"></i>
                        Generate
                    </button>
                </div>
            </div>
        </div>

        <div class="report-category">
            <div class="category-header">
                <i class="fas fa-clipboard-list"></i>
                <h3>Queue Reports</h3>
            </div>
            <div class="category-content">
                <p>Analyze queue performance, wait times, and service efficiency metrics.</p>
                <div class="category-actions">
                    <a href="<?php echo e(route('reports.queue')); ?>" class="btn btn-primary">
                        <i class="fas fa-eye"></i>
                        View Details
                    </a>
                    <button class="btn btn-secondary" onclick="generateReport('queue')">
                        <i class="fas fa-download"></i>
                        Generate
                    </button>
                </div>
            </div>
        </div>

        <div class="report-category">
            <div class="category-header">
                <i class="fas fa-capsules"></i>
                <h3>Medicine Reports</h3>
            </div>
            <div class="category-content">
                <p>Track inventory levels, expiry dates, and medicine dispensing patterns.</p>
                <div class="category-actions">
                    <a href="<?php echo e(route('reports.medicines')); ?>" class="btn btn-primary">
                        <i class="fas fa-eye"></i>
                        View Details
                    </a>
                    <button class="btn btn-secondary" onclick="generateReport('medicines')">
                        <i class="fas fa-download"></i>
                        Generate
                    </button>
                </div>
            </div>
        </div>

        <div class="report-category">
            <div class="category-header">
                <i class="fas fa-calendar-day"></i>
                <h3>Daily Summary</h3>
            </div>
            <div class="category-content">
                <p>Complete daily operations summary including all activities and statistics.</p>
                <div class="category-actions">
                    <button class="btn btn-primary" onclick="generateReport('daily')">
                        <i class="fas fa-download"></i>
                        Generate Today
                    </button>
                    <button class="btn btn-secondary" onclick="generateReport('weekly')">
                        <i class="fas fa-download"></i>
                        Weekly
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reports Section - Only show if there are reports -->
    <?php if(count($recentReports) > 0): ?>
    <div class="dashboard-section">
        <div class="section-header">
            <h2>Recent Reports</h2>
        </div>
        
        <div class="reports-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Report Title</th>
                        <th>Type</th>
                        <th>Date Generated</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recentReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($report['title']); ?></td>
                        <td>
                            <span class="type-badge type-<?php echo e(strtolower($report['type'])); ?>">
                                <?php echo e($report['type']); ?>

                            </span>
                        </td>
                        <td><?php echo e($report['date']); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo e(strtolower($report['status'])); ?>">
                                <?php echo e($report['status']); ?>

                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="dashboard-section">
        <div class="section-header">
            <h2>Recent Reports</h2>
        </div>
        <p style="color: #6b7280; text-align: center; padding: 2rem;">
            No reports generated yet. Start by generating your first report above.
        </p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ramir\Desktop\Health-Center-Queue-System-main\resources\views/reports/index.blade.php ENDPATH**/ ?>