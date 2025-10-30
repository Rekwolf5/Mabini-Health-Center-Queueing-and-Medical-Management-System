<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 Database Connection Check\n";
echo "============================\n\n";

try {
    // Check database connection
    $pdo = DB::connection()->getPdo();
    echo "✅ Database connection: OK\n";
    
    // Check if database file exists
    $dbPath = database_path('database.sqlite');
    if (file_exists($dbPath)) {
        echo "✅ Database file exists: " . $dbPath . "\n";
        echo "📊 Database file size: " . number_format(filesize($dbPath)) . " bytes\n";
    } else {
        echo "❌ Database file missing: " . $dbPath . "\n";
    }
    
    // List all tables
    echo "\n📋 Tables in database:\n";
    $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
    foreach ($tables as $table) {
        echo "- " . $table->name . "\n";
    }
    
    // Check specific tables
    echo "\n🔍 Table checks:\n";
    $requiredTables = ['users', 'patients', 'patient_accounts', 'medicines', 'queue', 'medical_records'];
    
    foreach ($requiredTables as $tableName) {
        try {
            $count = DB::table($tableName)->count();
            echo "✅ {$tableName}: {$count} records\n";
        } catch (Exception $e) {
            echo "❌ {$tableName}: Table missing or error\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}

echo "\n🎯 Next steps:\n";
echo "1. Run: php artisan migrate:fresh --seed\n";
echo "2. Run: php artisan serve\n";
echo "3. Visit: http://localhost:8000/register\n";
?>
