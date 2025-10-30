# 🧹 Clean Database Setup

## Step 1: Clean Existing Migrations

If you have migration conflicts, clean them up:

\`\`\`bash
# Reset all migrations (this will delete all data!)
php artisan migrate:reset

# Or if you want to start fresh:
php artisan migrate:fresh
\`\`\`

## Step 2: Remove Unnecessary Migration Files

Delete these files from `database/migrations/` folder if they exist:
- Any file with `create_jobs_table`
- Any file with `create_cache_table` 
- Any duplicate `create_users_table` files
- Any file with `create_projects_table`

Keep only these migration files:
- `0001_01_01_000000_create_users_table.php` (the original Laravel one)
- `2024_01_01_000002_create_patients_table.php`
- `2024_01_01_000003_create_medicines_table.php`
- `2024_01_01_000004_create_queue_table.php`
- `2024_01_01_000005_create_medical_records_table.php`

## Step 3: Run Clean Migration

\`\`\`bash
# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Start server
php artisan serve
\`\`\`

## Alternative: Fresh Start

If you want to completely start over:

\`\`\`bash
# Drop all tables and recreate
php artisan migrate:fresh --seed

# This will:
# 1. Drop all existing tables
# 2. Run all migrations from scratch
# 3. Seed the database with sample data
\`\`\`
\`\`\`

## 🗑️ **Manual Cleanup Instructions:**

1. **Delete these migration files** from your `database/migrations/` folder:
   - Any file containing `create_jobs_table`
   - Any file containing `create_cache_table`
   - Any file containing `create_projects_table`
   - The duplicate `2024_01_01_000001_create_users_table.php`

2. **Keep only the original Laravel users migration** and our health center migrations

3. **Run this command to start fresh:**
\`\`\`bash
php artisan migrate:fresh --seed
\`\`\`

This will:
- ✅ Drop all existing tables
- ✅ Run only the necessary migrations
- ✅ Seed with sample data
- ✅ Remove all conflicts

The `create_jobs_table` migration is for Laravel's job queue system (background tasks), but we don't need it for this health center system, so it's safe to remove it.

Try running `php artisan migrate:fresh --seed` and it should work perfectly! 🌟
