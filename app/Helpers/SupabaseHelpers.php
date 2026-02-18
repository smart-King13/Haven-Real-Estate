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
     * Handles both local storage and Supabase storage paths, and direct URLs
     */
    function property_image_url($pathOrUrl): string
    {
        if (!$pathOrUrl) {
            return asset('images/properties-hero.png');
        }
        
        // If it's already a full URL (starts with http:// or https://), return as-is
        if (preg_match('/^https?:\/\//i', $pathOrUrl)) {
            return $pathOrUrl;
        }
        
        // Check if path starts with 'properties/' (local storage format)
        if (str_starts_with($pathOrUrl, 'properties/')) {
            // This is a local storage path
            $localPath = 'storage/' . $pathOrUrl;
            
            // Check if file exists locally
            if (file_exists(public_path($localPath))) {
                return asset($localPath);
            }
            
            // If not found locally, try Supabase storage
            return supabase_storage_url('property-images', $pathOrUrl);
        }
        
        // Check if path matches local storage filename format (timestamp_index.ext or hash.ext)
        if (preg_match('/^\d+_\d+\.(jpg|jpeg|png|webp)$/i', $pathOrUrl) || 
            preg_match('/^[a-zA-Z0-9]{40}\.(jpg|jpeg|png|webp)$/i', $pathOrUrl)) {
            
            $localPath = 'storage/properties/' . $pathOrUrl;
            
            // Check if file exists locally
            if (file_exists(public_path($localPath))) {
                return asset($localPath);
            }
            
            // Fallback to a professional internal image
            return asset('images/properties-hero.png');
        }
        
        // Default: assume it's a Supabase storage path
        return supabase_storage_url('property-images', $pathOrUrl);
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
