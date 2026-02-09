<?php
/**
 * Sync Local Property Images to Supabase Database
 * Run this from command line: php sync-images-to-database.php
 */

require __DIR__ . '/vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$supabaseUrl = $_ENV['SUPABASE_URL'];
$supabaseKey = $_ENV['SUPABASE_SERVICE_KEY']; // Use service key to bypass RLS

echo "🔄 Syncing local images to Supabase database...\n\n";

// Get all properties from database
$propertiesResponse = file_get_contents($supabaseUrl . '/rest/v1/properties?select=id,title', false, stream_context_create([
    'http' => [
        'header' => [
            "apikey: $supabaseKey",
            "Authorization: Bearer $supabaseKey"
        ]
    ]
]));

$properties = json_decode($propertiesResponse, true);

if (empty($properties)) {
    echo "❌ No properties found in database!\n";
    exit(1);
}

echo "✅ Found " . count($properties) . " properties\n\n";

// Scan local storage for images
$storageDir = __DIR__ . '/storage/app/public/properties';
if (!is_dir($storageDir)) {
    echo "❌ Storage directory not found: $storageDir\n";
    exit(1);
}

$imageFiles = array_diff(scandir($storageDir), ['.', '..']);
$imageFiles = array_filter($imageFiles, function($file) use ($storageDir) {
    return is_file($storageDir . '/' . $file) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
});

echo "✅ Found " . count($imageFiles) . " image files in storage\n\n";

// Get existing images from database
$existingImagesResponse = file_get_contents($supabaseUrl . '/rest/v1/property_images?select=*', false, stream_context_create([
    'http' => [
        'header' => [
            "apikey: $supabaseKey",
            "Authorization: Bearer $supabaseKey"
        ]
    ]
]));

$existingImages = json_decode($existingImagesResponse, true);
$existingPaths = array_column($existingImages, 'image_path');

echo "📊 Existing images in database: " . count($existingImages) . "\n\n";

// Insert missing images
$inserted = 0;
$skipped = 0;

foreach ($imageFiles as $index => $imageFile) {
    $imagePath = 'properties/' . $imageFile;
    
    // Skip if already in database
    if (in_array($imagePath, $existingPaths)) {
        echo "⏭️  Skipped (exists): $imagePath\n";
        $skipped++;
        continue;
    }
    
    // Assign to first property (you can modify this logic)
    $propertyId = $properties[0]['id'];
    $isPrimary = ($index === 0) ? 'true' : 'false';
    
    // Insert into database
    $data = json_encode([
        'property_id' => $propertyId,
        'image_path' => $imagePath,
        'is_primary' => $isPrimary === 'true',
        'sort_order' => $index
    ]);
    
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => [
                "apikey: $supabaseKey",
                "Authorization: Bearer $supabaseKey",
                "Content-Type: application/json",
                "Prefer: return=representation"
            ],
            'content' => $data
        ]
    ]);
    
    $result = @file_get_contents($supabaseUrl . '/rest/v1/property_images', false, $context);
    
    if ($result !== false) {
        echo "✅ Inserted: $imagePath (Property: {$properties[0]['title']})\n";
        $inserted++;
    } else {
        echo "❌ Failed: $imagePath\n";
    }
}

echo "\n";
echo "═══════════════════════════════════════\n";
echo "📊 Summary:\n";
echo "   • Total images in storage: " . count($imageFiles) . "\n";
echo "   • Already in database: $skipped\n";
echo "   • Newly inserted: $inserted\n";
echo "═══════════════════════════════════════\n";
echo "\n✨ Done! Refresh your browser to see images.\n";
