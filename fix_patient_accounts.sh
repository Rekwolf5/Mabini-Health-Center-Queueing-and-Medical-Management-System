#!/bin/bash

echo "🔧 Fixing Patient Accounts Table Issue"
echo "====================================="

# Check current migration status
echo "📋 Checking current migration status..."
php artisan migrate:status

echo ""
echo "🗄️ Running fresh migrations with seed data..."
php artisan migrate:fresh --seed

echo ""
echo "✅ Checking if patient_accounts table was created..."
php artisan tinker --execute="
echo 'Tables in database:';
\$tables = DB::select('SELECT name FROM sqlite_master WHERE type=\"table\"');
foreach(\$tables as \$table) {
    echo '- ' . \$table->name . PHP_EOL;
}
echo PHP_EOL . 'Patient accounts count: ' . App\Models\PatientAccount::count();
"

echo ""
echo "🚀 Starting server..."
php artisan serve
