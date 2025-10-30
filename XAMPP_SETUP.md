# 🔧 XAMPP Setup Guide

## Download and Install XAMPP

1. **Download XAMPP**
   - Go to: https://www.apachefriends.org/
   - Download for your operating system
   - Install with default settings

2. **Start Services**
   - Open XAMPP Control Panel
   - Click "Start" for Apache
   - Click "Start" for MySQL
   - Both should show "Running" in green

## Create Database

1. **Open phpMyAdmin**
   - Go to: http://localhost/phpmyadmin
   - Click "New" on the left sidebar
   - Database name: `mabini_health_center`
   - Click "Create"

## Configure Laravel

1. **Update .env file:**
\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mabini_health_center
DB_USERNAME=root
DB_PASSWORD=
\`\`\`

2. **Run setup commands:**
\`\`\`bash
php artisan config:clear
php artisan migrate:fresh --seed
php artisan serve
\`\`\`

## Troubleshooting XAMPP

### MySQL Won't Start:
1. Check if port 3306 is in use
2. Change MySQL port in XAMPP config
3. Restart XAMPP as Administrator

### Still Having Issues:
Use SQLite instead (no XAMPP required):
\`\`\`bash
# Run the quick fix script
bash quick_fix.sh
\`\`\`

This will switch you to SQLite automatically!
