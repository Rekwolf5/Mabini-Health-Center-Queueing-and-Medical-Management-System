<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientAuthController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;

// Default redirect
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('staff.dashboard');
    }
    return redirect()->route('patient.login');
});

// Patient Authentication Routes
Route::prefix('patient')->name('patient.')->group(function () {
    // Guest routes (not authenticated)
    Route::middleware('guest:patient')->group(function () {
        Route::get('/login', [PatientAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [PatientAuthController::class, 'login']);
        Route::get('/register', [PatientAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [PatientAuthController::class, 'register']);
    });
    
    Route::post('/logout', [PatientAuthController::class, 'logout'])->name('logout');
    
    // Protected Patient Routes (authenticated)
    Route::middleware('auth:patient')->group(function () {
        Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [PatientDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [PatientDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::get('/medical-history', [PatientDashboardController::class, 'medicalHistory'])->name('medical-history');
    });
});

// Staff/Admin Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Staff/Admin Routes
Route::middleware('auth')->group(function () {
    // Main dashboard route for staff/admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');

    // Patient Management (All authenticated users)
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/', [PatientController::class, 'index'])->name('index');
        Route::get('/create', [PatientController::class, 'create'])->name('create');
        Route::post('/', [PatientController::class, 'store'])->name('store');
        Route::get('/{id}', [PatientController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PatientController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PatientController::class, 'update'])->name('update');
        Route::delete('/{id}', [PatientController::class, 'destroy'])->name('destroy');
    });

    // Queue Management (All authenticated users)
    Route::prefix('queue')->name('queue.')->group(function () {
        Route::get('/', [QueueController::class, 'index'])->name('index');
        Route::get('/add', [QueueController::class, 'add'])->name('add');
        Route::post('/', [QueueController::class, 'store'])->name('store');
        Route::patch('/{id}/status', [QueueController::class, 'updateStatus'])->name('updateStatus');
    });

    // Medicine Management (All authenticated users)
    Route::prefix('medicines')->name('medicines.')->group(function () {
        Route::get('/', [MedicineController::class, 'index'])->name('index');
        Route::get('/create', [MedicineController::class, 'create'])->name('create');
        Route::post('/', [MedicineController::class, 'store'])->name('store');
        Route::get('/{id}', [MedicineController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MedicineController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MedicineController::class, 'update'])->name('update');
        Route::delete('/{id}', [MedicineController::class, 'destroy'])->name('destroy');
    });

    // Reports (All authenticated users)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/patients', [ReportsController::class, 'patients'])->name('patients');
        Route::get('/queue', [ReportsController::class, 'queue'])->name('queue');
        Route::get('/medicines', [ReportsController::class, 'medicines'])->name('medicines');
        Route::post('/generate', [ReportsController::class, 'generate'])->name('generate');
    });

    // Staff Routes (Staff + Admin only)
    Route::prefix('staff')->name('staff.')->middleware('role:staff,admin')->group(function () {
        Route::get('/queue-management', [StaffController::class, 'queueManagement'])->name('queue.management');
        Route::post('/queue/{id}/call-next', [StaffController::class, 'callNext'])->name('queue.call-next');
        Route::post('/queue/{id}/mark-served', [StaffController::class, 'markServed'])->name('queue.mark-served');
        Route::post('/queue/{id}/mark-no-show', [StaffController::class, 'markNoShow'])->name('queue.mark-no-show');
        Route::get('/patient/{id}/history', [StaffController::class, 'patientHistory'])->name('patient.history');
        Route::get('/print-queue', [StaffController::class, 'printQueueList'])->name('print.queue');
        Route::get('/medicine-inventory', [StaffController::class, 'medicineInventory'])->name('medicine.inventory');
        Route::post('/medicine/{id}/update-stock', [StaffController::class, 'updateMedicineStock'])->name('medicine.update-stock');
    });

    // Admin Routes (Admin only)
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // User Management
        Route::get('/users', [AdminController::class, 'userManagement'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
        
        // Queue Monitor
        Route::get('/queue-monitor', [AdminController::class, 'queueMonitor'])->name('queue.monitor');
        
        // Medicine Management
        Route::get('/medicine-management', [AdminController::class, 'medicineManagement'])->name('medicine.management');
        Route::post('/medicine/{id}/approve-change', [AdminController::class, 'approveMedicineChange'])->name('medicine.approve-change');
        
        // System Management
        Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('activity.logs');
        Route::get('/system-settings', [AdminController::class, 'systemSettings'])->name('system.settings');
        Route::post('/system-settings', [AdminController::class, 'updateSettings'])->name('system.settings.update');
        
        // Backup & Restore
        Route::get('/backup', [AdminController::class, 'backupData'])->name('backup');
        Route::post('/restore', [AdminController::class, 'restoreData'])->name('restore');
    });
});
