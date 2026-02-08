<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;

class SupabaseSavedPropertyController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Get user's saved properties
     */
    public function index(Request $request)
    {
        try {
            $user = $request->get('supabase_user');

            // Get saved properties
            $savedResponse = $this->supabase->select('saved_properties', '*', [
                'user_id' => $user->id
            ], ['order' => ['column' => 'created_at', 'ascending' => false]]);

            $savedProperties = $savedResponse->data ?? [];

            // Get full property details for each saved property
            $properties = [];
            foreach ($savedProperties as $saved) {
                $property = $this->supabase->findOne('properties', ['id' => $saved->property_id]);
                
                if ($property) {
                    // Get property images
                    $imagesResponse = $this->supabase->select('property_images', '*', [
                        'property_id' => $property->id
                    ], ['limit' => 1]);
                    
                    $property->images = $imagesResponse->data ?? [];
                    
                    // Add full image URLs
                    foreach ($property->images as &$image) {
                        $image->url = property_image_url($image->image_path);
                    }
                    
                    $property->saved_at = $saved->created_at;
                    $properties[] = $property;
                }
            }

            return response()->json([
                'success' => true,
                'data' => $properties
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load saved properties: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save a property
     */
    public function store(Request $request)
    {
        try {
            $user = $request->get('supabase_user');
            $propertyId = $request->property_id;

            if (!$propertyId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property ID is required'
                ], 400);
            }

            // Check if already saved
            $existing = $this->supabase->findOne('saved_properties', [
                'user_id' => $user->id,
                'property_id' => $propertyId
            ]);

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property already saved'
                ], 400);
            }

            // Save property
            $this->supabase->insert('saved_properties', [
                'user_id' => $user->id,
                'property_id' => $propertyId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Property saved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save property: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove saved property
     */
    public function destroy(Request $request, $propertyId)
    {
        try {
            $user = $request->get('supabase_user');

            // Delete saved property
            $this->supabase->delete('saved_properties', [
                'user_id' => $user->id,
                'property_id' => $propertyId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Property removed from saved list'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove property: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle save/unsave property
     */
    public function toggle(Request $request)
    {
        try {
            $user = $request->get('supabase_user');
            $propertyId = $request->property_id;

            if (!$propertyId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property ID is required'
                ], 400);
            }

            // Check if already saved
            $existing = $this->supabase->findOne('saved_properties', [
                'user_id' => $user->id,
                'property_id' => $propertyId
            ]);

            if ($existing) {
                // Unsave
                $this->supabase->delete('saved_properties', [
                    'user_id' => $user->id,
                    'property_id' => $propertyId
                ]);

                return response()->json([
                    'success' => true,
                    'saved' => false,
                    'message' => 'Property removed from saved list'
                ]);
            } else {
                // Save
                $this->supabase->insert('saved_properties', [
                    'user_id' => $user->id,
                    'property_id' => $propertyId
                ]);

                return response()->json([
                    'success' => true,
                    'saved' => true,
                    'message' => 'Property saved successfully'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle save status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if property is saved
     */
    public function check(Request $request, $propertyId)
    {
        try {
            $user = $request->get('supabase_user');

            $existing = $this->supabase->findOne('saved_properties', [
                'user_id' => $user->id,
                'property_id' => $propertyId
            ]);

            return response()->json([
                'success' => true,
                'saved' => $existing !== null
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'saved' => false
            ]);
        }
    }
}
