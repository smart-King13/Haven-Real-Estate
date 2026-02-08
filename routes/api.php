<?php

use App\Http\Controllers\Api\SupabaseAuthController;
use App\Http\Controllers\Api\SupabasePropertyController;
use App\Http\Controllers\Api\SupabaseSavedPropertyController;
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
    Route::post('/register', [SupabaseAuthController::class, 'register']);
    Route::post('/login', [SupabaseAuthController::class, 'login']);
    Route::post('/forgot-password', [SupabaseAuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [SupabaseAuthController::class, 'resetPassword']);
});

// Public property routes (higher limit for browsing)
Route::middleware(['throttle:100,1'])->group(function () {
    Route::get('/properties', [SupabasePropertyController::class, 'index']);
    Route::get('/properties/{id}', [SupabasePropertyController::class, 'show']);
    Route::get('/properties/featured/list', [SupabasePropertyController::class, 'featured']);
});

// Protected routes
Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
    // Authentication routes
    Route::post('/logout', [SupabaseAuthController::class, 'logout']);
    Route::get('/profile', [SupabaseAuthController::class, 'profile']);
    Route::put('/profile', [SupabaseAuthController::class, 'updateProfile']);
    Route::put('/change-password', [SupabaseAuthController::class, 'changePassword']);

    // Property management (Admin only)
    Route::middleware('admin')->group(function () {
        Route::post('/properties', [SupabasePropertyController::class, 'store']);
        Route::put('/properties/{id}', [SupabasePropertyController::class, 'update']);
        Route::delete('/properties/{id}', [SupabasePropertyController::class, 'destroy']);
    });

    // Saved properties
    Route::prefix('saved-properties')->group(function () {
        Route::get('/', [SupabaseSavedPropertyController::class, 'index']);
        Route::post('/', [SupabaseSavedPropertyController::class, 'store']);
        Route::delete('/{propertyId}', [SupabaseSavedPropertyController::class, 'destroy']);
        Route::get('/check/{propertyId}', [SupabaseSavedPropertyController::class, 'check']);
        Route::post('/toggle', [SupabaseSavedPropertyController::class, 'toggle']);
    });
});

// Fallback route for API
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found.',
    ], 404);
});