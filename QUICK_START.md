# 🚀 Quick Start Guide - Mabini Health Center

## ✅ Ready to Use - No MySQL Required!

This system is now configured to use **SQLite** - no database server setup needed!

## 📥 After Download:

### 1. **Install Dependencies**
\`\`\`bash
composer install
\`\`\`

### 2. **Setup Environment**
\`\`\`bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
\`\`\`

### 3. **Create Database**
\`\`\`bash
# Create SQLite database file
touch database/database.sqlite

# Run migrations and seed data
php artisan migrate:fresh --seed
\`\`\`

### 4. **Start Server**
\`\`\`bash
php artisan serve
\`\`\`

### 5. **Login**
- **URL:** http://localhost:8000
- **Email:** admin@mabini.com
- **Password:** password

## 🎯 What's Included:

✅ **Complete Health Center System**
- Patient Management
- Queue System  
- Medicine Inventory
- Reports & Analytics
- Authentication System

✅ **Modern Design**
- Green gradient theme
- Responsive layout
- Clean interface
- Font Awesome icons

✅ **No Database Setup Required**
- Uses SQLite (file-based database)
- No MySQL/XAMPP needed
- Works immediately after setup

## 🔧 If You Get Errors:

### Database Connection Error:
\`\`\`bash
# Make sure database file exists
touch database/database.sqlite

# Clear cache and retry
php artisan config:clear
php artisan migrate:fresh --seed
\`\`\`

### Permission Errors:
\`\`\`bash
chmod 664 database/database.sqlite
chmod 775 database/
chmod -R 775 storage/
\`\`\`

## 🌟 Features:

- **Dashboard** - Real-time statistics
- **Patients** - Add, edit, view patient records
- **Queue** - Digital queue management with priorities
- **Medicines** - Inventory tracking with alerts
- **Reports** - Analytics and data visualization
- **Mobile Responsive** - Works on all devices

## 📱 Perfect For:

- Health centers and clinics
- Student capstone projects
- Medical practice management
- Queue management systems
- Inventory tracking

---

**🎉 Your Mabini Health Center is ready to use!**

No complicated setup, no database servers - just download, install, and run!
