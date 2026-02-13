<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Send a message (Stub)
     */
    public function sendMessage(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Message sent (stub)',
            'data' => [
                'id' => uniqid(),
                'content' => $request->message,
                'created_at' => now()->toISOString(),
                'sender_id' => auth()->id() ?? 'guest',
            ]
        ]);
    }

    /**
     * Get chat history (Stub)
     */
    public function getChatHistory(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => [] // Return empty list to stop frontend errors
        ]);
    }

    /**
     * Mark message as read (Stub)
     */
    public function markAsRead(Request $request)
    {
        return response()->json(['success' => true]);
    }

    /**
     * Get online status (Stub)
     */
    public function getOnlineStatus()
    {
        return response()->json(['online' => true]);
    }

    /**
     * Get admin chat sessions (Stub)
     */
    public function getAdminChatSessions()
    {
        return response()->json(['data' => []]);
    }

    /**
     * Get session messages (Stub)
     */
    public function getSessionMessages($sessionId)
    {
        return response()->json(['data' => []]);
    }

    /**
     * Send admin message (Stub)
     */
    public function sendAdminMessage(Request $request, $sessionId)
    {
        return response()->json(['success' => true]);
    }

    /**
     * Get chat statistics (Stub)
     */
    public function getChatStatistics()
    {
        return response()->json([
            'total_sessions' => 0,
            'active_sessions' => 0,
            'messages_today' => 0
        ]);
    }
}
