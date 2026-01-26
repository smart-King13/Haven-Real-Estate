<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\SavedProperty;
use Illuminate\Http\Request;

class SavedPropertyController extends Controller
{
    /**
     * Get user's saved properties
     */
    public function index(Request $request)
    {
        $savedProperties = $request->user()
            ->savedProperties()
            ->with(['category', 'primaryImage'])
            ->where('properties.is_active', true)
            ->orderBy('saved_properties.created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $savedProperties,
        ]);
    }

    /**
     * Save a property to user's favorites
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);

        $property = Property::findOrFail($request->property_id);

        // Check if property is active
        if (!$property->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Property is not available.',
            ], 400);
        }

        // Check if already saved
        $existingSaved = SavedProperty::where('user_id', $request->user()->id)
            ->where('property_id', $request->property_id)
            ->first();

        if ($existingSaved) {
            return response()->json([
                'success' => false,
                'message' => 'Property is already in your saved list.',
            ], 400);
        }

        SavedProperty::create([
            'user_id' => $request->user()->id,
            'property_id' => $request->property_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Property saved successfully.',
        ], 201);
    }

    /**
     * Remove property from saved list
     */
    public function destroy(Request $request, $propertyId)
    {
        $savedProperty = SavedProperty::where('user_id', $request->user()->id)
            ->where('property_id', $propertyId)
            ->first();

        if (!$savedProperty) {
            return response()->json([
                'success' => false,
                'message' => 'Property not found in your saved list.',
            ], 404);
        }

        $savedProperty->delete();

        return response()->json([
            'success' => true,
            'message' => 'Property removed from saved list.',
        ]);
    }

    /**
     * Check if property is saved by user
     */
    public function check(Request $request, $propertyId)
    {
        $isSaved = SavedProperty::where('user_id', $request->user()->id)
            ->where('property_id', $propertyId)
            ->exists();

        return response()->json([
            'success' => true,
            'data' => [
                'is_saved' => $isSaved,
            ],
        ]);
    }

    /**
     * Toggle save status of a property
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
        ]);

        $savedProperty = SavedProperty::where('user_id', $request->user()->id)
            ->where('property_id', $request->property_id)
            ->first();

        if ($savedProperty) {
            // Remove from saved
            $savedProperty->delete();
            $message = 'Property removed from saved list.';
            $isSaved = false;
        } else {
            // Add to saved
            $property = Property::findOrFail($request->property_id);
            
            if (!$property->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property is not available.',
                ], 400);
            }

            SavedProperty::create([
                'user_id' => $request->user()->id,
                'property_id' => $request->property_id,
            ]);
            
            $message = 'Property saved successfully.';
            $isSaved = true;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'is_saved' => $isSaved,
            ],
        ]);
    }
}