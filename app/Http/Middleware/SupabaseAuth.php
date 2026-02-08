<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\SupabaseService;
use Symfony\Component\HttpFoundation\Response;

class SupabaseAuth
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get token from session or Authorization header
        $token = $request->session()->get('supabase_token') 
                 ?? $request->bearerToken();

        if (!$token) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to continue');
        }

        try {
            // Verify token and get user
            $user = $this->supabase->getUser($token);

            if (!$user) {
                throw new \Exception('Invalid token');
            }

            // Get user profile from profiles table (optional - don't fail if missing)
            try {
                $profile = $this->supabase->getUserProfile($user->id);
            } catch (\Exception $e) {
                // If profile doesn't exist, create a basic one
                $profile = (object)[
                    'id' => $user->id,
                    'name' => $user->email,
                    'role' => 'user',
                    'is_active' => true
                ];
            }

            // Store in session for web requests (don't use request->merge for objects)
            $request->session()->put('supabase_user', $user);
            $request->session()->put('supabase_profile', $profile);
            $request->session()->put('supabase_token', $token);

            return $next($request);

        } catch (\Exception $e) {
            \Log::error('Auth middleware error: ' . $e->getMessage());
            
            // Clear invalid session
            $request->session()->forget(['supabase_token', 'supabase_user', 'supabase_profile']);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired token'
                ], 401);
            }

            return redirect()->route('login')->with('error', 'Your session has expired. Please login again.');
        }
    }
}
