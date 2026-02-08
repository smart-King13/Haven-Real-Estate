<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Display the home page
     */
    public function index()
    {
        try {
            // Get featured properties (reduced to 3)
            $featuredResponse = $this->supabase->select('properties', '*', [
                'is_active' => true,
                'is_featured' => true,
                'status' => 'available'
            ], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 3
            ]);
            $featuredProperties = $featuredResponse->data ?? [];

            // Get images for featured properties
            foreach ($featuredProperties as &$property) {
                // Convert to object if array
                $prop = is_array($property) ? (object)$property : $property;
                
                $imagesResponse = $this->supabase->select('property_images', '*', [
                    'property_id' => $prop->id
                ], ['limit' => 1, 'order' => ['column' => 'is_primary', 'ascending' => false]]);
                
                // Store images back to property
                if (is_array($property)) {
                    $property['images'] = $imagesResponse->data ?? [];
                    // Get category
                    $category = $this->supabase->findOne('categories', ['id' => $prop->category_id]);
                    $property['category'] = $category;
                } else {
                    $property->images = $imagesResponse->data ?? [];
                    // Get category
                    $category = $this->supabase->findOne('categories', ['id' => $property->category_id]);
                    $property->category = $category;
                }
            }

            // Get recent properties (reduced to 6)
            $recentResponse = $this->supabase->select('properties', '*', [
                'is_active' => true,
                'status' => 'available'
            ], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 6
            ]);
            $recentProperties = $recentResponse->data ?? [];

            // Get images for recent properties
            foreach ($recentProperties as &$property) {
                // Convert to object if array
                $prop = is_array($property) ? (object)$property : $property;
                
                $imagesResponse = $this->supabase->select('property_images', '*', [
                    'property_id' => $prop->id
                ], ['limit' => 1, 'order' => ['column' => 'is_primary', 'ascending' => false]]);
                
                // Store images back to property
                if (is_array($property)) {
                    $property['images'] = $imagesResponse->data ?? [];
                    // Get category
                    $category = $this->supabase->findOne('categories', ['id' => $prop->category_id]);
                    $property['category'] = $category;
                } else {
                    $property->images = $imagesResponse->data ?? [];
                    // Get category
                    $category = $this->supabase->findOne('categories', ['id' => $property->category_id]);
                    $property->category = $category;
                }
            }

            // Get categories
            $categoriesResponse = $this->supabase->select('categories', '*', ['is_active' => true]);
            $categories = $categoriesResponse->data ?? [];

            // Get stats
            $totalProperties = $this->supabase->count('properties', [
                'is_active' => true,
                'status' => 'available'
            ]);

            $propertiesForSale = $this->supabase->count('properties', [
                'is_active' => true,
                'status' => 'available',
                'type' => 'sale'
            ]);

            $propertiesForRent = $this->supabase->count('properties', [
                'is_active' => true,
                'status' => 'available',
                'type' => 'rent'
            ]);

            $stats = [
                'total_properties' => $totalProperties,
                'properties_for_sale' => $propertiesForSale,
                'properties_for_rent' => $propertiesForRent,
            ];

            return view('home', compact('featuredProperties', 'recentProperties', 'categories', 'stats'));

        } catch (\Exception $e) {
            // Return view with empty data if Supabase fails
            return view('home', [
                'featuredProperties' => [],
                'recentProperties' => [],
                'categories' => [],
                'stats' => [
                    'total_properties' => 0,
                    'properties_for_sale' => 0,
                    'properties_for_rent' => 0,
                ]
            ]);
        }
    }

    /**
     * Display the about page
     */
    public function about()
    {
        try {
            $totalProperties = $this->supabase->count('properties', [
                'is_active' => true,
                'status' => 'available'
            ]);

            $stats = [
                'total_properties' => $totalProperties,
                'verified_properties' => $totalProperties, // All properties are verified
                'years_experience' => now()->year - 2024 + 1, // Since 2024
                'client_satisfaction' => 100, // 100% satisfaction rate
            ];

            return view('about', compact('stats'));

        } catch (\Exception $e) {
            return view('about', [
                'stats' => [
                    'total_properties' => 0,
                    'verified_properties' => 0,
                    'years_experience' => 1,
                    'client_satisfaction' => 100,
                ]
            ]);
        }
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Here you would typically:
        // 1. Save to database
        // 2. Send email notification
        // 3. Send auto-reply to user
        
        // For now, we'll just return a success response
        return redirect()->route('contact')->with('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
    }

    /**
     * Display the journal page
     */
    public function journal()
    {
        return view('journal');
    }

    /**
     * API status endpoint
     */
    public function apiStatus()
    {
        return response()->json([
            'success' => true,
            'message' => 'Haven Real Estate API is running',
            'version' => '1.0.0',
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Display the terms of service page
     */
    public function terms()
    {
        return view('legal.terms');
    }

    /**
     * Display the privacy policy page
     */
    public function privacy()
    {
        return view('legal.privacy');
    }
}