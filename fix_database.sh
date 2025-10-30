#!/bin/bash

echo "🏥 Fixing Mabini Health Center Database..."
echo "=========================================="

# Check if .env exists
if [ ! -f .env ]; then
    echo "📋 Creating .env file..."
    cp .env.example .env
    php artisan key:generate
fi

# Clear all cache first
echo "🧹 Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Test database connection
echo "🔌 Testing database connection..."
php artisan migrate:status

# Fresh migration with seed
echo "🗄️ Creating fresh database..."
php artisan migrate:fresh --seed

# Final cache clear
echo "✨ Final cleanup..."
php artisan config:clear

echo ""
echo "✅ Database setup complete!"
echo "🌐 Starting server..."
echo "📧 Login: admin@mabini.com"
echo "🔑 Password: password"
echo ""

# Start server
php artisan serve
