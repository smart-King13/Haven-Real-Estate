<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Users with Avatars ===\n\n";

$users = App\Models\User::whereNotNull('avatar')->get(['id', 'name', 'email', 'avatar']);

foreach ($users as $user) {
    echo "ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Avatar Path: " . $user->avatar . "\n";
    echo "Storage File Exists: " . (file_exists(storage_path('app/public/' . $user->avatar)) ? 'Yes' : 'No') . "\n";
    echo "Public File Exists: " . (file_exists(public_path('storage/' . $user->avatar)) ? 'Yes' : 'No') . "\n";
    echo "Full URL: " . asset('storage/' . $user->avatar) . "\n";
    echo "---\n";
}
