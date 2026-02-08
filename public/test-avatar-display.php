<!DOCTYPE html>
<html>
<head>
    <title>Avatar Display Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-box { border: 2px solid #ccc; padding: 20px; margin: 20px 0; }
        img { max-width: 200px; border: 2px solid red; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Avatar Display Diagnostic</h1>
    
    <?php
    // Get all avatar files
    $avatarDir = __DIR__ . '/storage/avatars/';
    $avatars = [];
    
    if (is_dir($avatarDir)) {
        $files = scandir($avatarDir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && !is_dir($avatarDir . $file)) {
                $avatars[] = $file;
            }
        }
    }
    ?>
    
    <div class="test-box">
        <h2>Storage Directory Check</h2>
        <p><strong>Avatar Directory:</strong> <?php echo $avatarDir; ?></p>
        <p><strong>Directory Exists:</strong> <span class="<?php echo is_dir($avatarDir) ? 'success' : 'error'; ?>">
            <?php echo is_dir($avatarDir) ? 'YES' : 'NO'; ?>
        </span></p>
        <p><strong>Avatar Files Found:</strong> <?php echo count($avatars); ?></p>
    </div>
    
    <?php if (count($avatars) > 0): ?>
        <div class="test-box">
            <h2>Avatar Files Test</h2>
            <?php foreach ($avatars as $avatar): ?>
                <?php 
                    $filePath = $avatarDir . $avatar;
                    $fileSize = filesize($filePath);
                    $url = '/storage/avatars/' . $avatar;
                ?>
                <div style="margin: 20px 0; padding: 15px; background: #f5f5f5;">
                    <h3><?php echo htmlspecialchars($avatar); ?></h3>
                    <p><strong>File Size:</strong> <?php echo number_format($fileSize); ?> bytes</p>
                    <p><strong>URL:</strong> <code><?php echo htmlspecialchars($url); ?></code></p>
                    <p><strong>Full Path:</strong> <code><?php echo htmlspecialchars($filePath); ?></code></p>
                    <p><strong>File Exists:</strong> <span class="success">YES</span></p>
                    <p><strong>Display Test:</strong></p>
                    <img src="<?php echo htmlspecialchars($url); ?>" alt="Avatar Test" 
                         onerror="this.style.border='2px solid red'; this.nextElementSibling.style.display='block';">
                    <p style="display:none; color: red;">❌ Image failed to load!</p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="test-box">
            <p class="error">No avatar files found!</p>
        </div>
    <?php endif; ?>
    
    <div class="test-box">
        <h2>Direct Image Test</h2>
        <p>Testing with a known avatar file:</p>
        <img src="/storage/avatars/b9c940ab-c3ef-4825-9d3b-a949edce4a98_1770377424.jpg" alt="Test Avatar">
    </div>
</body>
</html>
