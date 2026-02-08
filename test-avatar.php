<?php
// Test avatar display
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get session data
session_start();
$profile = $_SESSION['supabase_profile'] ?? null;

echo "<h1>Avatar Debug Information</h1>";
echo "<h2>Session Profile Data:</h2>";
echo "<pre>";
print_r($profile);
echo "</pre>";

if ($profile && isset($profile->avatar)) {
    $avatarPath = $profile->avatar;
    echo "<h2>Avatar Path: " . htmlspecialchars($avatarPath) . "</h2>";
    
    $storagePath = __DIR__ . '/storage/app/public/' . $avatarPath;
    $publicPath = __DIR__ . '/public/storage/' . $avatarPath;
    
    echo "<h3>Storage Path Check:</h3>";
    echo "<p>Path: " . $storagePath . "</p>";
    echo "<p>Exists: " . (file_exists($storagePath) ? 'YES' : 'NO') . "</p>";
    
    echo "<h3>Public Path Check:</h3>";
    echo "<p>Path: " . $publicPath . "</p>";
    echo "<p>Exists: " . (file_exists($publicPath) ? 'YES' : 'NO') . "</p>";
    
    $url = asset('storage/' . $avatarPath);
    echo "<h3>Generated URL:</h3>";
    echo "<p>" . htmlspecialchars($url) . "</p>";
    
    echo "<h3>Image Display Test:</h3>";
    echo "<img src='" . htmlspecialchars($url) . "' alt='Avatar' style='max-width: 200px; border: 2px solid red;'>";
} else {
    echo "<p>No avatar set in profile</p>";
}
