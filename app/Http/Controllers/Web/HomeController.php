<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $featuredProperties = Property::with(['category', 'primaryImage'])
            ->active()
            ->available()
            ->featured()
            ->take(6)
            ->get();

        $recentProperties = Property::with(['category', 'primaryImage'])
            ->active()
            ->available()
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::active()->get();

        $stats = [
            'total_properties' => Property::active()->available()->count(),
            'properties_for_sale' => Property::active()->available()->type('sale')->count(),
            'properties_for_rent' => Property::active()->available()->type('rent')->count(),
        ];

        return view('home', compact('featuredProperties', 'recentProperties', 'categories', 'stats'));
    }

    /**
     * Display the about page
     */
    public function about()
    {
        $stats = [
            'total_properties' => Property::active()->available()->count(),
            'verified_properties' => Property::active()->available()->count(), // All properties are verified
            'years_experience' => now()->year - 2024 + 1, // Since 2024
            'client_satisfaction' => 100, // 100% satisfaction rate
        ];

        return view('about', compact('stats'));
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