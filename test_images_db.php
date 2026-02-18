<?php
require __DIR__ . '/vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$supabaseUrl = $_ENV['SUPABASE_URL'];
$supabaseServiceKey = $_ENV['SUPABASE_SERVICE_KEY'];

// Get property ID from query string
$propertyId = $_GET['property_id'] ?? null;

if (!$propertyId) {
    echo "Usage: test_images_db.php?property_id=123\n";
    exit(1);
}

echo "Checking images for property ID: $propertyId\n\n";

// Fetch images using service key
$url = $supabaseUrl . '/rest/v1/property_images?property_id=eq.' . $propertyId;

$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => [
            "apikey: $supabaseServiceKey",
            "Authorization: Bearer $supabaseServiceKey",
            "Content-Type: application/json"
        ]
    ]
]);

$response = file_get_contents($url, false, $context);
$images = json_decode($response, true);

echo "Found " . count($images) . " images:\n";
echo json_encode($images, JSON_PRETTY_PRINT) . "\n";
?>
