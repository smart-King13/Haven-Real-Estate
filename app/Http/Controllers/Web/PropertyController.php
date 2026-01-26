<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Category;
use App\Models\SavedProperty;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties
     */
    public function index(Request $request)
    {
        $query = Property::with(['category', 'primaryImage', 'images']);
        
        // If user is authenticated, eager load saved properties relationship
        if (auth()->check()) {
            $query->with(['savedByUsers' => function($q) {
                $q->where('user_id', auth()->id());
            }]);
        }
        
        $query->active();

        // Search by keyword
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by type (rent/sale)
        if ($request->filled('type')) {
            $query->type($request->type);
        }

        // Filter by price range
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->location($request->location);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Sort properties
        $sortBy = $request->get('sort_by', 'created_at');
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
                $query->orderBy('created_at', 'desc');
        }

        $properties = $query->paginate(12)->withQueryString();
        $categories = Category::active()->get();

        return view('properties.index', compact('properties', 'categories'));
    }

    /**
     * Display the specified property
     */
    public function show(Property $property)
    {
        // Load relationships
        $property->load([
            'category',
            'user:id,name,email,phone',
            'images' => function ($query) {
                $query->orderBy('sort_order');
            }
        ]);

        if (!$property->is_active || in_array($property->status, [Property::STATUS_DRAFT, Property::STATUS_ARCHIVED])) {
            if (!auth()->check() || !auth()->user()->isAdmin()) {
                abort(404, 'Property not found');
            }
        }

        // Check if user has saved this property
        $isSaved = false;
        if (auth()->check()) {
            $isSaved = SavedProperty::where('user_id', auth()->id())
                ->where('property_id', $property->id)
                ->exists();
        }

        // Get similar properties
        $similarProperties = Property::with(['category', 'primaryImage'])
            ->active()
            ->available()
            ->where('id', '!=', $property->id)
            ->where(function ($query) use ($property) {
                $query->where('category_id', $property->category_id)
                    ->orWhere('type', $property->type)
                    ->orWhereBetween('price', [$property->price * 0.8, $property->price * 1.2]);
            })
            ->take(4)
            ->get();

        return view('properties.show', compact('property', 'isSaved', 'similarProperties'));
    }

    /**
     * Save/unsave property (AJAX)
     */
    public function toggleSave(Request $request, Property $property)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Please login first'], 401);
        }

        $user = auth()->user();

        $savedProperty = SavedProperty::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->first();

        if ($savedProperty) {
            $savedProperty->delete();
            return response()->json([
                'success' => true,
                'saved' => false,
                'message' => 'Property removed from favorites'
            ]);
        } else {
            SavedProperty::create([
                'user_id' => $user->id,
                'property_id' => $property->id,
            ]);
            return response()->json([
                'success' => true,
                'saved' => true,
                'message' => 'Property added to favorites'
            ]);
        }
    }
}