# 🔧 Fix MySQL Connection Error

## The Problem
`SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it`

This means MySQL is not running or not accessible.

## Quick Solution 1: Use SQLite (Recommended for Development)

### Step 1: Switch to SQLite
Edit your `.env` file:
\`\`\`env
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
\`\`\`

### Step 2: Create SQLite Database
\`\`\`bash
# Create the database file
touch database/database.sqlite

# Clear config cache
php artisan config:clear

# Run migrations
php artisan migrate:fresh --seed

# Start server
php artisan serve
\`\`\`

## Solution 2: Fix MySQL Connection

### Step 1: Check if MySQL is Running

#### Windows (XAMPP):
1. Open XAMPP Control Panel
2. Click "Start" next to MySQL
3. Make sure it shows "Running"

#### Windows (Standalone MySQL):
\`\`\`cmd
# Check if MySQL service is running
net start mysql

# Or start MySQL service
net start mysql80
\`\`\`

#### macOS:
\`\`\`bash
# Check if MySQL is running
brew services list | grep mysql

# Start MySQL
brew services start mysql

# Or if installed via MySQL installer
sudo /usr/local/mysql/support-files/mysql.server start
\`\`\`

#### Linux:
\`\`\`bash
# Check MySQL status
sudo systemctl status mysql

# Start MySQL
sudo systemctl start mysql

# Enable auto-start
sudo systemctl enable mysql
\`\`\`

### Step 2: Test MySQL Connection
\`\`\`bash
# Try connecting to MySQL
mysql -u root -p

# If successful, create database
CREATE DATABASE mabini_health_center;
EXIT;
\`\`\`

### Step 3: Update .env File
\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mabini_health_center
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
\`\`\`

### Step 4: Clear Cache and Migrate
\`\`\`bash
php artisan config:clear
php artisan migrate:fresh --seed
php artisan serve
\`\`\`

## Solution 3: Alternative Database Ports

Sometimes MySQL runs on different ports:

### Check Common Ports:
\`\`\`env
# Try port 3307
DB_PORT=3307

# Or port 8889 (MAMP)
DB_PORT=8889

# Or port 3308
DB_PORT=3308
\`\`\`

## Solution 4: XAMPP/WAMP Setup

### XAMPP:
1. Download XAMPP from https://www.apachefriends.org/
2. Install and start Apache + MySQL
3. Use these settings:
\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mabini_health_center
DB_USERNAME=root
DB_PASSWORD=
\`\`\`

### Create Database in phpMyAdmin:
1. Go to http://localhost/phpmyadmin
2. Click "New" 
3. Database name: `mabini_health_center`
4. Click "Create"

## Quick Test Commands

### Test 1: Check Laravel Database Connection
\`\`\`bash
php artisan migrate:status
\`\`\`

### Test 2: Test with Tinker
\`\`\`bash
php artisan tinker
DB::connection()->getPdo();
exit
\`\`\`

### Test 3: Check .env Configuration
\`\`\`bash
php artisan config:show database
\`\`\`

## Recommended Quick Fix (SQLite)

For fastest setup, use SQLite:

\`\`\`bash
# 1. Update .env
echo "DB_CONNECTION=sqlite" > .env.temp
echo "DB_DATABASE=" >> .env.temp
cat .env.example | grep -v "DB_" >> .env.temp
mv .env.temp .env

# 2. Add app key
php artisan key:generate

# 3. Create database
touch database/database.sqlite

# 4. Setup database
php artisan migrate:fresh --seed

# 5. Start server
php artisan serve
\`\`\`

Then go to http://localhost:8000 and login with:
- Email: admin@mabini.com
- Password: password

## Still Having Issues?

1. **Check Laravel logs**: `storage/logs/laravel.log`
2. **Check PHP version**: `php -v` (needs PHP 8.1+)
3. **Check extensions**: `php -m | grep pdo`
4. **Try different database**: Use SQLite for development

The SQLite option is the fastest and doesn't require MySQL setup!
