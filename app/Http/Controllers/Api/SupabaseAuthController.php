<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupabaseAuthController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Register new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Sign up user in Supabase Auth
            $response = $this->supabase->signUp(
                $request->email,
                $request->password,
                [
                    'name' => $request->name,
                    'role' => 'user'
                ]
            );

            if (!$response || !isset($response->user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration failed. Email may already be in use.'
                ], 400);
            }

            // Update profile with additional data
            $this->supabase->updateUserProfile($response->user->id, [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            // Get updated profile
            $profile = $this->supabase->getUserProfile($response->user->id);

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'data' => [
                    'user' => $response->user,
                    'profile' => $profile,
                    'token' => $response->access_token ?? null
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $response = $this->supabase->signIn(
                $request->email,
                $request->password
            );

            if (!$response || !isset($response->access_token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Get user profile
            $profile = $this->supabase->getUserProfile($response->user->id);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $response->user,
                    'profile' => $profile,
                    'token' => $response->access_token
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        try {
            $token = $request->bearerToken();
            
            if ($token) {
                $this->supabase->signOut($token);
            }

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out'
            ]);
        }
    }

    /**
     * Get current user profile
     */
    public function profile(Request $request)
    {
        try {
            $user = $request->get('supabase_user');
            $profile = $request->get('supabase_profile');

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'profile' => $profile
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get profile'
            ], 500);
        }
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->get('supabase_user');

            $updateData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ];

            // Update profile
            $this->supabase->updateUserProfile($user->id, $updateData);

            // Get updated profile
            $profile = $this->supabase->getUserProfile($user->id);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => ['profile' => $profile]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->get('supabase_user');
            $token = $request->bearerToken();

            // Verify current password
            $verifyResponse = $this->supabase->signIn(
                $user->email,
                $request->current_password
            );

            if (!$verifyResponse) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 400);
            }

            // Update password
            $this->supabase->updatePassword($token, $request->password);

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to change password'
            ], 500);
        }
    }

    /**
     * Forgot password
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $this->supabase->resetPassword($request->email);

            return response()->json([
                'success' => true,
                'message' => 'Password reset link sent to your email'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send reset link'
            ], 500);
        }
    }
}
