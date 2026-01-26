<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\PropertyController;
use App\Http\Controllers\Web\UserDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

// Test email functionality
// Email test route moved to line 139

// Test route for debugging saved properties
Route::get('/test-saved-properties', function () {
    try {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Not authenticated']);
        }
        
        // Test basic relationship
        $count = $user->savedProperties()->count();
        
        // Test with conditions
        $savedProperties = $user->savedProperties()
            ->with(['category', 'primaryImage'])
            ->where('properties.is_active', true)
            ->whereNotIn('properties.status', ['draft', 'archived'])
            ->get();
            
        return response()->json([
            'user' => $user->name,
            'count' => $count,
            'saved_properties' => $savedProperties->count(),
            'properties' => $savedProperties->map(function($prop) {
                return [
                    'id' => $prop->id,
                    'title' => $prop->title,
                    'status' => $prop->status,
                    'is_active' => $prop->is_active
                ];
            })
        ]);
    } catch (Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
    }
})->middleware('auth');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::get('/journal', [HomeController::class, 'journal'])->name('journal');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/api/status', [HomeController::class, 'apiStatus']);

// Test route for chat functionality (disabled)
// Route::get('/test-chat', function () {
//     return view('test-chat');
// })->name('test.chat');

Route::get('/debug-csrf', function () {
    return [
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'session_started' => session()->isStarted(),
        'app_key' => config('app.key') ? 'SET' : 'NOT SET',
        'session_driver' => config('session.driver'),
        'session_lifetime' => config('session.lifetime'),
        'app_env' => config('app.env'),
        'app_debug' => config('app.debug'),
    ];
});

Route::get('/create-test-user/{email}', function ($email) {
    try {
        // Check if user already exists
        if (\App\Models\User::where('email', $email)->exists()) {
            return 'User with email ' . $email . ' already exists!';
        }
        
        // Create new user
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);
        
        return 'User created successfully! Email: ' . $user->email . ' | Password: password123';
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/test-password-reset', function () {
    try {
        $email = 'admin@haven.com'; // Use an existing email
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) {
            return 'User not found with email: ' . $email;
        }
        
        $status = \Illuminate\Support\Facades\Password::sendResetLink(['email' => $email]);
        
        return [
            'status' => $status,
            'is_sent' => $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT,
            'user_email' => $user->email,
            'mail_driver' => config('mail.default'),
        ];
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Test email functionality
Route::get('/test-email', function (Request $request) {
    try {
        $email = $request->query('email');
        
        if (!$email && auth()->check()) {
            $email = auth()->user()->email;
        }

        if (!$email) {
            return response()->json([
                'error' => 'Please provide an email address: /test-email?email=you@example.com or login first.'
            ], 400);
        }

        Mail::raw("This is a test email from Haven.\nTimestamp: " . now(), function ($message) use ($email) {
            $message->to($email)
                    ->subject('Haven Email Configuration Test');
        });

        return response()->json([
            'success' => true,
            'message' => "Test email sent successfully to {$email}!",
            'mailer' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'helpful_hint' => 'Check your .env MAIL_USERNAME and MAIL_PASSWORD settings.'
        ], 500);
    }
})->name('test.email');

// Test routes for debugging
Route::get('/test-csrf', function () {
    return view('test-csrf');
});

Route::post('/test-csrf-post', function (Request $request) {
    return back()->with('success', 'CSRF test successful! Data: ' . $request->test);
});

Route::get('/test-session', function () {
    // Start session if not started
    if (!session()->isStarted()) {
        session()->start();
    }
    
    // Set a test value
    session(['test_key' => 'test_value_' . time()]);
    
    return response()->json([
        'session_started' => session()->isStarted(),
        'session_id' => session()->getId(),
        'session_driver' => config('session.driver'),
        'csrf_token' => csrf_token(),
        'test_value' => session('test_key'),
        'app_key' => config('app.key') ? 'Set' : 'Not Set',
        'app_env' => config('app.env'),
        'session_config' => [
            'lifetime' => config('session.lifetime'),
            'path' => config('session.path'),
            'domain' => config('session.domain'),
            'secure' => config('session.secure'),
            'http_only' => config('session.http_only'),
            'same_site' => config('session.same_site'),
        ]
    ]);
});

Route::get('/test-csrf-api', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'session_driver' => config('session.driver'),
        'app_key' => config('app.key') ? 'Set' : 'Not Set',
    ]);
});

// Chat routes
Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');
Route::get('/chat/history', [App\Http\Controllers\ChatController::class, 'getChatHistory'])->name('chat.history');
Route::post('/chat/read', [App\Http\Controllers\ChatController::class, 'markAsRead'])->name('chat.read');
Route::get('/chat/status', [App\Http\Controllers\ChatController::class, 'getOnlineStatus'])->name('chat.status');

