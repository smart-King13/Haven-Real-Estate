<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SupabaseAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get profile from session
        $profile = $request->session()->get('supabase_profile');

        if (!$profile) {
            abort(403, 'Unauthorized. Please login first.');
        }

        // Handle both object and array
        $role = is_object($profile) ? $profile->role : ($profile['role'] ?? 'user');

        if ($role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            abort(403, 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}
