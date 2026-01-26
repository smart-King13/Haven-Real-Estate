<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SavedProperty;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use Exception;

class UserDashboardController extends Controller
{
    /**
     * Display user dashboard
     */
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'saved_properties_count' => $user->savedProperties()->count(),
            'payments_count' => $user->payments()->count(),
            'completed_payments' => $user->payments()->completed()->count(),
            'total_spent' => $user->payments()->completed()->sum('amount'),
        ];

        $recentSavedProperties = $user->savedProperties()
            ->with(['category', 'primaryImage'])
            ->latest('saved_properties.created_at')
            ->take(4)
            ->get();

        $recentPayments = $user->payments()
            ->with(['property:id,title,price'])
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentSavedProperties', 'recentPayments'));
    }

    /**
     * Display saved properties
     */
    public function savedProperties()
    {
        try {
            $user = auth()->user();
            
            $savedProperties = $user->savedProperties()
                ->with(['category', 'primaryImage'])
                ->where('properties.is_active', true)
                ->paginate(12);

            return view('user.saved-properties', compact('savedProperties'));
        } catch (\Exception $e) {
            // Log the error and show a user-friendly message
            \Log::error('Saved Properties Error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Fallback: try without the active filtering
            try {
                $user = auth()->user();
                $savedProperties = $user->savedProperties()
                    ->with(['category', 'primaryImage'])
                    ->paginate(12);
                return view('user.saved-properties', compact('savedProperties'));
            } catch (\Exception $fallbackError) {
                return back()->with('error', 'Unable to load saved properties. Please try again.');
            }
        }
    }

    /**
     * Remove saved property
     */
    public function removeSavedProperty(Property $property)
    {
        $user = auth()->user();
        
        $savedProperty = SavedProperty::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->first();

        if ($savedProperty) {
            $savedProperty->delete();
            return redirect()->back()->with('success', 'Property removed from favorites');
        }

        return redirect()->back()->with('error', 'Property not found in favorites');
    }

    /**
     * Display payment history
     */
    public function paymentHistory()
    {
        $user = auth()->user();
        
        $payments = $user->payments()
            ->with(['property:id,title,price,type'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.payment-history', compact('payments'));
    }

    /**
     * Display profile edit form
     */
    public function editProfile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
            
            // Windows fix: Copy file to public storage
            $sourcePath = storage_path('app/public/' . $avatarPath);
            $destPath = public_path('storage/' . $avatarPath);
            $destDir = dirname($destPath);
            
            if (!file_exists($destDir)) {
                mkdir($destDir, 0755, true);
            }
            
            if (file_exists($sourcePath)) {
                copy($sourcePath, $destPath);
            }
        }

        $user->update($data);

        return redirect()->route('user.profile.edit')->with('success', 'Profile updated successfully');
    }
}