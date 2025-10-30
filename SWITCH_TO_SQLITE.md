# 🔄 How to Switch from MySQL to SQLite

## Step 1: Remove the Wrong package.json
The package.json you added is for Next.js/React projects. Our Laravel project doesn't need it.

**Delete it now:**
\`\`\`bash
rm package.json
\`\`\`

## Step 2: Switch Database to SQLite

### Update your .env file:
Replace your current database settings with:
\`\`\`env
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
\`\`\`

### Or use this command to update automatically:
\`\`\`bash
# Backup current .env
cp .env .env.backup

# Update database settings
sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
sed -i 's/DB_DATABASE=mabini_health_center/DB_DATABASE=/' .env
sed -i 's/DB_USERNAME=root/DB_USERNAME=/' .env
sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=/' .env
\`\`\`

## Step 3: Create SQLite Database
\`\`\`bash
# Create the database file
touch database/database.sqlite

# Make sure it has proper permissions
chmod 664 database/database.sqlite
\`\`\`

## Step 4: Clear Cache and Setup Database
\`\`\`bash
# Clear configuration cache
php artisan config:clear

# Reset and create all tables with sample data
php artisan migrate:fresh --seed
\`\`\`

## Step 5: Start the Server
\`\`\`bash
php artisan serve
\`\`\`

## Step 6: Test Login
Go to: http://localhost:8000
- Email: admin@mabini.com
- Password: password

## What This Does:
✅ Removes MySQL dependency
✅ Uses a simple file-based database
✅ Fixes your connection error
✅ Same functionality, zero setup
✅ Perfect for development and testing

## Your Project Structure Should Be:
\`\`\`
mabini-health-center/
├── app/                 # Laravel PHP files
├── resources/views/     # Blade templates
├── public/css/         # CSS files
├── database/           # Database files
├── .env               # Environment config
└── composer.json      # PHP dependencies (NOT package.json)
\`\`\`

**No package.json needed!** This is a Laravel PHP project, not a Next.js project.
