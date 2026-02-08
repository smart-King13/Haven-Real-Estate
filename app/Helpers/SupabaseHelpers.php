<?php

use App\Services\SupabaseService;

if (!function_exists('supabase')) {
    /**
     * Get Supabase service instance
     */
    function supabase(): SupabaseService
    {
        return app(SupabaseService::class);
    }
}

if (!function_exists('supabase_user')) {
    /**
     * Get current authenticated Supabase user
     */
    function supabase_user()
    {
        return request()->get('supabase_user') ?? session('supabase_user');
    }
}

if (!function_exists('supabase_profile')) {
    /**
     * Get current authenticated user profile
     */
    function supabase_profile()
    {
        return request()->get('supabase_profile') ?? session('supabase_profile');
    }
}

if (!function_exists('supabase_token')) {
    /**
     * Get current Supabase access token
     */
    function supabase_token()
    {
        return request()->get('supabase_token') ?? session('supabase_token');
    }
}

if (!function_exists('is_admin')) {
    /**
     * Check if current user is admin
     */
    function is_admin(): bool
    {
        $profile = supabase_profile();
        return $profile && $profile->role === 'admin';
    }
}

if (!function_exists('supabase_storage_url')) {
    /**
     * Get full Supabase storage URL
     */
    function supabase_storage_url(string $bucket, string $path): string
    {
        return config('services.supabase.url') . '/storage/v1/object/public/' . $bucket . '/' . $path;
    }
}

if (!function_exists('property_image_url')) {
    /**
     * Get property image URL
     */
    function property_image_url(string $path): string
    {
        return supabase_storage_url('property-images', $path);
    }
}

if (!function_exists('avatar_url')) {
    /**
     * Get avatar URL
     */
    function avatar_url(?string $path): string
    {
        if (!$path) {
            return asset('images/default-avatar.png');
        }
        return supabase_storage_url('avatars', $path);
    }
}

if (!function_exists('format_naira')) {
    /**
     * Format amount as Nigerian Naira
     * 
     * @param float|int $amount
     * @param bool $showSymbol
     * @return string
     */
    function format_naira($amount, bool $showSymbol = true): string
    {
        $formatted = number_format($amount, 0, '.', ',');
        return $showSymbol ? '₦' . $formatted : $formatted;
    }
}

if (!function_exists('naira')) {
    /**
     * Alias for format_naira
     */
    function naira($amount, bool $showSymbol = true): string
    {
        return format_naira($amount, $showSymbol);
    }
}
