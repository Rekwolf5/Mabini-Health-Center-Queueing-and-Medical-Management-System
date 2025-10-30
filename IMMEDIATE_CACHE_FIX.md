# 🚨 IMMEDIATE CACHE FIX

## Copy and paste this command:

\`\`\`bash
# Update .env to use file cache
echo "CACHE_STORE=file" >> .env
echo "QUEUE_CONNECTION=database" >> .env

# Clear config and cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Start server
php artisan serve
\`\`\`

## Or manually edit your .env file:

Find this line in your `.env` file:
\`\`\`
CACHE_STORE=database
\`\`\`

Change it to:
\`\`\`
CACHE_STORE=file
\`\`\`

Then run:
\`\`\`bash
php artisan config:clear
php artisan cache:clear
php artisan serve
\`\`\`

## Why This Happens:
- Laravel was trying to use database caching
- But the `cache` table doesn't exist
- File caching is simpler for development
- No database tables needed

## ✅ After the fix:
- Cache will use files instead of database
- No more "cache table" errors
- System will work normally
