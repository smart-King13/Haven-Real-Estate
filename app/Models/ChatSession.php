<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'user_name',
        'user_email',
        'user_ip',
        'user_agent',
        'status',
        'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];

    /**
     * Get the user that owns the chat session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the messages for the chat session.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at');
    }

    /**
     * Get the latest message for the chat session.
     */
    public function latestMessage(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->latest();
    }

    /**
     * Get unread messages count.
     */
    public function getUnreadCountAttribute(): int
    {
        return $this->messages()->where('is_from_user', true)->where('is_read', false)->count();
    }

    /**
     * Get the last message text.
     */
    public function getLastMessageAttribute(): ?string
    {
        $lastMessage = $this->messages()->latest()->first();
        return $lastMessage ? $lastMessage->message : null;
    }

    /**
     * Mark all messages as read.
     */
    public function markAsRead(): void
    {
        $this->messages()->where('is_from_user', true)->where('is_read', false)->update(['is_read' => true]);
    }

    /**
     * Update last activity.
     */
    public function updateActivity(): void
    {
        $this->update(['last_activity' => now()]);
    }

    /**
     * Scope for active sessions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for recent sessions.
     */
    public function scopeRecent($query)
    {
        return $query->where('last_activity', '>=', now()->subHours(24));
    }
}