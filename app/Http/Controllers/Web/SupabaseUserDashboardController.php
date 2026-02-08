<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupabaseUserDashboardController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * User dashboard
     */
    public function index()
    {
        try {
            $user = supabase_user();
            $profile = supabase_profile();

            // Get saved properties count
            $savedCount = $this->supabase->count('saved_properties', ['user_id' => $user->id]);

            // Get payments count and total
            $paymentsResponse = $this->supabase->select('payments', '*', ['user_id' => $user->id]);
            $payments = $paymentsResponse->data ?? [];
            
            $totalPayments = count($payments);
            $completedPayments = 0;
            $pendingPayments = 0;
            $totalSpent = 0;

            foreach ($payments as $payment) {
                if ($payment->status === 'completed') {
                    $completedPayments++;
                    $totalSpent += $payment->amount;
                } elseif ($payment->status === 'pending') {
                    $pendingPayments++;
                }
            }

            // Get recent notifications
            $notificationsResponse = $this->supabase->select('notifications', '*', [
                'user_id' => $user->id
            ], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 5
            ]);
            $recentNotifications = $notificationsResponse->data ?? [];

            // Get unread notifications count
            $unreadCount = $this->supabase->count('notifications', [
                'user_id' => $user->id,
                'is_read' => false
            ]);

            // Get recent saved properties
            $savedPropertiesResponse = $this->supabase->select('saved_properties', '*', [
                'user_id' => $user->id
            ], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 5
            ]);
            $savedPropertiesData = $savedPropertiesResponse->data ?? [];
            
            // Get property details for saved properties
            $recentSavedProperties = [];
            foreach ($savedPropertiesData as $saved) {
                $savedObj = is_array($saved) ? (object)$saved : $saved;
                $property = $this->supabase->findOne('properties', ['id' => $savedObj->property_id]);
                if ($property) {
                    $prop = is_array($property) ? (object)$property : $property;
                    // Get primary image
                    $imageResponse = $this->supabase->select('property_images', '*', [
                        'property_id' => $prop->id,
                        'is_primary' => true
                    ], ['limit' => 1]);
                    $prop->primaryImage = isset($imageResponse->data[0]) ? (is_array($imageResponse->data[0]) ? (object)$imageResponse->data[0] : $imageResponse->data[0]) : null;
                    $recentSavedProperties[] = $prop;
                }
            }

            // Get recent payments (limit to 5)
            $recentPaymentsResponse = $this->supabase->select('payments', '*', [
                'user_id' => $user->id
            ], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 5
            ]);
            $recentPayments = $recentPaymentsResponse->data ?? [];
            // Convert to objects
            $recentPayments = array_map(function($payment) {
                return is_array($payment) ? (object)$payment : $payment;
            }, $recentPayments);

            $stats = [
                'saved_properties_count' => $savedCount,
                'payments_count' => $totalPayments,
                'completed_payments' => $completedPayments,
                'pending_payments' => $pendingPayments,
                'total_spent' => $totalSpent,
                'unread_notifications' => $unreadCount,
            ];

            return view('user.dashboard', compact('profile', 'stats', 'recentNotifications', 'recentSavedProperties', 'recentPayments'));

        } catch (\Exception $e) {
            \Log::error('User dashboard error: ' . $e->getMessage());
            return view('user.dashboard', [
                'profile' => supabase_profile(),
                'stats' => [
                    'saved_properties_count' => 0,
                    'payments_count' => 0,
                    'completed_payments' => 0,
                    'pending_payments' => 0,
                    'total_spent' => 0,
                    'unread_notifications' => 0,
                ],
                'recentNotifications' => [],
                'recentSavedProperties' => [],
                'recentPayments' => [],
                'error' => 'Failed to load dashboard data'
            ]);
        }
    }

    /**
     * Show edit profile page
     */
    public function editProfile()
    {
        $user = supabase_user();
        $profile = supabase_profile();
        return view('user.profile', compact('profile', 'user'));
    }

    /**
     * Show profile page
     */
    public function profile()
    {
        $user = supabase_user();
        $profile = supabase_profile();
        return view('user.profile', compact('profile', 'user'));
    }

    /**
     * Show saved properties
     */
    public function savedProperties()
    {
        try {
            $user = supabase_user();

            // Get saved properties
            $savedResponse = $this->supabase->select('saved_properties', '*', [
                'user_id' => $user->id
            ], [
                'order' => ['column' => 'created_at', 'ascending' => false]
            ]);
            
            $savedData = $savedResponse->data ?? [];
            
            // Get property details for each saved property
            $properties = [];
            foreach ($savedData as $saved) {
                $savedObj = is_array($saved) ? (object)$saved : $saved;
                $property = $this->supabase->findOne('properties', ['id' => $savedObj->property_id]);
                
                if ($property) {
                    $prop = is_array($property) ? (object)$property : $property;
                    
                    // Get primary image
                    $imageResponse = $this->supabase->select('property_images', '*', [
                        'property_id' => $prop->id,
                        'is_primary' => true
                    ], ['limit' => 1]);
                    
                    $prop->primaryImage = isset($imageResponse->data[0]) ? 
                        (is_array($imageResponse->data[0]) ? (object)$imageResponse->data[0] : $imageResponse->data[0]) : null;
                    
                    $properties[] = $prop;
                }
            }

            return view('user.saved-properties', compact('properties'));

        } catch (\Exception $e) {
            \Log::error('Saved properties error: ' . $e->getMessage());
            return view('user.saved-properties', [
                'properties' => [],
                'error' => 'Failed to load saved properties'
            ]);
        }
    }

    /**
     * Remove saved property
     */
    public function removeSavedProperty($propertyId)
    {
        try {
            $user = supabase_user();
            
            $this->supabase->delete('saved_properties', [
                'user_id' => $user->id,
                'property_id' => $propertyId
            ]);

            return redirect()->back()->with('success', 'Property removed from saved list');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove property');
        }
    }

    /**
     * Show payment history
     */
    public function paymentHistory()
    {
        try {
            $user = supabase_user();

            // Get all payments for user
            $paymentsResponse = $this->supabase->select('payments', '*', [
                'user_id' => $user->id
            ], [
                'order' => ['column' => 'created_at', 'ascending' => false]
            ]);
            
            $payments = $paymentsResponse->data ?? [];
            
            // Convert to objects and get property details
            $payments = array_map(function($payment) {
                $pay = is_array($payment) ? (object)$payment : $payment;
                
                // Get property details if property_id exists
                if (isset($pay->property_id)) {
                    $property = $this->supabase->findOne('properties', ['id' => $pay->property_id]);
                    $pay->property = $property ? (is_array($property) ? (object)$property : $property) : null;
                }
                
                return $pay;
            }, $payments);

            return view('user.payment-history', compact('payments'));

        } catch (\Exception $e) {
            \Log::error('Payment history error: ' . $e->getMessage());
            return view('user.payment-history', [
                'payments' => [],
                'error' => 'Failed to load payment history'
            ]);
        }
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = supabase_user();
            $profile = supabase_profile();

            $updateData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ];

            // Handle avatar upload to local storage
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = $user->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();
                
                // Store in public/storage/avatars
                $path = $avatar->storeAs('avatars', $filename, 'public');
                
                \Log::info('Avatar uploaded', [
                    'filename' => $filename,
                    'path' => $path,
                    'user_id' => $user->id
                ]);

                // Delete old avatar if exists
                if (isset($profile->avatar) && $profile->avatar) {
                    try {
                        \Storage::disk('public')->delete($profile->avatar);
                        \Log::info('Old avatar deleted', ['old_path' => $profile->avatar]);
                    } catch (\Exception $e) {
                        \Log::warning('Failed to delete old avatar', ['error' => $e->getMessage()]);
                    }
                }

                $updateData['avatar'] = $path;
            }

            \Log::info('Updating profile in Supabase', [
                'user_id' => $user->id,
                'update_data' => $updateData
            ]);

            // Update profile in Supabase
            $result = $this->supabase->updateUserProfile($user->id, $updateData);
            
            \Log::info('Profile update result', ['result' => $result]);

            // Small delay to ensure database is updated
            usleep(500000); // 0.5 seconds

            // Update session with fresh data
            $updatedProfile = $this->supabase->getUserProfile($user->id);
            
            \Log::info('Updated profile from database', [
                'profile' => $updatedProfile,
                'avatar' => $updatedProfile->avatar ?? 'not set'
            ]);
            
            $request->session()->put('supabase_profile', $updatedProfile);
            
            // Add debug info
            $request->session()->flash('debug_info', [
                'avatar_uploaded' => $request->hasFile('avatar'),
                'avatar_path' => $updateData['avatar'] ?? 'not uploaded',
                'profile_avatar' => $updatedProfile->avatar ?? 'not set in db',
                'file_exists' => isset($updatedProfile->avatar) ? file_exists(storage_path('app/public/' . $updatedProfile->avatar)) : false,
            ]);

            return back()->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Profile update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to update profile: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $token = supabase_token();

            // Verify current password by attempting to sign in
            $verifyResponse = $this->supabase->signIn(
                supabase_user()->email,
                $request->current_password
            );

            if (!$verifyResponse) {
                return back()->with('error', 'Current password is incorrect');
            }

            // Update password
            $this->supabase->updatePassword($token, $request->password);

            return back()->with('success', 'Password changed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to change password. Current password may be incorrect.');
        }
    }

    /**
     * User notifications
     */
    public function notifications()
    {
        try {
            $user = supabase_user();

            // Get user notifications (including broadcast notifications)
            $notificationsResponse = $this->supabase->select('notifications', '*', [], [
                'order' => ['column' => 'created_at', 'ascending' => false]
            ]);
            
            $allNotifications = $notificationsResponse->data ?? [];
            
            // Filter notifications for current user or broadcast
            $notifications = array_filter($allNotifications, function($notification) use ($user) {
                $notif = is_array($notification) ? (object)$notification : $notification;
                return $notif->user_id === $user->id || ($notif->send_to_all ?? false);
            });

            return view('user.notifications', compact('notifications'));

        } catch (\Exception $e) {
            return view('user.notifications', [
                'notifications' => [],
                'error' => 'Failed to load notifications'
            ]);
        }
    }

    /**
     * Mark notification as read
     */
    public function markNotificationRead($id)
    {
        try {
            $this->supabase->update('notifications', [
                'is_read' => true,
                'read_at' => now()->toIso8601String()
            ], ['id' => $id]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsRead()
    {
        try {
            $user = supabase_user();

            // Get all unread notifications for this user
            $unreadResponse = $this->supabase->select('notifications', '*', [
                'user_id' => $user->id,
                'is_read' => false
            ]);
            
            $unreadNotifications = $unreadResponse->data ?? [];
            
            // Update each notification
            foreach ($unreadNotifications as $notification) {
                $notif = is_array($notification) ? (object)$notification : $notification;
                $this->supabase->update('notifications', [
                    'is_read' => true,
                    'read_at' => now()->toIso8601String()
                ], ['id' => $notif->id]);
            }

            return back()->with('success', 'All notifications marked as read');

        } catch (\Exception $e) {
            \Log::error('Mark all notifications read error: ' . $e->getMessage());
            return back()->with('error', 'Failed to mark notifications as read');
        }
    }

    /**
     * Delete notification
     */
    public function deleteNotification($id)
    {
        try {
            $this->supabase->delete('notifications', ['id' => $id]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }
}
