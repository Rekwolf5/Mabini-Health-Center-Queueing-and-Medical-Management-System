# 🔧 Troubleshooting Guide

## Common Issues & Solutions

### 1. **Database Connection Error**
\`\`\`
SQLSTATE[HY000] [2002] No connection could be made...
\`\`\`

**Solution:**
\`\`\`bash
# Make sure you're using SQLite (check .env file)
DB_CONNECTION=sqlite
DB_DATABASE=

# Create database file
touch database/database.sqlite

# Clear cache
php artisan config:clear
php artisan migrate:fresh --seed
\`\`\`

### 2. **"Class not found" Error**
**Solution:**
\`\`\`bash
composer install
composer dump-autoload
php artisan config:clear
\`\`\`

### 3. **Permission Denied Errors**
**Solution:**
\`\`\`bash
chmod 664 database/database.sqlite
chmod 775 database/
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
\`\`\`

### 4. **Migration Errors**
**Solution:**
\`\`\`bash
# Reset everything
php artisan migrate:fresh --seed

# If still failing, check database file exists
ls -la database/database.sqlite
\`\`\`

### 5. **Forms Not Saving**
**Check these:**
1. Database file exists: `database/database.sqlite`
2. Migrations ran: `php artisan migrate:status`
3. Laravel logs: `tail -f storage/logs/laravel.log`

### 6. **Login Not Working**
**Solution:**
\`\`\`bash
# Make sure admin user exists
php artisan migrate:fresh --seed

# Login with:
# Email: admin@mabini.com
# Password: password
\`\`\`

### 7. **Server Won't Start**
**Check:**
- PHP version: `php -v` (needs 8.1+)
- Port 8000 available
- Try different port: `php artisan serve --port=8080`

### 8. **Styling Issues**
**Solution:**
\`\`\`bash
# Clear view cache
php artisan view:clear

# Check CSS file exists
ls -la public/css/app.css
\`\`\`

## 🆘 Still Having Issues?

1. **Check Laravel logs:**
   \`\`\`bash
   tail -f storage/logs/laravel.log
   \`\`\`

2. **Verify setup:**
   \`\`\`bash
   php artisan about
   \`\`\`

3. **Reset everything:**
   \`\`\`bash
   php artisan config:clear
   php artisan cache:clear
   php artisan migrate:fresh --seed
   \`\`\`

## ✅ System Requirements

- **PHP:** 8.1 or higher
- **Composer:** Latest version
- **Extensions:** PDO, SQLite, OpenSSL, Mbstring

## 🎯 Quick Health Check

Run these commands to verify everything is working:

\`\`\`bash
# 1. Check PHP version
php -v

# 2. Check database connection
php artisan migrate:status

# 3. Check if admin user exists
php artisan tinker
>>> App\Models\User::count()
>>> exit

# 4. Start server
php artisan serve
\`\`\`

If all commands work without errors, your system is ready! 🎉
