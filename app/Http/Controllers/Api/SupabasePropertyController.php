<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;

class SupabasePropertyController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Get all properties with filters
     */
    public function index(Request $request)
    {
        try {
            $conditions = ['is_active' => true];
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;

            $options = [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => $perPage,
                'offset' => $offset
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

            // Get property images for each property
            foreach ($properties as &$property) {
                $imagesResponse = $this->supabase->select('property_images', '*', [
                    'property_id' => $property->id
                ], ['order' => ['column' => 'is_primary', 'ascending' => false]]);
                
                $property->images = $imagesResponse->data ?? [];
                
                // Add full image URLs
                foreach ($property->images as &$image) {
                    $image->url = property_image_url($image->image_path);
                }
            }

            // Get total count for pagination
            $total = $this->supabase->count('properties', $conditions);

            return response()->json([
                'success' => true,
                'data' => $properties,
                'pagination' => [
                    'total' => $total,
                    'per_page' => $perPage,
                    'current_page' => $page,
                    'last_page' => ceil($total / $perPage)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load properties: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single property
     */
    public function show($id)
    {
        try {
            $property = $this->supabase->findOne('properties', ['id' => $id]);

            if (!$property) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found'
                ], 404);
            }

            // Get property images
            $imagesResponse = $this->supabase->select('property_images', '*', [
                'property_id' => $property->id
            ], ['order' => ['column' => 'sort_order', 'ascending' => true]]);
            $property->images = $imagesResponse->data ?? [];

            // Add full image URLs
            foreach ($property->images as &$image) {
                $image->url = property_image_url($image->image_path);
            }

            // Get category
            $category = $this->supabase->findOne('categories', ['id' => $property->category_id]);
            $property->category = $category;

            // Increment views
            $this->supabase->update('properties', [
                'views' => ($property->views ?? 0) + 1
            ], ['id' => $property->id]);

            return response()->json([
                'success' => true,
                'data' => $property
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load property: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get featured properties
     */
    public function featured()
    {
        try {
            $response = $this->supabase->select('properties', '*', [
                'is_featured' => true,
                'is_active' => true
            ], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 10
            ]);

            $properties = $response->data ?? [];

            // Get property images for each property
            foreach ($properties as &$property) {
                $imagesResponse = $this->supabase->select('property_images', '*', [
                    'property_id' => $property->id
                ], ['limit' => 1]);
                
                $property->images = $imagesResponse->data ?? [];
                
                // Add full image URLs
                foreach ($property->images as &$image) {
                    $image->url = property_image_url($image->image_path);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $properties
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load featured properties'
            ], 500);
        }
    }

    /**
     * Search properties
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            
            if (empty($query)) {
                return $this->index($request);
            }

            // Search in title, description, and location
            $response = $this->supabase->db()
                ->from('properties')
                ->select('*')
                ->or('title.ilike.%' . $query . '%,description.ilike.%' . $query . '%,location.ilike.%' . $query . '%')
                ->eq('is_active', true)
                ->order('created_at', ['ascending' => false])
                ->limit(20)
                ->execute();

            $properties = $response->data ?? [];

            // Get property images for each property
            foreach ($properties as &$property) {
                $imagesResponse = $this->supabase->select('property_images', '*', [
                    'property_id' => $property->id
                ], ['limit' => 1]);
                
                $property->images = $imagesResponse->data ?? [];
                
                // Add full image URLs
                foreach ($property->images as &$image) {
                    $image->url = property_image_url($image->image_path);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $properties
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
