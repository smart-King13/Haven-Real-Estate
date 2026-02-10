<?php

// Early error reporting for debugging Render 500 errors
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', 'php://stderr');

set_exception_handler(function ($e) {
    error_log('EARLY FATAL EXCEPTION: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    error_log($e->getTraceAsString());
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        error_log('EARLY FATAL ERROR: ' . $error['message'] . ' in ' . $error['file'] . ':' . $error['line']);
    }
});

// Checkpoint 1
if (isset($_GET['checkpoint'])) echo "Checkpoint 1: Pre-Boot<br>";

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Checkpoint 2
if (isset($_GET['checkpoint'])) echo "Checkpoint 2: Constants Defined<br>";

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Checkpoint 3
if (isset($_GET['checkpoint'])) echo "Checkpoint 3: Maintenance Checked<br>";

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Checkpoint 4
if (isset($_GET['checkpoint'])) echo "Checkpoint 4: Autoload Loaded<br>";

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Checkpoint 5
if (isset($_GET['checkpoint'])) echo "Checkpoint 5: App Bootstrapped<br>";

try {
    // Check storage writability
    if (isset($_GET['checkpoint'])) {
        $paths = [
            __DIR__.'/../storage/logs',
            __DIR__.'/../storage/framework/views',
            __DIR__.'/../storage/framework/sessions',
            __DIR__.'/../bootstrap/cache',
        ];
        foreach ($paths as $path) {
            echo "Checking path $path: " . (is_writable($path) ? "Writable<br>" : "NOT WRITABLE<br>");
        }
    }

    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    if (isset($_GET['checkpoint'])) {
        echo "<h1 style='color:red'>CRITICAL BOOT ERROR</h1>";
        echo "<strong>" . $e->getMessage() . "</strong><br>";
        echo "in " . $e->getFile() . ":" . $e->getLine() . "<br>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
    throw $e; // Re-throw for normal logging if not in debug mode
}

// Checkpoint 6
if (isset($_GET['checkpoint'])) echo "Checkpoint 6: Request Handled<br>";
