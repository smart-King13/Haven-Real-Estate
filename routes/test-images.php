<?php

use Illuminate\Support\Facades\Route;
use App\Services\SupabaseService;

// Test route to check if images are being fetched
Route::get('/test-property-images', function () {
    $supabase = new SupabaseService();
    
    // Get all properties
    $propertiesResponse = $supabase->select('properties', '*');
    $properties = $propertiesResponse->data ?? [];
    
    $result = [];
    
    foreach ($properties as $property) {
        $prop = is_array($property) ? (object)$property : $property;
        
        // Get images for this property
        $imagesResponse = $supabase->select('property_images', '*', [
            'property_id' => $prop->id
        ]);
        
        $result[] = [
            'property_id' => $prop->id,
            'property_title' => $prop->title,
            'images_count' => count($imagesResponse->data ?? []),
            'images' => $imagesResponse->data ?? [],
            'first_image_path' => isset($imagesResponse->data[0]) ? (is_array($imagesResponse->data[0]) ? $imagesResponse->data[0]['image_path'] : $imagesResponse->data[0]->image_path) : null
        ];
    }
    
    return response()->json($result, 200, [], JSON_PRETTY_PRINT);
});