// Payment webhook routes (no CSRF protection needed)
Route::post('/webhooks/stripe', [App\Http\Controllers\WebhookController::class, 'stripe'])->name('webhooks.stripe');
Route::post('/webhooks/paystack', [App\Http\Controllers\WebhookController::class, 'paystack'])->name('webhooks.paystack');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Password reset routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/password-reset-sent', function () {
    return view('auth.password-reset-sent');
})->name('password.sent');
Route::post('/resend-password-reset', [AuthController::class, 'resendPasswordReset'])->name('password.resend');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public property routes
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Protected routes
Route::middleware('auth')->group(function () {
    // Property save/unsave
    Route::post('/properties/{property}/toggle-save', [PropertyController::class, 'toggleSave'])->name('properties.toggle-save');
    
    // Payment Flow
    Route::get('/properties/{property}/checkout', [PaymentController::class, 'checkout'])->name('properties.checkout');
    Route::post('/properties/{property}/checkout', [PaymentController::class, 'process'])->name('properties.pay.process');
    Route::get('/payments/{id}/success', [PaymentController::class, 'success'])->name('payments.success');
    Route::get('/payments/{id}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');
    
    // User dashboard routes
    Route::prefix('dashboard')->name('user.')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/saved-properties', [UserDashboardController::class, 'savedProperties'])->name('saved-properties');
        Route::delete('/saved-properties/{property}', [UserDashboardController::class, 'removeSavedProperty'])->name('saved-properties.remove');
        Route::get('/payment-history', [UserDashboardController::class, 'paymentHistory'])->name('payment-history');
        Route::get('/profile', [UserDashboardController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
        
        // User notifications
        Route::get('/notifications', [App\Http\Controllers\Web\UserNotificationController::class, 'index'])->name('notifications');
        Route::get('/notifications/get', [App\Http\Controllers\Web\UserNotificationController::class, 'getNotifications'])->name('notifications.get');
        Route::post('/notifications/{id}/read', [App\Http\Controllers\Web\UserNotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/read-all', [App\Http\Controllers\Web\UserNotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
        Route::delete('/notifications/{id}', [App\Http\Controllers\Web\UserNotificationController::class, 'destroy'])->name('notifications.destroy');
        
        Route::get('/messages', function () {
            return view('user.messages');
        })->name('messages');
    });
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Chat management
        Route::get('/chat', function () {
            return view('admin.chat.index');
        })->name('chat.index');
        Route::get('/chat/sessions', [App\Http\Controllers\ChatController::class, 'getAdminChatSessions'])->name('chat.sessions');
        Route::get('/chat/sessions/{sessionId}/messages', [App\Http\Controllers\ChatController::class, 'getSessionMessages'])->name('chat.messages');
        Route::post('/chat/sessions/{sessionId}/send', [App\Http\Controllers\ChatController::class, 'sendAdminMessage'])->name('chat.send');
        Route::post('/chat/sessions/{sessionId}/read', [App\Http\Controllers\ChatController::class, 'markAsRead'])->name('chat.mark-read');
        Route::get('/chat/statistics', [App\Http\Controllers\ChatController::class, 'getChatStatistics'])->name('chat.statistics');
        
        // Properties management
        Route::prefix('properties')->name('properties.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'properties'])->name('index');
            Route::get('/create', [AdminDashboardController::class, 'createProperty'])->name('create');
            Route::post('/', [AdminDashboardController::class, 'storeProperty'])->name('store');
            Route::get('/{id}/edit', [AdminDashboardController::class, 'editProperty'])->name('edit');
            Route::put('/{id}', [AdminDashboardController::class, 'updateProperty'])->name('update');
            Route::delete('/{id}', [AdminDashboardController::class, 'deleteProperty'])->name('destroy');
        });
        
        // Users management
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');
        
        // Payments management
        Route::get('/payments', [AdminDashboardController::class, 'payments'])->name('payments.index');
        
        // Categories management
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'categories'])->name('index');
            Route::post('/', [AdminDashboardController::class, 'storeCategory'])->name('store');
            Route::put('/{id}', [AdminDashboardController::class, 'updateCategory'])->name('update');
        });

        // Profile management
        Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminDashboardController::class, 'updateProfile'])->name('profile.update');
        
        // Notifications management
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [App\Http\Controllers\Web\NotificationController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Web\NotificationController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Web\NotificationController::class, 'store'])->name('store');
            Route::delete('/{id}', [App\Http\Controllers\Web\NotificationController::class, 'destroy'])->name('destroy');
            Route::delete('/', [App\Http\Controllers\Web\NotificationController::class, 'destroyAll'])->name('destroy-all');
        });
    });
});

// Alias for profile routes (backward compatibility)
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [UserDashboardController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
});

// Image diagnostic route
Route::get('/test-images-laravel', function () {
    $images = App\Models\PropertyImage::with('property')->get();
    
    $html = '<!DOCTYPE html><html><head><title>Laravel Image Test</title></head><body>';
    $html .= '<h1>Laravel Image Diagnostic</h1>';
    $html .= '<p><strong>APP_URL:</strong> ' . config('app.url') . '</p>';
    $html .= '<p><strong>Storage URL:</strong> ' . asset('storage') . '</p>';
    $html .= '<p><strong>Filesystem Disk:</strong> ' . config('filesystems.default') . '</p>';
    
    $html .= '<h2>Database Images:</h2>';
    foreach ($images as $image) {
        $url = asset('storage/' . $image->image_path);
        $html .= '<div style="margin: 20px; padding: 10px; border: 1px solid #ccc;">';
        $html .= '<p><strong>Property:</strong> ' . $image->property->title . '</p>';
        $html .= '<p><strong>Path:</strong> ' . $image->image_path . '</p>';
        $html .= '<p><strong>Generated URL:</strong> ' . $url . '</p>';
        $html .= '<p><strong>File exists in storage:</strong> ' . (file_exists(storage_path('app/public/' . $image->image_path)) ? 'Yes' : 'No') . '</p>';
        $html .= '<p><strong>File exists in public:</strong> ' . (file_exists(public_path('storage/' . $image->image_path)) ? 'Yes' : 'No') . '</p>';
        $html .= '<img src="' . $url . '" alt="Test" style="max-width: 200px; height: auto; border: 1px solid red;">';
        $html .= '</div>';
    }
    
    $html .= '</body></html>';
    
    return $html;
});
// Background texture test route
Route::get('/test-backgrounds', function () {
    return view('test-backgrounds');
});

// CSRF token refresh endpoint
Route::get('/refresh-csrf', function () {
    return response()->json([
        'token' => csrf_token()
    ]);
});