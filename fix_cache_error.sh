#!/bin/bash

echo "🔧 Fixing Cache Error"
echo "===================="

echo "📝 Updating .env file to use file cache..."

# Check if .env exists
if [ ! -f .env ]; then
    echo "❌ .env file not found. Creating from example..."
    cp .env.example .env
    php artisan key:generate
fi

# Update cache driver to file
if grep -q "CACHE_STORE=" .env; then
    # Replace existing CACHE_STORE line
    sed -i 's/CACHE_STORE=.*/CACHE_STORE=file/' .env
    echo "✅ Updated CACHE_STORE to file"
else
    # Add CACHE_STORE line
    echo "CACHE_STORE=file" >> .env
    echo "✅ Added CACHE_STORE=file to .env"
fi

# Also ensure QUEUE_CONNECTION is set to database (not cache)
if grep -q "QUEUE_CONNECTION=" .env; then
    sed -i 's/QUEUE_CONNECTION=.*/QUEUE_CONNECTION=database/' .env
else
    echo "QUEUE_CONNECTION=database" >> .env
fi

echo "🧹 Clearing configuration cache..."
php artisan config:clear

echo "🧹 Clearing application cache..."
php artisan cache:clear

echo "🧹 Clearing route cache..."
php artisan route:clear

echo "🧹 Clearing view cache..."
php artisan view:clear

echo ""
echo "✅ Cache error fixed!"
echo "🚀 Starting server..."
echo ""

php artisan serve
