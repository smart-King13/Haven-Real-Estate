<?php

namespace App\Http\Controllers;

use App\Services\SupabaseService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Get all chat sessions for admin
     */
    public function getAdminChatSessions()
    {
        try {
            // Get all chat sessions with user info
            $sessionsResponse = $this->supabase->select('chat_sessions', '*', [], [
                'order' => ['column' => 'last_message_at', 'ascending' => false]
            ]);
            
            $sessions = $sessionsResponse->data ?? [];
            
            // Enrich with user data and last message
            foreach ($sessions as &$session) {
                $sess = is_array($session) ? (object)$session : $session;
                
                // Get user profile
                $user = $this->supabase->getUserProfile($sess->user_id);
                
                // Get last message
                $lastMessageResponse = $this->supabase->select('chat_messages', '*', [
                    'session_id' => $sess->id
                ], [
                    'order' => ['column' => 'created_at', 'ascending' => false],
                    'limit' => 1
                ]);
                
                $lastMessage = !empty($lastMessageResponse->data) ? $lastMessageResponse->data[0] : null;
                
                // Count unread messages
                $unreadCount = $this->supabase->count('chat_messages', [
                    'session_id' => $sess->id,
                    'is_read' => false,
                    'is_user' => true
                ]);
                
                // Update session data
                if (is_array($session)) {
                    $session['user_name'] = $user->name ?? 'Anonymous User';
                    $session['user_email'] = $user->email ?? '';
                    $session['user_avatar'] = isset($user->avatar) ? asset('storage/' . $user->avatar) : null;
                    $session['last_message'] = $lastMessage ? (is_array($lastMessage) ? $lastMessage['message'] : $lastMessage->message) : 'New conversation';
                    $session['last_activity'] = $sess->last_message_at ?? $sess->created_at;
                    $session['unread_count'] = $unreadCount;
                } else {
                    $session->user_name = $user->name ?? 'Anonymous User';
                    $session->user_email = $user->email ?? '';
                    $session->user_avatar = isset($user->avatar) ? asset('storage/' . $user->avatar) : null;
                    $session->last_message = $lastMessage ? (is_array($lastMessage) ? $lastMessage['message'] : $lastMessage->message) : 'New conversation';
                    $session->last_activity = $sess->last_message_at ?? $sess->created_at;
                    $session->unread_count = $unreadCount;
                }
            }
            
            return response()->json([
                'success' => true,
                'sessions' => $sessions
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Get chat sessions error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load chat sessions'
            ], 500);
        }
    }

    /**
     * Get messages for a specific session
     */
    public function getSessionMessages($sessionId)
    {
        try {
            // Get session
            $session = $this->supabase->findOne('chat_sessions', ['id' => $sessionId]);
            
            if (!$session) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session not found'
                ], 404);
            }
            
            // Get user profile
            $user = $this->supabase->getUserProfile($session->user_id);
            
            // Get messages
            $messagesResponse = $this->supabase->select('chat_messages', '*', [
                'session_id' => $sessionId
            ], [
                'order' => ['column' => 'created_at', 'ascending' => true]
            ]);
            
            $messages = $messagesResponse->data ?? [];
            
            // Enrich messages with sender info
            foreach ($messages as &$message) {
                $msg = is_array($message) ? (object)$message : $message;
                
                if ($msg->sender_id) {
                    $sender = $this->supabase->getUserProfile($msg->sender_id);
                    
                    if (is_array($message)) {
                        $message['sender_name'] = $sender->name ?? 'Unknown';
                        $message['sender_avatar'] = isset($sender->avatar) ? asset('storage/' . $sender->avatar) : null;
                        $message['text'] = $message['message'];
                        $message['timestamp'] = $message['created_at'];
                    } else {
                        $message->sender_name = $sender->name ?? 'Unknown';
                        $message->sender_avatar = isset($sender->avatar) ? asset('storage/' . $sender->avatar) : null;
                        $message->text = $message->message;
                        $message->timestamp = $message->created_at;
                    }
                }
            }
            
            return response()->json([
                'success' => true,
                'session' => [
                    'user_name' => $user->name ?? 'Anonymous User',
                    'user_email' => $user->email ?? '',
                    'user_avatar' => isset($user->avatar) ? asset('storage/' . $user->avatar) : null,
                    'status' => $session->status
                ],
                'messages' => $messages
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Get session messages error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load messages'
            ], 500);
        }
    }

    /**
     * Send admin message
     */
    public function sendAdminMessage(Request $request, $sessionId)
    {
        try {
            $admin = supabase_user();
            
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
            
            // Insert message
            $messageData = [
                'session_id' => $sessionId,
                'sender_id' => $admin->id,
                'message' => $request->message,
                'is_user' => false,
                'is_read' => false
            ];
            
            $response = $this->supabase->insert('chat_messages', $messageData, true);
            
            if (!$response || empty($response->data)) {
                throw new \Exception('Failed to insert message');
            }
            
            $message = is_array($response->data[0]) ? (object)$response->data[0] : $response->data[0];
            
            // Get admin profile
            $adminProfile = supabase_profile();
            
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'text' => $message->message,
                    'sender_name' => $adminProfile->name ?? 'Admin',
                    'sender_avatar' => isset($adminProfile->avatar) ? asset('storage/' . $adminProfile->avatar) : null,
                    'timestamp' => $message->created_at,
                    'is_user' => false
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Send admin message error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message'
            ], 500);
        }
    }

    /**
     * Mark session as read
     */
    public function markAsRead($sessionId)
    {
        try {
            // Mark all user messages in this session as read
            $this->supabase->update('chat_messages', [
                'is_read' => true
            ], [
                'session_id' => $sessionId,
                'is_user' => true
            ], true);
            
            return response()->json([
                'success' => true
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Mark as read error: ' . $e->getMessage());
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    /**
     * Get chat statistics
     */
    public function getChatStatistics()
    {
        try {
            $activeChats = $this->supabase->count('chat_sessions', ['status' => 'active']);
            
            // Count today's chats
            $todayChats = 0; // Would need date filtering
            
            return response()->json([
                'success' => true,
                'statistics' => [
                    'active_chats' => $activeChats,
                    'today_chats' => $todayChats,
                    'avg_response_time' => '2m',
                    'satisfaction_rate' => '98%'
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Get statistics error: ' . $e->getMessage());
            return response()->json([
                'success' => false
            ], 500);
        }
    }
}
