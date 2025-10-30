# 🚀 Simple MySQL Setup Guide

## Step 1: Create MySQL Database

Open your MySQL command line or phpMyAdmin and run:

\`\`\`sql
CREATE DATABASE mabini_health_center;
\`\`\`

## Step 2: Configure Laravel

1. Copy the environment file:
\`\`\`bash
cp .env.example .env
\`\`\`

2. Generate application key:
\`\`\`bash
php artisan key:generate
\`\`\`

3. Edit your `.env` file and update these lines:
\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mabini_health_center
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
\`\`\`

## Step 3: Run Database Setup

\`\`\`bash
# Create database tables
php artisan migrate

# Add sample data
php artisan db:seed

# Start the server
php artisan serve
\`\`\`

## Step 4: Access Application

- Open: http://localhost:8000
- Login: admin@mabini.com
- Password: password

## Troubleshooting

If you get "Access denied" error:
1. Make sure MySQL is running
2. Check your password in .env file
3. Try using an empty password: `DB_PASSWORD=`

If you get "Database does not exist":
1. Create the database: `CREATE DATABASE mabini_health_center;`
2. Run migrations again: `php artisan migrate`
