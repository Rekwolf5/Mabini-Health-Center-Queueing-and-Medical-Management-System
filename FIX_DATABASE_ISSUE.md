# 🔧 Fix Database Issue - Users Table Missing

## The Problem
The `users` table doesn't exist, which means migrations haven't run properly.

## Solution Steps

### Step 1: Check Current Migration Status
\`\`\`bash
php artisan migrate:status
\`\`\`

### Step 2: Reset and Run Fresh Migrations
\`\`\`bash
# This will drop all tables and recreate them
php artisan migrate:fresh

# If you get errors, try this instead:
php artisan migrate:reset
php artisan migrate
\`\`\`

### Step 3: Seed the Database
\`\`\`bash
php artisan db:seed
\`\`\`

### Step 4: Clear All Cache
\`\`\`bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
\`\`\`

### Step 5: Start Server
\`\`\`bash
php artisan serve
\`\`\`

## If Still Having Issues

### Manual Database Check
1. **Check if database exists:**
   \`\`\`sql
   mysql -u root -p
   SHOW DATABASES;
   USE mabini_health_center;
   SHOW TABLES;
   \`\`\`

2. **If database is empty, run:**
   \`\`\`bash
   php artisan migrate:fresh --seed
   \`\`\`

### Check .env Configuration
Make sure your `.env` file has:
\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mabini_health_center
DB_USERNAME=root
DB_PASSWORD=your_password_here
SESSION_DRIVER=file
\`\`\`

## Quick One-Command Fix
\`\`\`bash
php artisan migrate:fresh --seed && php artisan config:clear && php artisan serve
\`\`\`

This will:
1. ✅ Drop all tables
2. ✅ Create all tables fresh
3. ✅ Add sample data
4. ✅ Clear config cache
5. ✅ Start the server
