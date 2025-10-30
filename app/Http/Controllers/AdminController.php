<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PatientAccount;
use App\Models\Queue;
use App\Models\Medicine;
use App\Models\ActivityLog;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        // Remove the middleware calls from constructor
        // These will be handled in routes instead
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_patients' => PatientAccount::count(),
            'active_queue' => Queue::whereIn('status', ['Waiting', 'Consulting'])->count(),
            'low_stock_medicines' => Medicine::where('stock', '<=', 25)->count(),
        ];

        $recentActivity = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentActivity'));
    }

    public function userManagement()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.user-management', compact('users'));
    }

    public function createUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,staff',
            'phone' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
        ]);

        ActivityLog::log('user_create', "Created new user: {$user->name} ({$user->role})", [
            'user_id' => $user->id,
            'role' => $user->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,staff',
            'phone' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($request->only(['name', 'email', 'role', 'phone', 'status']));

        ActivityLog::log('user_update', "Updated user: {$user->name}", [
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $user->delete();

        ActivityLog::log('user_delete', "Deleted user: {$userName}", [
            'deleted_user_id' => $id,
        ]);

        return back()->with('success', 'User deleted successfully!');
    }

    public function queueMonitor()
    {
        $queue = Queue::with('patient')
            ->whereDate('created_at', today())
            ->orderBy('arrived_at', 'asc')
            ->get()
            ->sortBy(function ($item) {
                $priorities = ['Emergency' => 1, 'Urgent' => 2, 'Normal' => 3];
                return $priorities[$item->priority] ?? 4;
            })
            ->values();

        return view('admin.queue-monitor', compact('queue'));
    }

    public function medicineManagement()
    {
        $medicines = Medicine::orderBy('name')->paginate(15);
        return view('admin.medicine-management', compact('medicines'));
    }

    public function approveMedicineChange(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'stock_change' => 'required|integer',
            'reason' => 'required|string|max:255',
        ]);

        $medicine = Medicine::findOrFail($id);
        
        if ($request->action === 'approve') {
            $oldStock = $medicine->stock;
            $newStock = $oldStock + $request->stock_change;
            
            if ($newStock < 0) {
                return back()->with('error', 'Stock cannot be negative.');
            }
            
            $medicine->update(['stock' => $newStock]);
            
            ActivityLog::log('medicine_admin_approve', "Admin approved stock change for {$medicine->name}", [
                'medicine_id' => $medicine->id,
                'old_stock' => $oldStock,
                'new_stock' => $newStock,
                'change' => $request->stock_change,
                'reason' => $request->reason,
            ]);
            
            return back()->with('success', 'Medicine stock change approved.');
        }

        ActivityLog::log('medicine_admin_reject', "Admin rejected stock change for {$medicine->name}", [
            'medicine_id' => $medicine->id,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Medicine stock change rejected.');
    }

    public function activityLogs()
    {
        $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(50);
        return view('admin.activity-logs', compact('logs'));
    }

    public function systemSettings()
    {
        $settings = SystemSetting::orderBy('key')->get();
        return view('admin.system-settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            SystemSetting::set($key, $value);
        }

        ActivityLog::log('settings_update', 'Updated system settings', $request->settings);

        return back()->with('success', 'Settings updated successfully!');
    }

    public function backupData()
    {
        try {
            $timestamp = now()->format('Y-m-d_H-i-s');
            $filename = "backup_{$timestamp}.sql";
            
            // For SQLite, copy the database file
            if (config('database.default') === 'sqlite') {
                $dbPath = database_path('database.sqlite');
                $backupPath = storage_path("app/backups/{$filename}");
                
                if (!Storage::disk('local')->exists('backups')) {
                    Storage::disk('local')->makeDirectory('backups');
                }
                
                copy($dbPath, $backupPath);
            }

            ActivityLog::log('backup_create', "Created database backup: {$filename}");

            return response()->download($backupPath)->deleteFileAfterSend();
        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function restoreData(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,sqlite',
        ]);

        try {
            $file = $request->file('backup_file');
            $timestamp = now()->format('Y-m-d_H-i-s');
            
            // Create backup of current database first
            $this->backupData();
            
            // For SQLite, replace the database file
            if (config('database.default') === 'sqlite') {
                $dbPath = database_path('database.sqlite');
                $file->move(dirname($dbPath), 'database.sqlite');
            }

            ActivityLog::log('backup_restore', "Restored database from backup file");

            return back()->with('success', 'Database restored successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Restore failed: ' . $e->getMessage());
        }
    }
}
