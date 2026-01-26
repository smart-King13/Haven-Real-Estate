<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\SavedPropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes with rate limiting
Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Public property routes (higher limit for browsing)
Route::middleware(['throttle:100,1'])->group(function () {
    Route::get('/properties', [PropertyController::class, 'index']);
    Route::get('/properties/{id}', [PropertyController::class, 'show']);
    Route::get('/properties/featured/list', [PropertyController::class, 'featured']);
});

// Public dashboard overview
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/overview', [DashboardController::class, 'overview']);
});

// Protected routes
Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
    // Authentication routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);
    
    // Email verification
    Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationEmail']);
    Route::post('/email/verify', [AuthController::class, 'verifyEmail']);

    // Property management (Admin only)
    Route::middleware('admin')->group(function () {
        Route::post('/properties', [PropertyController::class, 'store']);
        Route::put('/properties/{id}', [PropertyController::class, 'update']);
        Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);
        Route::post('/properties/{id}/images', [PropertyController::class, 'uploadImages']);
    });

    // Saved properties
    Route::prefix('saved-properties')->group(function () {
        Route::get('/', [SavedPropertyController::class, 'index']);
        Route::post('/', [SavedPropertyController::class, 'store']);
        Route::delete('/{propertyId}', [SavedPropertyController::class, 'destroy']);
        Route::get('/check/{propertyId}', [SavedPropertyController::class, 'check']);
        Route::post('/toggle', [SavedPropertyController::class, 'toggle']);
    });

    // Payments
    Route::prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index']);
        Route::post('/', [PaymentController::class, 'store']);
        Route::get('/{id}', [PaymentController::class, 'show']);
        
        // Admin payment routes
        Route::middleware('admin')->group(function () {
            Route::get('/admin/all', [PaymentController::class, 'adminIndex']);
            Route::get('/admin/statistics', [PaymentController::class, 'statistics']);
        });
    });

    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/user', [DashboardController::class, 'userStats']);
        
        // Admin dashboard
        Route::middleware('admin')->group(function () {
            Route::get('/admin', [DashboardController::class, 'adminStats']);
        });
    });
});

// Payment verification webhook (protected)
Route::post('/payments/verify/{transactionId}', [PaymentController::class, 'verify'])
    ->middleware('webhook.signature');

// Fallback route for API
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found.',
    ], 404);
});