<?php

namespace App\Http\Controllers\Auth;

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
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $response = $this->supabase->signIn(
                $request->email,
                $request->password
            );

            if (!$response || !isset($response->access_token)) {
                return back()->with('error', 'Invalid credentials')->withInput();
            }

            // Handle user as array or object
            $user = is_array($response->user) ? (object)$response->user : $response->user;
            $userId = is_array($response->user) ? $response->user['id'] : $response->user->id;

            // Get user profile
            $profile = $this->supabase->getUserProfile($userId);

            // Store in session
            $request->session()->put('supabase_token', $response->access_token);
            $request->session()->put('supabase_user', $user);
            $request->session()->put('supabase_profile', $profile);
            
            // Regenerate session ID for security and extend lifetime
            $request->session()->regenerate();

            // Redirect based on role
            $userRole = is_object($profile) ? $profile->role : ($profile['role'] ?? 'user');
            
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            }

            return redirect()->route('user.dashboard')->with('success', 'Welcome back!');

        } catch (\Exception $e) {
            \Log::error('Login exception: ' . $e->getMessage());
            return back()->with('error', 'Login failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
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

            // Check if user was created (even if email confirmation failed)
            if (!$response || !isset($response->user)) {
                return back()->with('error', 'Registration failed. Email may already be in use.')->withInput();
            }

            // User was created successfully!
            \Log::info('User registered successfully', ['user_id' => $response->user->id, 'email' => $response->user->email]);

            // Try to update profile with additional data (non-critical)
            try {
                $this->supabase->updateUserProfile($response->user->id, [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            } catch (\Exception $e) {
                \Log::warning('Profile update failed during registration: ' . $e->getMessage());
                // Continue anyway - user is created
            }

            // Auto-login after registration if we have access token
            if (isset($response->access_token) && !empty($response->access_token)) {
                try {
                    $profile = $this->supabase->getUserProfile($response->user->id);

                    $request->session()->put('supabase_token', $response->access_token);
                    $request->session()->put('supabase_user', $response->user);
                    $request->session()->put('supabase_profile', $profile);

                    return redirect()->route('user.dashboard')->with('success', '🎉 Account created successfully! Welcome to Haven.');
                } catch (\Exception $e) {
                    \Log::warning('Auto-login failed after registration: ' . $e->getMessage());
                    // User is created, just redirect to login
                }
            }

            // User created but no access token (email confirmation may be required)
            return redirect()->route('login')->with('success', '✅ Account created successfully! Please login with your credentials.');

        } catch (\Exception $e) {
            \Log::error('Registration exception', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);
            
            // Check if it's a duplicate email error
            if (str_contains($e->getMessage(), 'already') || str_contains($e->getMessage(), 'duplicate')) {
                return back()->with('error', 'This email is already registered. Please login or use a different email.')->withInput();
            }
            
            // Generic error
            return back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        try {
            $token = $request->session()->get('supabase_token');
            
            if ($token) {
                $this->supabase->signOut($token);
            }

            $request->session()->forget(['supabase_token', 'supabase_user', 'supabase_profile']);
            $request->session()->flush();

            return redirect()->route('home')->with('success', 'Logged out successfully');

        } catch (\Exception $e) {
            $request->session()->flush();
            return redirect()->route('home');
        }
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Send password reset email via Supabase
            $result = $this->supabase->resetPassword($request->email);

            return redirect()->route('password.sent')
                ->with('success', 'Password reset link sent to your email!')
                ->with('email', $request->email);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Password reset error: ' . $e->getMessage());
            return back()->with('error', 'Failed to send reset link. Please check your email and try again.')->withInput();
        }
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm(Request $request)
    {
        return view('auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle reset password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            // Supabase handles password reset via email link
            // The token in the URL is the access token
            $this->supabase->updatePassword($request->token, $request->password);

            return redirect()->route('login')
                ->with('success', 'Password reset successful! Please login with your new password.');

        } catch (\Exception $e) {
            return back()->with('error', 'Password reset failed. The link may have expired.');
        }
    }
}
