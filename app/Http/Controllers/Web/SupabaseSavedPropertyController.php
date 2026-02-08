<?php

namespace App\Http\Controllers\Web;

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
     * Display user's saved properties
     */
    public function index(Request $request)
    {
        try {
            $user = supabase_user();

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
                    ], ['order' => ['column' => 'is_primary', 'ascending' => false]]);
                    
                    $property->images = $imagesResponse->data ?? [];
                    $property->saved_at = $saved->created_at;
                    $properties[] = $property;
                }
            }

            return view('user.saved-properties', compact('properties'));

        } catch (\Exception $e) {
            return view('user.saved-properties', [
                'properties' => [],
                'error' => 'Failed to load saved properties'
            ]);
        }
    }

    /**
     * Save a property
     */
    public function store(Request $request)
    {
        try {
            $user = supabase_user();
            $propertyId = $request->property_id;

            // Check if already saved
            $existing = $this->supabase->findOne('saved_properties', [
                'user_id' => $user->id,
                'property_id' => $propertyId
            ]);

            if ($existing) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Property already saved'
                    ], 400);
                }
                return back()->with('info', 'Property already in your saved list');
            }

            // Save property
            $this->supabase->insert('saved_properties', [
                'user_id' => $user->id,
                'property_id' => $propertyId
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Property saved successfully'
                ]);
            }

            return back()->with('success', 'Property saved successfully!');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save property'
                ], 500);
            }
            return back()->with('error', 'Failed to save property');
        }
    }

    /**
     * Remove saved property
     */
    public function destroy(Request $request, $propertyId)
    {
        try {
            $user = supabase_user();

            // Delete saved property
            $this->supabase->delete('saved_properties', [
                'user_id' => $user->id,
                'property_id' => $propertyId
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Property removed from saved list'
                ]);
            }

            return back()->with('success', 'Property removed from saved list');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove property'
                ], 500);
            }
            return back()->with('error', 'Failed to remove property');
        }
    }

    /**
     * Toggle save/unsave property
     */
    public function toggle(Request $request)
    {
        try {
            $user = supabase_user();
            $propertyId = $request->property_id;

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
                'message' => 'Failed to toggle save status'
            ], 500);
        }
    }

    /**
     * Check if property is saved
     */
    public function check($propertyId)
    {
        try {
            $user = supabase_user();

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
