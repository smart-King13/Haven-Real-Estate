<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SupabasePropertyController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Display property listing
     */
    public function index(Request $request)
    {
        try {
            $conditions = ['is_active' => true];
            $options = [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 12
            ];

            // Apply filters
            if ($request->filled('type')) {
                $conditions['type'] = $request->type;
            }

            if ($request->filled('status')) {
                $conditions['status'] = $request->status;
            }

            if ($request->filled('category_id')) {
                $conditions['category_id'] = $request->category_id;
            }

            if ($request->filled('min_price')) {
                $conditions['price'] = ['>=', $request->min_price];
            }

            if ($request->filled('max_price')) {
                $conditions['price'] = ['<=', $request->max_price];
            }

            if ($request->filled('bedrooms')) {
                $conditions['bedrooms'] = $request->bedrooms;
            }

            if ($request->filled('bathrooms')) {
                $conditions['bathrooms'] = $request->bathrooms;
            }

            if ($request->filled('location')) {
                $conditions['location'] = ['like', '%' . $request->location . '%'];
            }

            // Get properties
            $response = $this->supabase->select('properties', '*', $conditions, $options);
            $properties = $response->data ?? [];
            
            \Log::info('Public properties fetched', ['count' => count($properties), 'conditions' => $conditions]);

            // Get property images for each property
            foreach ($properties as &$property) {
                // Convert to object if array
                $prop = is_array($property) ? (object)$property : $property;
                
                $imagesResponse = $this->supabase->select('property_images', '*', [
                    'property_id' => $prop->id
                ], ['order' => ['column' => 'is_primary', 'ascending' => false]]);
                
                // Store images back to property
                if (is_array($property)) {
                    $property['images'] = $imagesResponse->data ?? [];
                } else {
                    $property->images = $imagesResponse->data ?? [];
                }
            }

            // Get categories for filter
            $categoriesResponse = $this->supabase->select('categories', '*', ['is_active' => true]);
            $categories = $categoriesResponse->data ?? [];

            return view('properties.index', compact('properties', 'categories'));

        } catch (\Exception $e) {
            \Log::error('Public properties error: ' . $e->getMessage());
            return view('properties.index', [
                'properties' => [],
                'categories' => [],
                'error' => 'Failed to load properties: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display single property
     */
    public function show($slugOrId)
    {
        try {
            // Try to find by slug first, then by ID
            $property = $this->supabase->findOne('properties', ['slug' => $slugOrId]);
            
            if (!$property) {
                $property = $this->supabase->findOne('properties', ['id' => $slugOrId]);
            }

            if (!$property) {
                abort(404, 'Property not found');
            }
            
            // Convert to object if array
            $property = is_array($property) ? (object)$property : $property;
            
            // Decode features if it's a JSON string
            if (isset($property->features) && is_string($property->features)) {
                $property->features = json_decode($property->features, true) ?? [];
            } elseif (!isset($property->features)) {
                $property->features = [];
            }

            // Get property images
            $imagesResponse = $this->supabase->select('property_images', '*', [
                'property_id' => $property->id
            ], ['order' => ['column' => 'sort_order', 'ascending' => true]]);
            $property->images = $imagesResponse->data ?? [];

            // Get category
            $category = $this->supabase->findOne('categories', ['id' => $property->category_id]);
            $property->category = $category;

            // Get owner profile
            $owner = $this->supabase->getUserProfile($property->user_id);
            $property->owner = $owner;

            // Increment views
            $this->supabase->update('properties', [
                'views' => ($property->views ?? 0) + 1
            ], ['id' => $property->id]);

            // Check if user has saved this property
            $isSaved = false;
            if ($user = supabase_user()) {
                $savedCheck = $this->supabase->findOne('saved_properties', [
                    'user_id' => $user->id,
                    'property_id' => $property->id
                ]);
                $isSaved = $savedCheck !== null;
            }

            return view('properties.show', compact('property', 'isSaved'));

        } catch (\Exception $e) {
            abort(404, 'Property not found');
        }
    }

    /**
     * Show create property form (Admin only)
     */
    public function create()
    {
        try {
            $categoriesResponse = $this->supabase->select('categories', '*', ['is_active' => true]);
            $categories = $categoriesResponse->data ?? [];

            return view('admin.properties.create', compact('categories'));

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load form');
        }
    }

    /**
     * Store new property (Admin only)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:rent,sale',
            'status' => 'required|in:available,sold,rented,pending',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'property_type' => 'nullable|string|max:100',
            'category_id' => 'required|integer',
            'is_featured' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = supabase_user();

            // Generate slug
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;

            // Ensure unique slug
            while ($this->supabase->findOne('properties', ['slug' => $slug])) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Prepare property data
            $propertyData = [
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'location' => $request->location,
                'address' => $request->address,
                'type' => $request->type,
                'status' => $request->status,
                'bedrooms' => $request->bedrooms,
                'bathrooms' => $request->bathrooms,
                'area' => $request->area,
                'property_type' => $request->property_type,
                'features' => json_encode($request->features ?? []),
                'category_id' => $request->category_id,
                'user_id' => $user->id,
                'is_featured' => $request->has('is_featured'),
                'is_active' => true,
            ];

            // Insert property
            $response = $this->supabase->insert('properties', $propertyData);
            $property = $response->data[0] ?? null;

            if (!$property) {
                throw new \Exception('Failed to create property');
            }

            // Handle image uploads
            if ($request->hasFile('images')) {
                $this->uploadPropertyImages($property->id, $request->file('images'));
            }

            return redirect()->route('admin.properties.index')
                ->with('success', 'Property created successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create property: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show edit property form (Admin only)
     */
    public function edit($id)
    {
        try {
            $property = $this->supabase->findOne('properties', ['id' => $id]);

            if (!$property) {
                abort(404, 'Property not found');
            }

            // Get images
            $imagesResponse = $this->supabase->select('property_images', '*', [
                'property_id' => $property->id
            ]);
            $property->images = $imagesResponse->data ?? [];

            // Get categories
            $categoriesResponse = $this->supabase->select('categories', '*', ['is_active' => true]);
            $categories = $categoriesResponse->data ?? [];

            return view('admin.properties.edit', compact('property', 'categories'));

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load property');
        }
    }

    /**
     * Update property (Admin only)
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:rent,sale',
            'status' => 'required|in:available,sold,rented,pending',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'property_type' => 'nullable|string|max:100',
            'category_id' => 'required|integer',
            'is_featured' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $property = $this->supabase->findOne('properties', ['id' => $id]);

            if (!$property) {
                abort(404, 'Property not found');
            }

            // Update slug if title changed
            $slug = $property->slug;
            if ($request->title !== $property->title) {
                $slug = Str::slug($request->title);
                $originalSlug = $slug;
                $counter = 1;

                while ($this->supabase->findOne('properties', ['slug' => $slug]) && $slug !== $property->slug) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }

            // Prepare update data
            $updateData = [
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'location' => $request->location,
                'address' => $request->address,
                'type' => $request->type,
                'status' => $request->status,
                'bedrooms' => $request->bedrooms,
                'bathrooms' => $request->bathrooms,
                'area' => $request->area,
                'property_type' => $request->property_type,
                'features' => json_encode($request->features ?? []),
                'category_id' => $request->category_id,
                'is_featured' => $request->has('is_featured'),
            ];

            // Update property
            $this->supabase->update('properties', $updateData, ['id' => $id]);

            // Handle new image uploads
            if ($request->hasFile('images')) {
                $this->uploadPropertyImages($id, $request->file('images'));
            }

            return redirect()->route('admin.properties.index')
                ->with('success', 'Property updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update property: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete property (Admin only)
     */
    public function destroy($id)
    {
        try {
            // Get property images to delete from storage
            $imagesResponse = $this->supabase->select('property_images', '*', ['property_id' => $id]);
            $images = $imagesResponse->data ?? [];

            // Delete images from storage
            foreach ($images as $image) {
                try {
                    $this->supabase->deleteFile('property-images', $image->image_path);
                } catch (\Exception $e) {
                    // Continue even if image deletion fails
                }
            }

            // Delete property (cascade will delete images and related records)
            $this->supabase->delete('properties', ['id' => $id]);

            return redirect()->route('admin.properties.index')
                ->with('success', 'Property deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete property');
        }
    }

    /**
     * Upload property images to Supabase Storage
     */
    protected function uploadPropertyImages($propertyId, $images)
    {
        $isFirst = true;

        foreach ($images as $image) {
            try {
                // Generate unique filename
                $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $path = 'properties/' . $filename;

                // Upload to Supabase Storage
                $this->supabase->uploadFile('property-images', $path, file_get_contents($image->getRealPath()), [
                    'contentType' => $image->getMimeType()
                ]);

                // Save image record
                $this->supabase->insert('property_images', [
                    'property_id' => $propertyId,
                    'image_path' => $path,
                    'is_primary' => $isFirst,
                    'sort_order' => $isFirst ? 0 : 999
                ]);

                $isFirst = false;

            } catch (\Exception $e) {
                // Log error but continue with other images
                \Log::error('Failed to upload property image: ' . $e->getMessage());
            }
        }
    }

    /**
     * Delete property image
     */
    public function deleteImage($imageId)
    {
        try {
            $image = $this->supabase->findOne('property_images', ['id' => $imageId]);

            if (!$image) {
                return response()->json(['success' => false, 'message' => 'Image not found'], 404);
            }

            // Delete from storage
            $this->supabase->deleteFile('property-images', $image->image_path);

            // Delete record
            $this->supabase->delete('property_images', ['id' => $imageId]);

            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete image'], 500);
        }
    }
}
