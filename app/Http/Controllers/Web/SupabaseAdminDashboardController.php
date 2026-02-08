<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupabaseAdminDashboardController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Admin dashboard
     */
    public function index()
    {
        try {
            // Get total counts
            $totalUsers = $this->supabase->count('profiles');
            $totalProperties = $this->supabase->count('properties');
            $totalPayments = $this->supabase->count('payments');
            $totalCategories = $this->supabase->count('categories');

            // Get payments for revenue calculation
            $paymentsResponse = $this->supabase->select('payments', '*', [
                'status' => 'completed'
            ]);
            $completedPayments = $paymentsResponse->data ?? [];
            
            $totalRevenue = 0;
            foreach ($completedPayments as $payment) {
                $totalRevenue += $payment->amount;
            }

            // Get pending payments
            $pendingPayments = $this->supabase->count('payments', ['status' => 'pending']);

            // Get recent properties
            $recentPropertiesResponse = $this->supabase->select('properties', '*', [], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 5
            ]);
            $recentProperties = $recentPropertiesResponse->data ?? [];

            // Get images and user data for recent properties
            foreach ($recentProperties as &$property) {
                // Convert to object if array
                $prop = is_array($property) ? (object)$property : $property;
                
                // Get primary image
                $imagesResponse = $this->supabase->select('property_images', '*', [
                    'property_id' => $prop->id
                ], ['limit' => 1]);
                $images = $imagesResponse->data ?? [];
                
                // Get user/owner data
                $user = $this->supabase->getUserProfile($prop->user_id);
                
                // Store back to property
                if (is_array($property)) {
                    $property['primaryImage'] = !empty($images) ? $images[0] : null;
                    $property['user'] = $user;
                } else {
                    $property->primaryImage = !empty($images) ? $images[0] : null;
                    $property->user = $user;
                }
            }

            // Get recent payments
            $recentPaymentsResponse = $this->supabase->select('payments', '*', [], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 5
            ]);
            $recentPayments = $recentPaymentsResponse->data ?? [];

            // Get property details for recent payments
            foreach ($recentPayments as &$payment) {
                // Convert to object if array
                $pay = is_array($payment) ? (object)$payment : $payment;
                
                $property = $this->supabase->findOne('properties', ['id' => $pay->property_id]);
                $user = $this->supabase->getUserProfile($pay->user_id);
                
                // Store back to payment
                if (is_array($payment)) {
                    $payment['property'] = $property;
                    $payment['user'] = $user;
                } else {
                    $payment->property = $property;
                    $payment->user = $user;
                }
            }

            $stats = [
                'users' => [
                    'total' => $totalUsers,
                    'active' => $totalUsers,
                ],
                'properties' => [
                    'total' => $totalProperties,
                    'active' => $totalProperties,
                ],
                'payments' => [
                    'total' => $totalPayments,
                    'pending' => $pendingPayments,
                    'completed' => count($completedPayments),
                    'total_revenue' => $totalRevenue,
                ],
                'revenue' => [
                    'total' => $totalRevenue,
                    'monthly' => $totalRevenue,
                ],
                'categories' => $totalCategories,
            ];

            return view('admin.dashboard', compact('stats', 'recentProperties', 'recentPayments'));

        } catch (\Exception $e) {
            $stats = [
                'users' => ['total' => 0, 'active' => 0],
                'properties' => ['total' => 0, 'active' => 0],
                'payments' => ['total' => 0, 'pending' => 0, 'completed' => 0, 'total_revenue' => 0],
                'revenue' => ['total' => 0, 'monthly' => 0],
                'categories' => 0,
            ];
            
            return view('admin.dashboard', [
                'stats' => $stats,
                'recentProperties' => [],
                'recentPayments' => [],
                'error' => 'Failed to load dashboard data'
            ]);
        }
    }

    /**
     * Admin profile
     */
    public function profile()
    {
        $profile = supabase_profile();
        $user = $profile; // Alias for view compatibility
        return view('admin.profile', compact('profile', 'user'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            \Illuminate\Support\Facades\Log::error('Profile validation failed', $validator->errors()->toArray());
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = supabase_user();
            $profile = supabase_profile();

            if (!$user || !$profile) {
                \Illuminate\Support\Facades\Log::error('User or profile not found in session');
                return back()->with('error', 'Session expired. Please login again.')->withInput();
            }

            \Illuminate\Support\Facades\Log::info('Updating profile for user: ' . $user->id);

            $updateData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ];

            // Handle avatar upload to local storage (not Supabase storage)
            if ($request->hasFile('avatar')) {
                try {
                    $avatar = $request->file('avatar');
                    $filename = $user->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();
                    
                    // Store in local public storage - storeAs returns the full path
                    $path = $avatar->storeAs('avatars', $filename, 'public');
                    
                    // Delete old avatar if exists
                    if (isset($profile->avatar) && $profile->avatar) {
                        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($profile->avatar)) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->avatar);
                        }
                    }

                    $updateData['avatar'] = $path; // This will be "avatars/filename.jpg"
                    \Illuminate\Support\Facades\Log::info('Avatar uploaded: ' . $path);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Avatar upload failed: ' . $e->getMessage());
                    return back()->with('error', 'Failed to upload avatar: ' . $e->getMessage())->withInput();
                }
            }

            // Update profile in Supabase
            \Illuminate\Support\Facades\Log::info('Updating profile data', $updateData);
            $result = $this->supabase->updateUserProfile($user->id, $updateData);
            \Illuminate\Support\Facades\Log::info('Profile update result', ['result' => $result]);

            // Fetch fresh profile data from Supabase
            sleep(1); // Give Supabase a moment to process the update
            $updatedProfile = $this->supabase->getUserProfile($user->id);
            
            if ($updatedProfile) {
                // Convert to object if it's an array
                $profileObject = is_array($updatedProfile) ? (object)$updatedProfile : $updatedProfile;
                
                // Update session with fresh profile
                $request->session()->put('supabase_profile', $profileObject);
                $request->session()->save(); // Force session save
                
                \Illuminate\Support\Facades\Log::info('Session updated with new profile', [
                    'avatar' => $profileObject->avatar ?? 'none',
                    'name' => $profileObject->name ?? 'none'
                ]);
            } else {
                \Illuminate\Support\Facades\Log::warning('Could not fetch updated profile from Supabase');
            }

            return back()->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Profile update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to update profile: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * List all users
     */
    public function users()
    {
        try {
            $usersResponse = $this->supabase->select('profiles', '*', [], [
                'order' => ['column' => 'created_at', 'ascending' => false]
            ]);
            $users = $usersResponse->data ?? [];

            return view('admin.users.index', compact('users'));

        } catch (\Exception $e) {
            return view('admin.users.index', [
                'users' => [],
                'error' => 'Failed to load users'
            ]);
        }
    }

    /**
     * Toggle user active status
     */
    public function toggleUserStatus($userId)
    {
        try {
            \Illuminate\Support\Facades\Log::info('Toggling user status for user: ' . $userId);
            
            // Get current user status
            $user = $this->supabase->findOne('profiles', ['id' => $userId]);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $currentStatus = $user->is_active ?? true;
            $newStatus = !$currentStatus;

            // Update user status - use service key to bypass RLS
            $this->supabase->update('profiles', [
                'is_active' => $newStatus
            ], ['id' => $userId], true);

            \Illuminate\Support\Facades\Log::info('User status updated', [
                'user_id' => $userId,
                'old_status' => $currentStatus,
                'new_status' => $newStatus
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully',
                'is_active' => $newStatus
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Toggle user status error: ' . $e->getMessage(), [
                'user_id' => $userId,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all properties
     */
    /**
     * List all properties
     */
    public function properties()
    {
        try {
            $propertiesResponse = $this->supabase->select('properties', '*', [], [
                'order' => ['column' => 'created_at', 'ascending' => false]
            ]);
            $properties = $propertiesResponse->data ?? [];
            
            \Log::info('Properties fetched', ['count' => count($properties)]);

            // Get images for each property
            foreach ($properties as &$property) {
                // Convert to object if array
                $prop = is_array($property) ? (object)$property : $property;
                
                $imagesResponse = $this->supabase->select('property_images', '*', [
                    'property_id' => $prop->id
                ], ['limit' => 1]);
                
                // Store images back to property
                if (is_array($property)) {
                    $property['images'] = $imagesResponse->data ?? [];
                } else {
                    $property->images = $imagesResponse->data ?? [];
                }
            }

            return view('admin.properties.index', compact('properties'));

        } catch (\Exception $e) {
            \Log::error('Properties list error: ' . $e->getMessage());
            return view('admin.properties.index', [
                'properties' => [],
                'error' => 'Failed to load properties: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * List all categories
     */
    public function categories()
    {
        try {
            $categoriesResponse = $this->supabase->select('categories', '*', [], [
                'order' => ['column' => 'name', 'ascending' => true]
            ]);
            $categories = $categoriesResponse->data ?? [];

            return view('admin.categories.index', compact('categories'));

        } catch (\Exception $e) {
            return view('admin.categories.index', [
                'categories' => [],
                'error' => 'Failed to load categories'
            ]);
        }
    }

    /**
     * List all payments
     */
    public function payments()
    {
        try {
            $paymentsResponse = $this->supabase->select('payments', '*', [], [
                'order' => ['column' => 'created_at', 'ascending' => false]
            ]);
            $payments = $paymentsResponse->data ?? [];

            // Get property and user details for each payment
            foreach ($payments as &$payment) {
                // Convert to object if array
                $pay = is_array($payment) ? (object)$payment : $payment;
                
                $property = $this->supabase->findOne('properties', ['id' => $pay->property_id]);
                $user = $this->supabase->getUserProfile($pay->user_id);
                
                // Store back to payment
                if (is_array($payment)) {
                    $payment['property'] = $property;
                    $payment['user'] = $user;
                } else {
                    $payment->property = $property;
                    $payment->user = $user;
                }
            }

            return view('admin.payments.index', compact('payments'));

        } catch (\Exception $e) {
            return view('admin.payments.index', [
                'payments' => [],
                'error' => 'Failed to load payments'
            ]);
        }
    }

    /**
     * Create notification
     */
    public function createNotification()
    {
        try {
            // Get all users for recipient selection
            $usersResponse = $this->supabase->select('profiles', 'id,name', [
                'is_active' => true
            ]);
            $users = $usersResponse->data ?? [];

            return view('admin.notifications.create', compact('users'));

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load notification form');
        }
    }

    /**
     * Store notification
     */
    public function storeNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
            'send_to' => 'required|in:all,specific',
            'user_ids' => 'required_if:send_to,specific|array',
            'user_ids.*' => 'exists:profiles,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            if ($request->send_to === 'all') {
                // Create one notification for broadcast
                $this->supabase->insert('notifications', [
                    'title' => $request->title,
                    'message' => $request->message,
                    'type' => $request->type,
                    'send_to_all' => true,
                ]);
            } else {
                // Create individual notifications for selected users
                foreach ($request->user_ids as $userId) {
                    $this->supabase->insert('notifications', [
                        'user_id' => $userId,
                        'title' => $request->title,
                        'message' => $request->message,
                        'type' => $request->type,
                        'send_to_all' => false,
                    ]);
                }
            }

            return redirect()->route('admin.notifications.index')
                ->with('success', 'Notification sent successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send notification: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * List all notifications
     */
    public function notifications()
    {
        try {
            $notificationsResponse = $this->supabase->select('notifications', '*', [], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 50
            ]);
            $notifications = $notificationsResponse->data ?? [];

            // Calculate stats
            $stats = [
                'total' => count($notifications),
                'unread' => 0,
                'read' => 0,
                'today' => 0,
            ];
            
            $today = date('Y-m-d');
            foreach ($notifications as $notification) {
                $n = is_array($notification) ? (object)$notification : $notification;
                if (isset($n->read) && $n->read) {
                    $stats['read']++;
                } else {
                    $stats['unread']++;
                }
                
                // Count today's notifications
                if (isset($n->created_at)) {
                    $notificationDate = date('Y-m-d', strtotime($n->created_at));
                    if ($notificationDate === $today) {
                        $stats['today']++;
                    }
                }
            }

            return view('admin.notifications.index', compact('notifications', 'stats'));

        } catch (\Exception $e) {
            $stats = ['total' => 0, 'unread' => 0, 'read' => 0, 'today' => 0];
            return view('admin.notifications.index', [
                'notifications' => [],
                'stats' => $stats,
                'error' => 'Failed to load notifications'
            ]);
        }
    }

    /**
     * Delete notification
     */
    public function deleteNotification($id)
    {
        try {
            $this->supabase->delete('notifications', ['id' => $id]);

            return back()->with('success', 'Notification deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete notification');
        }
    }

    /**
     * Show create property form
     */
    public function createProperty()
    {
        try {
            // Get categories for dropdown
            $categoriesResponse = $this->supabase->select('categories', '*', [], [
                'order' => ['column' => 'name', 'ascending' => true]
            ]);
            $categories = $categoriesResponse->data ?? [];

            return view('admin.properties.create', compact('categories'));

        } catch (\Exception $e) {
            return redirect()->route('admin.properties.index')
                ->with('error', 'Failed to load create form');
        }
    }

    /**
     * Store new property
     */
    public function storeProperty(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'type' => 'required|in:sale,rent',
            'status' => 'required|in:available,sold,rented,pending',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area' => 'required|numeric|min:0',
            'property_type' => 'required|string',
            'category_id' => 'required|integer',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = session('supabase_user');
            
            // Generate slug from title
            $slug = \Illuminate\Support\Str::slug($request->title);
            
            // Make slug unique by appending timestamp if needed
            $existingProperty = $this->supabase->select('properties', 'id', [
                'slug' => $slug
            ]);
            
            if (!empty($existingProperty->data)) {
                $slug = $slug . '-' . time();
            }
            
            // Create property
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
                'category_id' => $request->category_id,
                'user_id' => $user->id,
                'is_featured' => $request->has('is_featured'),
                'is_active' => true,
                'features' => $request->features ? json_encode($request->features) : null,
            ];

            $result = $this->supabase->insert('properties', $propertyData, true);
            $property = isset($result->data[0]) ? (is_array($result->data[0]) ? (object)$result->data[0] : $result->data[0]) : null;

            // Handle image uploads
            if ($request->hasFile('images') && $property) {
                foreach ($request->file('images') as $index => $image) {
                    $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('properties', $filename, 'public');

                    $this->supabase->insert('property_images', [
                        'property_id' => $property->id,
                        'image_path' => $path,
                        'is_primary' => $index === 0,
                    ], true);
                }
            }

            return redirect()->route('admin.properties.index')
                ->with('success', 'Property created successfully!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Property creation error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create property: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show edit property form
     */
    public function editProperty($id)
    {
        try {
            $property = $this->supabase->findOne('properties', ['id' => $id]);
            
            if (!$property) {
                return redirect()->route('admin.properties.index')
                    ->with('error', 'Property not found');
            }

            // Get categories
            $categoriesResponse = $this->supabase->select('categories', '*', [], [
                'order' => ['column' => 'name', 'ascending' => true]
            ]);
            $categories = $categoriesResponse->data ?? [];

            // Get property images
            $imagesResponse = $this->supabase->select('property_images', '*', [
                'property_id' => $id
            ]);
            $images = $imagesResponse->data ?? [];

            return view('admin.properties.edit', compact('property', 'categories', 'images'));

        } catch (\Exception $e) {
            return redirect()->route('admin.properties.index')
                ->with('error', 'Failed to load property');
        }
    }

    /**
     * Update property
     */
    public function updateProperty(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'type' => 'required|in:sale,rent',
            'status' => 'required|in:available,sold,rented,pending',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'area' => 'required|numeric|min:0',
            'property_type' => 'required|string',
            'category_id' => 'required|integer',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Get current property to check if title changed
            $currentProperty = $this->supabase->findOne('properties', ['id' => $id]);
            
            $propertyData = [
                'title' => $request->title,
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
                'category_id' => $request->category_id,
                'is_featured' => $request->has('is_featured'),
                'features' => $request->features ? json_encode($request->features) : null,
            ];
            
            // Update slug if title changed
            if ($currentProperty && $currentProperty->title !== $request->title) {
                $slug = \Illuminate\Support\Str::slug($request->title);
                
                // Make slug unique if needed
                $existingProperty = $this->supabase->select('properties', 'id', [
                    'slug' => $slug
                ]);
                
                if (!empty($existingProperty->data)) {
                    $slug = $slug . '-' . time();
                }
                
                $propertyData['slug'] = $slug;
            }

            $this->supabase->update('properties', $propertyData, ['id' => $id]);

            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('properties', $filename, 'public');

                    $this->supabase->insert('property_images', [
                        'property_id' => $id,
                        'image_path' => $path,
                        'is_primary' => false,
                    ], true);
                }
            }

            return redirect()->route('admin.properties.index')
                ->with('success', 'Property updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update property')->withInput();
        }
    }

    /**
     * Delete property
     */
    public function deleteProperty($id)
    {
        try {
            \Illuminate\Support\Facades\Log::info('Attempting to delete property: ' . $id);
            
            // First, check if property exists
            $property = $this->supabase->findOne('properties', ['id' => $id]);
            if (!$property) {
                \Illuminate\Support\Facades\Log::warning('Property not found: ' . $id);
                return back()->with('error', 'Property not found');
            }
            
            // Delete saved properties (user favorites) first - use service key to bypass RLS
            try {
                $this->supabase->delete('saved_properties', ['property_id' => $id], true);
                \Illuminate\Support\Facades\Log::info('Deleted saved_properties for property: ' . $id);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('No saved_properties to delete or error: ' . $e->getMessage());
            }
            
            // Delete payments related to this property - use service key to bypass RLS
            try {
                $this->supabase->delete('payments', ['property_id' => $id], true);
                \Illuminate\Support\Facades\Log::info('Deleted payments for property: ' . $id);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('No payments to delete or error: ' . $e->getMessage());
            }
            
            // Delete property images from storage
            $imagesResponse = $this->supabase->select('property_images', '*', [
                'property_id' => $id
            ]);
            $images = $imagesResponse->data ?? [];

            \Illuminate\Support\Facades\Log::info('Found ' . count($images) . ' images to delete');

            foreach ($images as $image) {
                $img = is_array($image) ? (object)$image : $image;
                if (isset($img->image_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($img->image_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image_path);
                    \Illuminate\Support\Facades\Log::info('Deleted image file: ' . $img->image_path);
                }
            }

            // Delete property images from database - use service key to bypass RLS
            try {
                $this->supabase->delete('property_images', ['property_id' => $id], true);
                \Illuminate\Support\Facades\Log::info('Deleted property_images from database');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('No property_images to delete or error: ' . $e->getMessage());
            }

            // Finally, delete the property itself - use service key to bypass RLS
            $this->supabase->delete('properties', ['id' => $id], true);
            \Illuminate\Support\Facades\Log::info('Deleted property from database');

            return redirect()->route('admin.properties.index')
                ->with('success', 'Property deleted successfully!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Property deletion error: ' . $e->getMessage(), [
                'property_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to delete property: ' . $e->getMessage());
        }
    }

    /**
     * Store category
     */
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $this->supabase->insert('categories', [
                'name' => $request->name,
                'description' => $request->description,
                'slug' => \Illuminate\Support\Str::slug($request->name),
            ], true);

            return back()->with('success', 'Category created successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create category');
        }
    }

    /**
     * Update category
     */
    public function updateCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $this->supabase->update('categories', [
                'name' => $request->name,
                'description' => $request->description,
                'slug' => \Illuminate\Support\Str::slug($request->name),
            ], ['id' => $id]);

            return back()->with('success', 'Category updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update category');
        }
    }

    /**
     * Set primary image for property
     */
    public function setPrimaryImage($propertyId, $imageId)
    {
        try {
            // First, unset all primary images for this property
            $this->supabase->update('property_images', [
                'is_primary' => false
            ], ['property_id' => $propertyId]);

            // Then set the selected image as primary
            $this->supabase->update('property_images', [
                'is_primary' => true
            ], ['id' => $imageId]);

            return back()->with('success', 'Primary image updated successfully!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Set primary image error: ' . $e->getMessage());
            return back()->with('error', 'Failed to set primary image');
        }
    }

    /**
     * Delete property image
     */
    public function deleteImage($propertyId, $imageId)
    {
        try {
            // Get the image details
            $image = $this->supabase->findOne('property_images', ['id' => $imageId]);
            
            if (!$image) {
                return back()->with('error', 'Image not found');
            }

            // Convert to object if array
            $img = is_array($image) ? (object)$image : $image;

            // Delete from storage
            if (isset($img->image_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($img->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image_path);
            }

            // Delete from database
            $this->supabase->delete('property_images', ['id' => $imageId]);

            // If this was the primary image, set another image as primary
            if ($img->is_primary) {
                $remainingImages = $this->supabase->select('property_images', '*', [
                    'property_id' => $propertyId
                ], ['limit' => 1]);

                if (!empty($remainingImages->data)) {
                    $firstImage = is_array($remainingImages->data[0]) ? (object)$remainingImages->data[0] : $remainingImages->data[0];
                    $this->supabase->update('property_images', [
                        'is_primary' => true
                    ], ['id' => $firstImage->id]);
                }
            }

            return back()->with('success', 'Image deleted successfully!');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Delete image error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete image');
        }
    }
}
