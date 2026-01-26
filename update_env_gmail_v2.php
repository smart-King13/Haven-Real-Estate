<?php

$envFile = __DIR__ . '/.env';
$content = file_get_contents($envFile);

// Gmail configuration - New Password
$newConfig = [
    'MAIL_MAILER' => 'smtp',
    'MAIL_HOST' => 'smtp.gmail.com',
    'MAIL_PORT' => '587',
    'MAIL_USERNAME' => 'atedanielgreates@gmail.com',
    'MAIL_PASSWORD' => 'bylzcobkjfcnqmiv', // Spaces removed
    'MAIL_ENCRYPTION' => 'tls',
    'MAIL_FROM_ADDRESS' => 'atedanielgreates@gmail.com',
    'MAIL_FROM_NAME' => '${APP_NAME}'
];

// Helper to replace or append
foreach ($newConfig as $key => $value) {
    if (preg_match("/^{$key}=.*/m", $content)) {
        // Replace existing
        $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
    } else {
        // Append if missing (ensure newline)
        $content .= "\n{$key}={$value}";
    }
}

file_put_contents($envFile, $content);

echo "Updated .env with NEW Gmail password!\n";
