# 🚀 Mabini Health Center Setup Guide

## Quick Setup (Recommended)

### 1. **Environment Setup**
\`\`\`bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
\`\`\`

### 2. **Database Setup (SQLite - No MySQL required)**
\`\`\`bash
# Create SQLite database file
touch database/database.sqlite

# Run migrations to create tables
php artisan migrate

# Seed database with sample data
php artisan db:seed
\`\`\`

### 3. **Start the Application**
\`\`\`bash
# Start Laravel development server
php artisan serve
\`\`\`

### 4. **Access the Application**
- Open your browser and go to: `http://localhost:8000`
- **Login Credentials:**
  - Email: `admin@mabini.com`
  - Password: `password`

---

## Alternative Setup (MySQL)

If you prefer to use MySQL instead of SQLite:

### 1. **Create MySQL Database**
\`\`\`sql
mysql -u root -p
CREATE DATABASE mabini_health_center;
exit
\`\`\`

### 2. **Update .env file**
\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mabini_health_center
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
\`\`\`

### 3. **Run Migrations**
\`\`\`bash
php artisan migrate
php artisan db:seed
\`\`\`

---

## 🔧 Troubleshooting

### Error: "no such table: patients"
This means the database tables haven't been created yet.

**Solution:**
\`\`\`bash
# Make sure database file exists (for SQLite)
touch database/database.sqlite

# Run migrations
php artisan migrate

# If you get permission errors, try:
chmod 664 database/database.sqlite
chmod 775 database/
\`\`\`

### Error: "Access denied for user"
This is a MySQL connection error.

**Solution:**
1. Check your MySQL credentials in `.env`
2. Make sure MySQL service is running
3. Create the database: `CREATE DATABASE mabini_health_center;`

### Error: "Class not found"
**Solution:**
\`\`\`bash
# Clear cache and regenerate autoload
php artisan config:clear
php artisan cache:clear
composer dump-autoload
\`\`\`

---

## 📊 Sample Data

After running `php artisan db:seed`, you'll have:

### Users
- **Admin User**: admin@mabini.com / password

### Patients
- Maria Santos (35, Female)
- Juan Dela Cruz (42, Male)  
- Ana Garcia (28, Female)

### Medicines
- Paracetamol 500mg (150 stock)
- Amoxicillin 250mg (25 stock - Low)
- Ibuprofen 400mg (80 stock)
- Cetirizine 10mg (5 stock - Critical)

### Queue Entries
- 3 sample queue entries with different priorities

---

## 🎯 Features Available

✅ **Authentication System**
- Login/Register functionality
- Protected routes
- Session management

✅ **Patient Management**
- Add, edit, view, delete patients
- Medical history tracking
- Patient search and pagination

✅ **Queue Management**
- Digital queue system
- Priority handling (Normal, Urgent, Emergency)
- Real-time status updates

✅ **Medicine Inventory**
- Stock level tracking
- Expiry date monitoring
- Low stock alerts

✅ **Reports & Analytics**
- Patient demographics
- Queue performance
- Medicine inventory reports

✅ **Responsive Design**
- Works on desktop, tablet, mobile
- Modern green gradient theme
- Clean, professional interface

---

## 🔐 Security Features

- CSRF protection
- Password hashing
- Session security
- Input validation
- SQL injection prevention

---

## 📱 Mobile Responsive

The system is fully responsive and works perfectly on:
- Desktop computers
- Tablets
- Mobile phones
- All modern browsers

---

## 🆘 Need Help?

If you encounter any issues:

1. **Check Laravel logs**: `storage/logs/laravel.log`
2. **Clear cache**: `php artisan config:clear && php artisan cache:clear`
3. **Regenerate key**: `php artisan key:generate`
4. **Reset database**: `php artisan migrate:fresh --seed`

---

**🎉 You're all set! Enjoy using the Mabini Health Center Management System!**
\`\`\`

## 🗄️ **Create Database Directory Structure**

```plaintext file="database/.gitkeep"
# This file ensures the database directory is tracked by git
