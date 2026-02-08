<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\SupabaseAdmin::class,
            'auth' => \App\Http\Middleware\SupabaseAuth::class,
            'webhook.signature' => \App\Http\Middleware\VerifyWebhookSignature::class,
            'sanitize' => \App\Http\Middleware\SanitizeInput::class,
            'security.headers' => \App\Http\Middleware\SecurityHeaders::class,
        ]);
        
        // Apply sanitization to all API routes
        $middleware->group('api', [
            'sanitize',
        ]);
        
        // Apply security headers globally
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        
        // Exclude webhook routes from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'webhooks/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
