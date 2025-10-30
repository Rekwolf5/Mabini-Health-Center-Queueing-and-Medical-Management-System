#!/bin/bash

echo "🏥 Quick Fix for MySQL Connection Error"
echo "======================================"

echo "🔄 Switching to SQLite (no MySQL required)..."

# Backup current .env
if [ -f .env ]; then
    cp .env .env.backup
    echo "✅ Backed up current .env to .env.backup"
fi

# Create new .env with SQLite
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

echo "✅ Created new .env with SQLite configuration"

# Generate app key
php artisan key:generate

# Create SQLite database
touch database/database.sqlite
echo "✅ Created SQLite database file"

# Clear config cache
php artisan config:clear
echo "✅ Cleared configuration cache"

# Run migrations
echo "🗄️ Setting up database..."
php artisan migrate:fresh --seed

echo ""
echo "✅ Setup complete!"
echo "🌐 Starting server..."
echo "📧 Login: admin@mabini.com"
echo "🔑 Password: password"
echo ""

# Start server
php artisan serve
