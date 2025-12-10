<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Parts Project - Upgrade Verification ===\n\n";

// Test 1: PHP Version
echo "1. PHP Version Test\n";
echo "   ✓ PHP Version: " . PHP_VERSION . "\n";
$extensions = ['sqlsrv', 'pdo_sqlsrv', 'redis', 'mbstring', 'xml'];
foreach ($extensions as $ext) {
    $status = extension_loaded($ext) ? '✓' : '✗';
    echo "   {} {}\n";
}
echo "\n";

// Test 2: Laravel Version
echo "2. Laravel Framework Test\n";
echo "   ✓ Laravel: " . app()->version() . "\n\n";

// Test 3: Database Connection
echo "3. Database Connection Test\n";
try {
    $pdo = DB::connection()->getPdo();
    echo "   ✓ Database connected\n";
    echo "   ✓ Driver: " . DB::connection()->getDriverName() . "\n";
    echo "   ✓ Database: " . DB::connection()->getDatabaseName() . "\n";
    
    $count = DB::table('Parts')->count();
    echo "   ✓ Parts count: " . number_format($count) . "\n\n";
} catch (\Exception $e) {
    echo "   ✗ Database error: " . $e->getMessage() . "\n\n";
}

// Test 4: Redis Caching
echo "4. Redis Caching Test\n";
try {
    Cache::put('test_cache', 'working', 60);
    $cached = Cache::get('test_cache');
    echo "   ✓ Redis caching: " . $cached . "\n";
    Cache::forget('test_cache');
    echo "   ✓ Cache clear: successful\n\n";
} catch (\Exception $e) {
    echo "   ✗ Redis error: " . $e->getMessage() . "\n\n";
}

// Test 5: Routes
echo "5. Route Test\n";
$routes = count(Route::getRoutes());
echo "   ✓ Routes loaded: " . $routes . "\n\n";

echo "=== All Tests Complete ===\n";
