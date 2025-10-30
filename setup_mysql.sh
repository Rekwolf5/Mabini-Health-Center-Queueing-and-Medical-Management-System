#!/bin/bash

echo "🏥 Mabini Health Center - MySQL Setup"
echo "======================================"

# Check if MySQL is running
if ! command -v mysql &> /dev/null; then
    echo "❌ MySQL is not installed. Please install MySQL first."
    exit 1
fi

# Create database
echo "📊 Creating MySQL database..."
mysql -u root -p -e "
CREATE DATABASE IF NOT EXISTS mabini_health_center;
CREATE USER IF NOT EXISTS 'mabini_user'@'localhost' IDENTIFIED BY 'mabini_password';
GRANT ALL PRIVILEGES ON mabini_health_center.* TO 'mabini_user'@'localhost';
FLUSH PRIVILEGES;
"

# Setup Laravel
echo "🔧 Setting up Laravel environment..."
cp .env.example .env
php artisan key:generate

echo "📋 Please update your .env file with the following MySQL configuration:"
echo ""
echo "DB_CONNECTION=mysql"
echo "DB_HOST=127.0.0.1"
echo "DB_PORT=3306"
echo "DB_DATABASE=mabini_health_center"
echo "DB_USERNAME=mabini_user"
echo "DB_PASSWORD=mabini_password"
echo ""
echo "Press Enter after updating .env file..."
read

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate

# Seed database
echo "🌱 Seeding database with sample data..."
php artisan db:seed

# Start server
echo "🚀 Starting Laravel development server..."
echo ""
echo "✅ Setup complete!"
echo "🌐 Access your application at: http://localhost:8000"
echo "🔐 Login credentials:"
echo "   Email: admin@mabini.com"
echo "   Password: password"
echo ""

php artisan serve
