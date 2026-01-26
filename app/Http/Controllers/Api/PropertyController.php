<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties with filters and search
     */
    public function index(Request $request)
    {
        $query = Property::with(['category', 'user', 'primaryImage'])
            ->active()
            ->available();

        // Search by keyword
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by type (rent/sale)
        if ($request->has('type') && $request->type) {
            $query->type($request->type);
        }

        // Filter by price range
        if ($request->has('min_price') || $request->has('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        // Filter by location
        if ($request->has('location') && $request->location) {
            $query->location($request->location);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by property type
        if ($request->has('property_type') && $request->property_type) {
            $query->where('property_type', $request->property_type);
        }

        // Filter by bedrooms
        if ($request->has('bedrooms') && $request->bedrooms) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Sort properties
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        $properties = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $properties,
        ]);
    }

    /**
     * Store a newly created property (Admin only)
     */
    public function store(StorePropertyRequest $request)
    {
        // Validation is handled by StorePropertyRequest
        $property = Property::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'location' => $request->location,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'type' => $request->type,
            'status' => $request->status ?? 'available',
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'area' => $request->area,
            'property_type' => $request->property_type,
            'features' => $request->features,
            'category_id' => $request->category_id,
            'user_id' => $request->user()->id,
            'is_featured' => $request->is_featured ?? false,
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('properties', 'public');
                
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $imagePath,
                    'is_primary' => $index === 0, // First image is primary
                    'sort_order' => $index,
                ]);
            }
        }

        $property->load(['category', 'user', 'images']);

        return response()->json([
            'success' => true,
            'message' => 'Property created successfully',
            'data' => $property,
        ], 201);
    }

    /**
     * Display the specified property
     */
    public function show($id)
    {
        $property = Property::with([
            'category',
            'user:id,name,email,phone',
            'images' => function ($query) {
                $query->orderBy('sort_order');
            }
        ])->findOrFail($id);

        if (!$property->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Property not found or inactive',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $property,
        ]);
    }

    /**
     * Update the specified property (Admin only)
     */
    public function update(UpdatePropertyRequest $request, $id)
    {
        // Authorization and validation handled by UpdatePropertyRequest
        $property = Property::findOrFail($id);

        $property->update($request->only([
            'title', 'description', 'price', 'location', 'address',
            'latitude', 'longitude', 'type', 'status', 'bedrooms',
            'bathrooms', 'area', 'property_type', 'features',
            'category_id', 'is_featured', 'is_active'
        ]));

        $property->load(['category', 'user', 'images']);

        return response()->json([
            'success' => true,
            'message' => 'Property updated successfully',
            'data' => $property,
        ]);
    }

    /**
     * Remove the specified property (Admin only)
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $property = Property::findOrFail($id);

        // Delete associated images from storage
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $property->delete();

        return response()->json([
            'success' => true,
            'message' => 'Property deleted successfully',
        ]);
    }

    /**
     * Get featured properties
     */
    public function featured(Request $request)
    {
        $properties = Property::with(['category', 'user', 'primaryImage'])
            ->active()
            ->available()
            ->featured()
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $properties,
        ]);
    }

    /**
     * Upload additional images to property
     */
    public function uploadImages(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $property = Property::findOrFail($id);

        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $uploadedImages = [];
        $currentMaxOrder = $property->images()->max('sort_order') ?? -1;

        foreach ($request->file('images') as $index => $image) {
            $imagePath = $image->store('properties', 'public');
            
            $propertyImage = PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $imagePath,
                'is_primary' => false,
                'sort_order' => $currentMaxOrder + $index + 1,
            ]);

            $uploadedImages[] = $propertyImage;
        }

        return response()->json([
            'success' => true,
            'message' => 'Images uploaded successfully',
            'data' => $uploadedImages,
        ]);
    }
}