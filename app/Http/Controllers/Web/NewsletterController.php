<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Subscribe to newsletter (Public)
     */
    public function subscribe(Request $request)
    {
        // Check if user is authenticated
        if (!session('supabase_user')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You must be logged in to subscribe.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to subscribe to our newsletter.');
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            \Illuminate\Support\Facades\Log::error('Newsletter validation failed', $validator->errors()->toArray());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            \Illuminate\Support\Facades\Log::info('Newsletter subscription attempt', [
                'email' => $request->email,
                'name' => $request->name
            ]);

            // Check if already subscribed
            $existing = $this->supabase->findOne('newsletter_subscribers', [
                'email' => $request->email
            ]);

            if ($existing) {
                \Illuminate\Support\Facades\Log::info('Existing subscriber found', ['status' => $existing->status ?? 'unknown']);
                
                // If unsubscribed, reactivate
                if (isset($existing->status) && $existing->status === 'unsubscribed') {
                    $this->supabase->update('newsletter_subscribers', [
                        'status' => 'active',
                        'subscribed_at' => date('Y-m-d H:i:s'),
                        'unsubscribed_at' => null
                    ], ['id' => $existing->id]);

                    $message = 'Welcome back! You have been resubscribed to our newsletter.';
                    
                    if ($request->expectsJson()) {
                        return response()->json(['message' => $message], 200);
                    }
                    return back()->with('success', $message);
                }

                $message = 'You are already subscribed to our newsletter!';
                
                if ($request->expectsJson()) {
                    return response()->json(['message' => $message], 200);
                }
                return back()->with('info', $message);
            }

            // Create new subscriber
            \Illuminate\Support\Facades\Log::info('Creating new subscriber');
            
            $result = $this->supabase->insert('newsletter_subscribers', [
                'email' => $request->email,
                'name' => $request->name ?? '',
                'status' => 'active',
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                'source' => 'website'
            ], true); // Use service key to bypass RLS

            \Illuminate\Support\Facades\Log::info('Newsletter subscription successful', ['result' => $result]);

            $message = 'Thank you for subscribing! You will receive our latest updates.';
            
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 200);
            }
            return back()->with('success', $message);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Newsletter subscription error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $message = 'Failed to subscribe. Please try again.';
            
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 500);
            }
            return back()->with('error', $message);
        }
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $subscriber = $this->supabase->findOne('newsletter_subscribers', [
                'email' => $request->email
            ]);

            if (!$subscriber) {
                return back()->with('error', 'Email not found in our subscriber list.');
            }

            $this->supabase->update('newsletter_subscribers', [
                'status' => 'unsubscribed',
                'unsubscribed_at' => date('Y-m-d H:i:s')
            ], ['id' => $subscriber->id]);

            return back()->with('success', 'You have been unsubscribed from our newsletter.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to unsubscribe. Please try again.');
        }
    }
}
