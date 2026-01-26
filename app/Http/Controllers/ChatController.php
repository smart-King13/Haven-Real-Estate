<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Send a chat message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string'
        ]);

        $user = Auth::user();
        $sessionId = $request->session_id ?? session()->getId();
        
        // Find or create chat session
        $chatSession = ChatSession::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'user_id' => $user?->id,
                'user_name' => $user?->name ?? 'Anonymous User',
                'user_email' => $user?->email,
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'active',
                'last_activity' => now(),
            ]
        );

        // Update session activity
        $chatSession->updateActivity();

        // Create the message
        $message = ChatMessage::create([
            'chat_session_id' => $chatSession->id,
            'user_id' => $user?->id,
            'message' => $request->message,
            'is_from_user' => true,
            'is_read' => false,
        ]);

        // No automatic response - wait for human support

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Get chat history for current session
     */
    public function getChatHistory(Request $request)
    {
        $sessionId = $request->session_id ?? session()->getId();
        
        $chatSession = ChatSession::where('session_id', $sessionId)->first();
        
        if (!$chatSession) {
            return response()->json([
                'success' => true,
                'messages' => [],
                'session_id' => $sessionId
            ]);
        }

        $messages = $chatSession->messages()->with(['user', 'admin'])->get()->map(function ($message) {
            return [
                'id' => $message->id,
                'text' => $message->message,
                'is_user' => $message->is_from_user,
                'timestamp' => $message->created_at->toISOString(),
                'sender_name' => $message->is_from_user 
                    ? ($message->user?->name ?? 'Anonymous') 
                    : ($message->admin?->name ?? 'Haven Support'),
                'sender_avatar' => $message->is_from_user 
                    ? ($message->user?->avatar ? asset('storage/' . $message->user->avatar) : null)
                    : ($message->admin?->avatar ? asset('storage/' . $message->admin->avatar) : null),
                'metadata' => $message->metadata,
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'session_id' => $sessionId
        ]);
    }

    /**
     * Get admin chat sessions
     */
    public function getAdminChatSessions()
    {
        $sessions = ChatSession::with(['user', 'latestMessage'])
            ->recent()
            ->orderBy('last_activity', 'desc')
            ->get()
            // Filter to ensure unique users (keep most recent session per user)
            ->unique(function ($session) {
                return $session->user_id ? 'user_' . $session->user_id : 'session_' . $session->id;
            })
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'session_id' => $session->session_id,
                    'user_name' => $session->user_name ?? 'Anonymous User',
                    'user_email' => $session->user_email,
                    'user_avatar' => $session->user?->avatar ? asset('storage/' . $session->user->avatar) : null,
                    'last_message' => $session->last_message,
                    'unread_count' => $session->unread_count,
                    'status' => $session->status,
                    'last_activity' => $session->last_activity->toISOString(),
                ];
            });

        return response()->json([
            'success' => true,
            'sessions' => $sessions
        ]);
    }

    /**
     * Get messages for a specific chat session
     */
    public function getSessionMessages($sessionId)
    {
        $chatSession = ChatSession::findOrFail($sessionId);
        
        $messages = $chatSession->messages()->with(['user', 'admin'])->get()->map(function ($message) {
            return [
                'id' => $message->id,
                'text' => $message->message,
                'is_user' => $message->is_from_user,
                'timestamp' => $message->created_at->toISOString(),
                'sender_name' => $message->is_from_user 
                    ? ($message->user?->name ?? 'Anonymous') 
                    : ($message->admin?->name ?? 'Haven Support'),
                'sender_avatar' => $message->is_from_user 
                    ? ($message->user?->avatar ? asset('storage/' . $message->user->avatar) : null)
                    : ($message->admin?->avatar ? asset('storage/' . $message->admin->avatar) : null),
                'is_read' => $message->is_read,
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'session' => [
                'id' => $chatSession->id,
                'user_name' => $chatSession->user_name,
                'user_email' => $chatSession->user_email,
                'status' => $chatSession->status,
            ]
        ]);
    }

    /**
     * Send admin message
     */
    public function sendAdminMessage(Request $request, $sessionId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $chatSession = ChatSession::findOrFail($sessionId);
        
        $message = ChatMessage::create([
            'chat_session_id' => $chatSession->id,
            'admin_id' => Auth::id(),
            'message' => $request->message,
            'is_from_user' => false,
            'is_read' => true,
        ]);

        // Update session activity
        $chatSession->updateActivity();

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'text' => $message->message,
                'is_user' => false,
                'timestamp' => $message->created_at->toISOString(),
                'sender_name' => Auth::user()->name,
                'sender_avatar' => Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : null,
            ]
        ]);
    }

    /**
     * Mark chat session as read
     */
    public function markAsRead($sessionId)
    {
        $chatSession = ChatSession::findOrFail($sessionId);
        $chatSession->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Chat marked as read'
        ]);
    }

    /**
     * Get chat statistics
     */
    public function getChatStatistics()
    {
        $activeChats = ChatSession::active()->count();
        $todayChats = ChatSession::whereDate('created_at', today())->count();
        
        // Calculate average response time (mock for now)
        $avgResponseTime = '2m';
        $satisfactionRate = '98%';

        return response()->json([
            'success' => true,
            'statistics' => [
                'active_chats' => $activeChats,
                'today_chats' => $todayChats,
                'avg_response_time' => $avgResponseTime,
                'satisfaction_rate' => $satisfactionRate,
            ]
        ]);
    }

    /**
     * Generate automated response based on message content
     */
    private function generateResponse($message)
    {
        $message = strtolower($message);
        
        // Property buying inquiries
        if (str_contains($message, 'buy') || str_contains($message, 'purchase') || str_contains($message, 'buying')) {
            return [
                'text' => "I'd be happy to help you find the perfect property to purchase! Our team specializes in luxury real estate. Would you like me to connect you with one of our buying specialists?",
                'quick_actions' => [
                    'Schedule a consultation',
                    'View available properties',
                    'Get pre-approved'
                ]
            ];
        }
        
        // Property rental inquiries
        if (str_contains($message, 'rent') || str_contains($message, 'rental') || str_contains($message, 'lease')) {
            return [
                'text' => "Great! We have an excellent selection of rental properties. Let me help you find something that matches your needs. What type of property are you looking for?",
                'quick_actions' => [
                    'View rental listings',
                    'Schedule viewing',
                    'Check availability'
                ]
            ];
        }
        
        // Property valuation inquiries
        if (str_contains($message, 'valuation') || str_contains($message, 'value') || str_contains($message, 'worth') || str_contains($message, 'appraisal')) {
            return [
                'text' => "I can help you with property valuation! Our expert team provides comprehensive market analysis. Would you like to schedule a free property assessment?",
                'quick_actions' => [
                    'Schedule assessment',
                    'Get market report',
                    'Speak with appraiser'
                ]
            ];
        }
        
        // Viewing/appointment inquiries
        if (str_contains($message, 'viewing') || str_contains($message, 'visit') || str_contains($message, 'see') || str_contains($message, 'appointment')) {
            return [
                'text' => "I'd be happy to arrange a property viewing for you! Our team can schedule convenient times that work with your schedule. Which property interests you?",
                'quick_actions' => [
                    'Schedule viewing',
                    'Check availability',
                    'Virtual tour'
                ]
            ];
        }
        
        // Investment inquiries
        if (str_contains($message, 'invest') || str_contains($message, 'investment') || str_contains($message, 'roi') || str_contains($message, 'return')) {
            return [
                'text' => "Excellent! Real estate investment is one of our specialties. Our investment team can provide detailed market analysis and ROI projections. Would you like to discuss your investment goals?",
                'quick_actions' => [
                    'Investment consultation',
                    'Market analysis',
                    'ROI calculator'
                ]
            ];
        }
        
        // General inquiries
        if (str_contains($message, 'hello') || str_contains($message, 'hi') || str_contains($message, 'hey')) {
            return [
                'text' => "Hello! Welcome to Haven. I'm here to help you with all your real estate needs. Whether you're looking to buy, rent, or invest, our expert team is ready to assist you.",
                'quick_actions' => [
                    'Browse properties',
                    'Schedule consultation',
                    'Learn about services'
                ]
            ];
        }
        
        // Pricing inquiries
        if (str_contains($message, 'price') || str_contains($message, 'cost') || str_contains($message, 'expensive') || str_contains($message, 'budget')) {
            return [
                'text' => "I understand pricing is important in your decision. We work with properties across various price ranges and can help you find something within your budget. What's your preferred price range?",
                'quick_actions' => [
                    'Set budget preferences',
                    'View price ranges',
                    'Financing options'
                ]
            ];
        }
        
        // Default response
        return [
            'text' => "Thank you for your message! I'm here to help you with any real estate questions or needs. Our expert team is standing by to provide personalized assistance. How can we help you today?",
            'quick_actions' => [
                'Speak with specialist',
                'Browse properties',
                'Schedule consultation'
            ]
        ];
    }

    /**
     * Get online status
     */
    public function getOnlineStatus()
    {
        // In a real implementation, you would check actual agent availability
        $isOnline = now()->hour >= 9 && now()->hour <= 18; // 9 AM to 6 PM
        
        return response()->json([
            'online' => $isOnline,
            'message' => $isOnline ? 'Our team is online and ready to help!' : 'We\'re currently offline but will respond soon.',
            'response_time' => $isOnline ? 'Typically replies instantly' : 'Typically replies within 1 hour'
        ]);
    }
}