<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\SupabaseService;

$service = new SupabaseService();
echo "Testing Supabase API connection...\n";
echo "URL: " . config('services.supabase.url') . "\n";

try {
    $result = $service->select('profiles', '*', [], ['limit' => 1]);
    if (isset($result->data)) {
        echo "SUCCESS: Retrieved " . count($result->data) . " profiles!\n";
        print_r($result->data);
    } else {
        echo "FAILURE: Could not retrieve profiles.\n";
    }
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}
