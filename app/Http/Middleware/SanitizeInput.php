<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();
        
        array_walk_recursive($input, function (&$input) {
            if (is_string($input)) {
                // Remove potentially dangerous HTML tags but keep basic formatting
                $input = strip_tags($input, '<p><br><strong><em><ul><ol><li>');
                
                // Remove any remaining script content
                $input = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $input);
                
                // Trim whitespace
                $input = trim($input);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}