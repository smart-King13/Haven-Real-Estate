<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_session_id',
        'user_id',
        'admin_id',
        'message',
        'is_from_user',
        'is_read',
        'metadata',
    ];

    protected $casts = [
        'is_from_user' => 'boolean',
        'is_read' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Get the chat session that owns the message.
     */
    public function chatSession(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class);
    }

    /**
     * Get the user that sent the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin that sent the message.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Scope for user messages.
     */
    public function scopeFromUser($query)
    {
        return $query->where('is_from_user', true);
    }

    /**
     * Scope for admin messages.
     */
    public function scopeFromAdmin($query)
    {
        return $query->where('is_from_user', false);
    }

    /**
     * Scope for unread messages.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Mark message as read.
     */
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}