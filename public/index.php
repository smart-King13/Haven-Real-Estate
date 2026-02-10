<?php

// Early error reporting for debugging Render 500 errors
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', 'php://stderr');

// FORCE DEBUG MODE to see who is generating the 500 Reponse
putenv('APP_DEBUG=true');
putenv('APP_ENV=local');
$ENV['APP_DEBUG'] = true;
$ENV['APP_ENV'] = 'local';

// FORCE DEBUG MODE to see who is generating the 500 Reponse
putenv('APP_DEBUG=true');
putenv('APP_ENV=local');
$ENV['APP_DEBUG'] = true;
$ENV['APP_ENV'] = 'local';

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

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
