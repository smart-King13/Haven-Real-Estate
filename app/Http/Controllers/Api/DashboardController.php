<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get admin dashboard statistics
     */
    public function adminStats(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $stats = [
            // User statistics
            'users' => [
                'total' => User::count(),
                'active' => User::where('is_active', true)->count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ],

            // Property statistics
            'properties' => [
                'total' => Property::count(),
                'active' => Property::active()->count(),
                'available' => Property::available()->count(),
                'sold' => Property::where('status', 'sold')->count(),
                'rented' => Property::where('status', 'rented')->count(),
                'featured' => Property::featured()->count(),
                'new_this_month' => Property::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ],

            // Payment statistics
            'payments' => [
                'total' => Payment::count(),
                'completed' => Payment::completed()->count(),
                'pending' => Payment::pending()->count(),
                'total_revenue' => Payment::completed()->sum('amount'),
                'monthly_revenue' => Payment::completed()
                    ->whereMonth('paid_at', now()->month)
                    ->whereYear('paid_at', now()->year)
                    ->sum('amount'),
                'this_month' => Payment::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ],

            // Recent activities
            'recent_properties' => Property::with(['category', 'user:id,name'])
                ->latest()
                ->take(5)
                ->get(),

            'recent_payments' => Payment::with(['property:id,title', 'user:id,name'])
                ->latest()
                ->take(5)
                ->get(),

            'recent_users' => User::select('id', 'name', 'email', 'created_at')
                ->latest()
                ->take(5)
                ->get(),
        ];

        // Monthly revenue chart data (last 12 months)
        $monthlyRevenue = Payment::completed()
            ->select(
                DB::raw('YEAR(paid_at) as year'),
                DB::raw('MONTH(paid_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('paid_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $stats['monthly_revenue_chart'] = $monthlyRevenue;

        // Property type distribution
        $propertyTypes = Property::select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->get();

        $stats['property_type_distribution'] = $propertyTypes;

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get user dashboard statistics
     */
    public function userStats(Request $request)
    {
        $user = $request->user();

        $stats = [
            // User's saved properties
            'saved_properties' => [
                'total' => $user->savedProperties()->count(),
                'recent' => $user->savedProperties()
                    ->with(['category', 'primaryImage'])
                    ->latest('saved_properties.created_at')
                    ->take(5)
                    ->get(),
            ],

            // User's payment history
            'payments' => [
                'total' => $user->payments()->count(),
                'completed' => $user->payments()->completed()->count(),
                'pending' => $user->payments()->pending()->count(),
                'total_spent' => $user->payments()->completed()->sum('amount'),
                'recent' => $user->payments()
                    ->with(['property:id,title,price'])
                    ->latest()
                    ->take(5)
                    ->get(),
            ],

            // Recommendations (properties similar to saved ones)
            'recommended_properties' => $this->getRecommendedProperties($user),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get system overview (public stats)
     */
    public function overview()
    {
        $stats = [
            'total_properties' => Property::active()->available()->count(),
            'properties_for_sale' => Property::active()->available()->type('sale')->count(),
            'properties_for_rent' => Property::active()->available()->type('rent')->count(),
            'featured_properties' => Property::active()->available()->featured()->count(),
            'total_users' => User::where('is_active', true)->count(),
            'recent_properties' => Property::with(['category', 'primaryImage'])
                ->active()
                ->available()
                ->latest()
                ->take(6)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get recommended properties for user based on their saved properties
     */
    private function getRecommendedProperties($user)
    {
        // Get user's saved property categories and types
        $savedProperties = $user->savedProperties()->get();
        
        if ($savedProperties->isEmpty()) {
            // If no saved properties, return featured properties
            return Property::with(['category', 'primaryImage'])
                ->active()
                ->available()
                ->featured()
                ->take(5)
                ->get();
        }

        $categoryIds = $savedProperties->pluck('category_id')->unique();
        $types = $savedProperties->pluck('type')->unique();
        $avgPrice = $savedProperties->avg('price');

        // Find similar properties
        $recommendations = Property::with(['category', 'primaryImage'])
            ->active()
            ->available()
            ->where(function ($query) use ($categoryIds, $types, $avgPrice) {
                $query->whereIn('category_id', $categoryIds)
                    ->orWhereIn('type', $types)
                    ->orWhereBetween('price', [$avgPrice * 0.8, $avgPrice * 1.2]);
            })
            ->whereNotIn('id', $savedProperties->pluck('id'))
            ->inRandomOrder()
            ->take(5)
            ->get();

        return $recommendations;
    }
}