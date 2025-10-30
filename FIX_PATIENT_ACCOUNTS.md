# 🔧 Fix Patient Accounts Table

## The Problem
The `patient_accounts` table doesn't exist in your database.

## Quick Fix

### Step 1: Run Fresh Migrations
\`\`\`bash
php artisan migrate:fresh --seed
\`\`\`

### Step 2: Verify Tables Were Created
\`\`\`bash
php artisan tinker
\`\`\`
Then in tinker:
\`\`\`php
// Check if patient_accounts table exists
App\Models\PatientAccount::count()

// List all tables
$tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
foreach($tables as $table) { echo $table->name . "\n"; }

exit
\`\`\`

### Step 3: Start Server
\`\`\`bash
php artisan serve
\`\`\`

## Alternative: Manual Database Reset

If the above doesn't work:

### 1. Delete Database File
\`\`\`bash
rm database/database.sqlite
\`\`\`

### 2. Create New Database
\`\`\`bash
touch database/database.sqlite
\`\`\`

### 3. Run Migrations
\`\`\`bash
php artisan migrate:fresh --seed
\`\`\`

## Expected Tables After Migration:
- ✅ users
- ✅ patients  
- ✅ patient_accounts
- ✅ medicines
- ✅ queue
- ✅ medical_records
- ✅ activity_logs
- ✅ system_settings

## Test Registration:
1. Go to: http://localhost:8000/register
2. Select "Patient" 
3. Fill in the form
4. Should work without errors

## If Still Having Issues:
Run the database check:
\`\`\`bash
php check_database.php
\`\`\`

This will show you exactly what tables exist and what's missing.
