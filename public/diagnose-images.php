<!DOCTYPE html>
<html>
<head>
    <title>Property Images Diagnostic</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        h1 { color: #333; }
        .section { margin: 20px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #4CAF50; }
        .error { border-left-color: #f44336; }
        .warning { border-left-color: #ff9800; }
        .success { border-left-color: #4CAF50; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        img { max-width: 100px; height: auto; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-success { background: #4CAF50; color: white; }
        .badge-error { background: #f44336; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Property Images Diagnostic Tool</h1>
        
        <?php
        // Check if storage directory exists
        $storagePath = __DIR__ . '/../storage/app/public/properties';
        $publicStoragePath = __DIR__ . '/storage/properties';
        
        echo '<div class="section">';
        echo '<h2>1. Storage Directory Check</h2>';
        echo '<p><strong>Storage Path:</strong> ' . $storagePath . '</p>';
        echo '<p><strong>Exists:</strong> ' . (file_exists($storagePath) ? '<span class="badge badge-success">YES</span>' : '<span class="badge badge-error">NO</span>') . '</p>';
        echo '<p><strong>Writable:</strong> ' . (is_writable($storagePath) ? '<span class="badge badge-success">YES</span>' : '<span class="badge badge-error">NO</span>') . '</p>';
        
        echo '<p><strong>Public Storage Path:</strong> ' . $publicStoragePath . '</p>';
        echo '<p><strong>Symlink Exists:</strong> ' . (file_exists($publicStoragePath) ? '<span class="badge badge-success">YES</span>' : '<span class="badge badge-error">NO - Run: php artisan storage:link</span>') . '</p>';
        echo '</div>';
        
        // List files in storage
        echo '<div class="section">';
        echo '<h2>2. Files in Storage</h2>';
        if (file_exists($storagePath)) {
            $files = scandir($storagePath);
            $imageFiles = array_filter($files, function($file) use ($storagePath) {
                return is_file($storagePath . '/' . $file) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
            });
            
            if (count($imageFiles) > 0) {
                echo '<p>Found ' . count($imageFiles) . ' image files:</p>';
                echo '<table>';
                echo '<tr><th>Filename</th><th>Size</th><th>Preview</th><th>Public URL</th></tr>';
                foreach ($imageFiles as $file) {
                    $filePath = $storagePath . '/' . $file;
                    $fileSize = filesize($filePath);
                    $publicUrl = '/storage/properties/' . $file;
                    echo '<tr>';
                    echo '<td>' . $file . '</td>';
                    echo '<td>' . number_format($fileSize / 1024, 2) . ' KB</td>';
                    echo '<td><img src="' . $publicUrl . '" alt="' . $file . '" onerror="this.src=\'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'%3E%3Crect fill=\'%23ddd\' width=\'100\' height=\'100\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23999\'%3EERROR%3C/text%3E%3C/svg%3E\'"></td>';
                    echo '<td><code>' . $publicUrl . '</code></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p class="warning">⚠️ No image files found in storage directory!</p>';
            }
        } else {
            echo '<p class="error">❌ Storage directory does not exist!</p>';
        }
        echo '</div>';
        
        // Check .env configuration
        echo '<div class="section">';
        echo '<h2>3. Environment Configuration</h2>';
        $envPath = __DIR__ . '/../.env';
        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);
            preg_match('/SUPABASE_URL=(.*)/', $envContent, $supabaseUrl);
            preg_match('/SUPABASE_KEY=(.*)/', $envContent, $supabaseKey);
            preg_match('/APP_URL=(.*)/', $envContent, $appUrl);
            
            echo '<p><strong>APP_URL:</strong> ' . ($appUrl[1] ?? 'Not set') . '</p>';
            echo '<p><strong>SUPABASE_URL:</strong> ' . (isset($supabaseUrl[1]) ? '<span class="badge badge-success">SET</span>' : '<span class="badge badge-error">NOT SET</span>') . '</p>';
            echo '<p><strong>SUPABASE_KEY:</strong> ' . (isset($supabaseKey[1]) ? '<span class="badge badge-success">SET</span>' : '<span class="badge badge-error">NOT SET</span>') . '</p>';
        } else {
            echo '<p class="error">❌ .env file not found!</p>';
        }
        echo '</div>';
        
        // Recommendations
        echo '<div class="section success">';
        echo '<h2>4. Recommendations</h2>';
        echo '<ul>';
        if (!file_exists($publicStoragePath)) {
            echo '<li>Run: <code>php artisan storage:link</code></li>';
        }
        if (!file_exists($storagePath)) {
            echo '<li>Create directory: <code>storage/app/public/properties</code></li>';
        }
        if (file_exists($storagePath) && !is_writable($storagePath)) {
            echo '<li>Make storage writable: <code>chmod -R 775 storage</code></li>';
        }
        echo '<li>Clear cache: <code>php artisan cache:clear && php artisan config:clear && php artisan view:clear</code></li>';
        echo '<li>Check Supabase RLS policies for property_images table</li>';
        echo '</ul>';
        echo '</div>';
        ?>
    </div>
</body>
</html>
