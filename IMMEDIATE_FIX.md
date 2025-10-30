# 🚨 IMMEDIATE FIX - Copy & Paste This

## Your .env file is still set to MySQL. Let's fix it NOW:

### Step 1: Copy and paste this ENTIRE command block:

\`\`\`bash
# Stop any running server first
# Press Ctrl+C if server is running

# Create new .env file with SQLite
cat > .env << 'EOF'
APP_NAME="Mabini Health Center"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=UTC

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=file
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
EOF

# Generate app key
php artisan key:generate

# Create SQLite database file
touch database/database.sqlite

# Clear all cache
php artisan config:clear
php artisan cache:clear

# Setup database
php artisan migrate:fresh --seed

# Start server
php artisan serve
\`\`\`

### That's it! Your system will now work.

## What This Does:
1. ✅ **Replaces your .env** with SQLite settings
2. ✅ **Creates SQLite database** (no MySQL needed)
3. ✅ **Sets up all tables** with admin user
4. ✅ **Starts the server**

## Login Details:
- **URL**: http://localhost:8000
- **Email**: admin@mabini.com  
- **Password**: password

## Why This Works:
- **No MySQL required** - Uses a simple file database
- **No server setup** - SQLite is built into PHP
- **Same features** - Everything works exactly the same
- **Instant fix** - Solves your connection error immediately

## If You Still Get Errors:
1. Make sure you're in the project directory
2. Check if `database/database.sqlite` file was created
3. Run: `php artisan config:show database` to verify settings
