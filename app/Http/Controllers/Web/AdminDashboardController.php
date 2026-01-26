<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'active' => User::where('is_active', true)->count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ],
            'properties' => [
                'total' => Property::count(),
                'active' => Property::active()->count(),
                'available' => Property::available()->count(),
                'sold' => Property::where('status', 'sold')->count(),
                'rented' => Property::where('status', 'rented')->count(),
            ],
            'payments' => [
                'total' => Payment::count(),
                'completed' => Payment::completed()->count(),
                'pending' => Payment::pending()->count(),
                'total_revenue' => Payment::completed()->sum('amount'),
                'monthly_revenue' => Payment::completed()
                    ->whereMonth('paid_at', now()->month)
                    ->whereYear('paid_at', now()->year)
                    ->sum('amount'),
            ],
        ];

        $recentProperties = Property::with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with(['property:id,title', 'user:id,name'])
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::select('id', 'name', 'email', 'created_at')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProperties', 'recentPayments', 'recentUsers'));
    }

    /**
     * Display properties management
     */
    public function properties(Request $request)
    {
        $query = Property::with(['category', 'user', 'primaryImage']);

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $properties = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::all();

        return view('admin.properties.index', compact('properties', 'categories'));
    }

    /**
     * Show create property form
     */
    public function createProperty()
    {
        $categories = Category::active()->get();
        return view('admin.properties.create', compact('categories'));
    }

    /**
     * Store new property
     */
    public function storeProperty(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Attempting to store property', $request->all());

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'type' => 'required|in:rent,sale',
            'status' => 'required|in:available,sold,rented,pending',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'property_type' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $property = Property::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'location' => $request->location,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'type' => $request->type,
            'status' => $request->status,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'area' => $request->area,
            'property_type' => $request->property_type,
            'features' => $request->features,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            try {
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('properties', 'public');
                    
                    $property->images()->create([
                        'image_path' => $imagePath,
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Image upload failed for property ' . $property->id . ': ' . $e->getMessage());
                // Continue without failing the whole request, but maybe flash a warning?
                // For now, we prefer the property to exist so the user doesn't lose data.
            }
        }

        return redirect()->route('admin.properties.index')->with('success', 'Property created successfully');
    }

    /**
     * Show edit property form
     */
    public function editProperty($id)
    {
        $property = Property::with('images')->findOrFail($id);
        $categories = Category::active()->get();
        return view('admin.properties.edit', compact('property', 'categories'));
    }

    /**
     * Update property
     */
    public function updateProperty(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'type' => 'required|in:rent,sale',
            'status' => 'required|in:available,sold,rented,pending',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'property_type' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $property->update($request->only([
            'title', 'description', 'price', 'location', 'address',
            'latitude', 'longitude', 'type', 'status', 'bedrooms',
            'bathrooms', 'area', 'property_type', 'features',
            'category_id', 'is_featured', 'is_active'
        ]));

        return redirect()->route('admin.properties.index')->with('success', 'Property updated successfully');
    }

    /**
     * Delete property
     */
    public function deleteProperty($id)
    {
        $property = Property::findOrFail($id);

        // Delete associated images from storage
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $property->delete();

        return redirect()->route('admin.properties.index')->with('success', 'Property deleted successfully');
    }

    /**
     * Display users management
     */
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $active = $request->status === 'active';
            $query->where('is_active', $active);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display payments management
     */
    public function payments(Request $request)
    {
        $query = Payment::with(['property:id,title', 'user:id,name,email']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Display categories management
     */
    public function categories()
    {
        $categories = Category::withCount('properties')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store new category
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Update category
     */
    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Display admin profile
     */
    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address', 'bio']);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
                // Also delete from public storage
                $oldPublicPath = public_path('storage/' . $user->avatar);
                if (file_exists($oldPublicPath)) {
                    unlink($oldPublicPath);
                }
            }
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

        return redirect()->route('admin.profile')->with('success', 'Admin profile updated successfully');
    }
}
