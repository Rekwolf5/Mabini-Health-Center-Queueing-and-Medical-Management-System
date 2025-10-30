# 🗄️ MySQL Database Setup Guide

## Prerequisites

### 1. **Install MySQL**

#### Windows (XAMPP/WAMP)
- Download and install XAMPP from https://www.apachefriends.org/
- Start Apache and MySQL services from XAMPP Control Panel

#### macOS (Homebrew)
\`\`\`bash
brew install mysql
brew services start mysql
\`\`\`

#### Ubuntu/Linux
\`\`\`bash
sudo apt update
sudo apt install mysql-server
sudo systemctl start mysql
sudo systemctl enable mysql
\`\`\`

### 2. **Secure MySQL Installation (Recommended)**
\`\`\`bash
sudo mysql_secure_installation
\`\`\`

## Database Setup

### 1. **Create Database**
\`\`\`bash
# Access MySQL
mysql -u root -p

# Create database
CREATE DATABASE mabini_health_center;

# Create dedicated user (optional but recommended)
CREATE USER 'mabini_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON mabini_health_center.* TO 'mabini_user'@'localhost';
FLUSH PRIVILEGES;

# Exit MySQL
EXIT;
\`\`\`

### 2. **Configure Laravel Environment**
\`\`\`bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
\`\`\`

### 3. **Update .env File**
Edit your `.env` file with your MySQL credentials:

\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mabini_health_center
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

# Or if you created a dedicated user:
# DB_USERNAME=mabini_user
# DB_PASSWORD=secure_password
\`\`\`

### 4. **Run Migrations and Seeders**
\`\`\`bash
# Test database connection
php artisan migrate:status

# Run migrations to create tables
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Start the application
php artisan serve
\`\`\`

## 🔧 Troubleshooting

### Error: "Access denied for user 'root'@'localhost'"
**Solutions:**
1. Check your MySQL password in `.env`
2. Reset MySQL root password:
   \`\`\`bash
   sudo mysql
   ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'new_password';
   FLUSH PRIVILEGES;
   EXIT;
   \`\`\`

### Error: "Unknown database 'mabini_health_center'"
**Solution:**
\`\`\`sql
mysql -u root -p
CREATE DATABASE mabini_health_center;
EXIT;
\`\`\`

### Error: "Connection refused"
**Solutions:**
1. Make sure MySQL service is running:
   \`\`\`bash
   # Linux/macOS
   sudo systemctl status mysql
   sudo systemctl start mysql
   
   # Windows (XAMPP)
   # Start MySQL from XAMPP Control Panel
   \`\`\`

2. Check if MySQL is listening on port 3306:
   \`\`\`bash
   netstat -an | grep 3306
   \`\`\`

### Error: "The driver could not establish a secure connection"
**Solution:**
Add to your `.env`:
\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mabini_health_center
DB_USERNAME=root
DB_PASSWORD=your_password
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
\`\`\`

## 🚀 Quick Start Commands

\`\`\`bash
# Complete setup in one go
cp .env.example .env
php artisan key:generate

# Update .env with your MySQL credentials, then:
php artisan migrate
php artisan db:seed
php artisan serve
\`\`\`

## 📊 Database Structure

After running migrations, you'll have these tables:

### Core Tables
- **users** - System users (admin, doctors, staff)
- **patients** - Patient information and demographics
- **medicines** - Medicine inventory and details
- **queue** - Digital queue management
- **medical_records** - Patient medical history

### System Tables
- **sessions** - User session management
- **password_reset_tokens** - Password reset functionality

## 🔐 Default Login Credentials

After seeding:
- **Email:** admin@mabini.com
- **Password:** password

## 🎯 Performance Optimizations

The MySQL setup includes:
- **Proper Indexing** - Optimized database queries
- **Foreign Key Constraints** - Data integrity
- **Enum Fields** - Efficient status management
- **Decimal Precision** - Accurate price/measurement storage

## 📈 Scaling Considerations

For production use:
1. **Create dedicated MySQL user** with limited privileges
2. **Enable MySQL slow query log** for optimization
3. **Set up database backups** with mysqldump
4. **Configure connection pooling** for high traffic
5. **Use MySQL 8.0+** for better performance

---

**✅ Your MySQL database is now ready for the Mabini Health Center System!**
\`\`\`

## 🌱 **Enhanced Database Seeder for MySQL**
