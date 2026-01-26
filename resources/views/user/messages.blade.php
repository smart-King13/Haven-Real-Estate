@extends('layouts.user')

@section('title', 'Messages - User Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-primary-950 uppercase tracking-tighter">Messages</h1>
                    <p class="text-gray-600 font-light mt-2">Chat with Haven support team</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-700">Support Online</span>
                    </div>
                    <button onclick="refreshMessages()" class="px-4 py-2 bg-accent-600 text-white font-medium rounded-lg hover:bg-accent-500 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Chat Interface -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden h-[700px] flex flex-col">
            <!-- Chat Header -->
            <div class="p-6 border-b border-gray-100 bg-primary-950 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-accent-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-black text-sm uppercase tracking-wide">Haven Support</h3>
                            <p class="text-white/60 text-xs">We're here to help with all your real estate needs</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-xs font-medium text-white/60">Online</span>
                    </div>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50" id="messagesArea">
                <div class="text-center text-gray-500 mt-20" id="emptyState">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z"/>
                    </svg>
                    <p class="font-medium text-lg">Start a conversation</p>
                    <p class="text-sm text-gray-400 mt-1">Send a message to get help from our support team</p>
                </div>
            </div>

            <!-- Message Input -->
            <div class="p-6 border-t border-gray-100 bg-white">
                <form onsubmit="sendMessage(event)" class="flex items-center gap-4">
                    <div class="flex-1 relative">
                        <input type="text" 
                               id="messageInput"
                               placeholder="Type your message..."
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-full focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all text-sm font-medium"
                               maxlength="1000">
                        
                        <!-- Quick Actions -->
                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                            <button type="button" onclick="toggleQuickActions()" class="text-gray-400 hover:text-accent-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-12 h-12 bg-accent-600 hover:bg-accent-500 text-white rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>

                <!-- Quick Action Templates -->
                <div id="quickActions" class="mt-4 hidden">
                    <div class="text-xs font-black uppercase tracking-wide text-gray-400 mb-3">Quick Messages</div>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="insertQuickMessage('Hi, I need help finding a property to buy.')" 
                                class="px-3 py-2 bg-gray-100 hover:bg-accent-600 hover:text-white text-xs font-medium rounded-full transition-all">
                            Property Purchase
                        </button>
                        <button onclick="insertQuickMessage('I\'m looking for rental properties. Can you help?')" 
                                class="px-3 py-2 bg-gray-100 hover:bg-accent-600 hover:text-white text-xs font-medium rounded-full transition-all">
                            Rental Inquiry
                        </button>
                        <button onclick="insertQuickMessage('I\'d like to schedule a property viewing.')" 
                                class="px-3 py-2 bg-gray-100 hover:bg-accent-600 hover:text-white text-xs font-medium rounded-full transition-all">
                            Schedule Viewing
                        </button>
                        <button onclick="insertQuickMessage('Can you provide a property valuation?')" 
                                class="px-3 py-2 bg-gray-100 hover:bg-accent-600 hover:text-white text-xs font-medium rounded-full transition-all">
                            Property Valuation
                        </button>
                        <button onclick="insertQuickMessage('I have questions about investment opportunities.')" 
                                class="px-3 py-2 bg-gray-100 hover:bg-accent-600 hover:text-white text-xs font-medium rounded-full transition-all">
                            Investment Help
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="font-black text-primary-950 mb-2">Response Time</h3>
                <p class="text-sm text-gray-600 mb-2">Typically replies within</p>
                <p class="text-2xl font-black text-accent-600">2 minutes</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="font-black text-primary-950 mb-2">Support Hours</h3>
                <p class="text-sm text-gray-600 mb-2">Monday - Friday</p>
                <p class="text-lg font-black text-accent-600">9 AM - 6 PM</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="font-black text-primary-950 mb-2">Satisfaction</h3>
                <p class="text-sm text-gray-600 mb-2">Customer rating</p>
                <p class="text-2xl font-black text-accent-600">98%</p>
            </div>
        </div>
    </div>
</div>

<script>
let sessionId = null;
let isLoading = false;

// Initialize messaging
document.addEventListener('DOMContentLoaded', function() {
    sessionId = getSessionId();
    loadChatHistory();
    
    // Auto-refresh messages every 10 seconds
    setInterval(() => {
        if (!isLoading) {
            loadChatHistory();
        }
    }, 10000);
});

// Get or create session ID
function getSessionId() {
    let sessionId = localStorage.getItem('haven_user_chat_session');
    if (!sessionId) {
        sessionId = 'user_session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('haven_user_chat_session', sessionId);
    }
    return sessionId;
}

// Load chat history
async function loadChatHistory() {
    if (isLoading) return;
    isLoading = true;
    
    try {
        const response = await fetch(`/chat/history?session_id=${sessionId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            if (data.success && data.messages) {
                renderMessages(data.messages);
            }
        }
    } catch (error) {
        console.error('Error loading chat history:', error);
    } finally {
        isLoading = false;
    }
}

// Render messages
function renderMessages(messages) {
    const messagesArea = document.getElementById('messagesArea');
    const emptyState = document.getElementById('emptyState');
    
    if (messages.length === 0) {
        emptyState.style.display = 'block';
        return;
    }
    
    emptyState.style.display = 'none';
    
    messagesArea.innerHTML = messages.map(message => {
        // Determine avatar content
        let avatarContent;
        if (message.sender_avatar) {
            avatarContent = `<img src="${message.sender_avatar}" alt="Profile" class="w-full h-full object-cover rounded-full">`;
        } else {
            avatarContent = message.is_user ? 
                `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>` : 
                `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>`;
        }
        
        return `
        <div class="flex items-start gap-3 ${message.is_user ? 'flex-row-reverse' : ''} animate-fade-in">
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 shadow-sm overflow-hidden ${message.is_user ? 'bg-gradient-to-r from-primary-950 to-primary-900' : 'bg-gradient-to-r from-accent-600 to-accent-700'}">
                ${avatarContent}
            </div>
            <div class="flex-1 max-w-xs">
                <div class="rounded-2xl p-4 ${message.is_user ? 'bg-gradient-to-r from-primary-950 to-primary-900 text-white rounded-tr-sm' : 'bg-white text-primary-950 rounded-tl-sm shadow-sm border border-gray-100'}">
                    <p class="text-sm font-medium leading-relaxed">${message.text}</p>
                </div>
                <div class="text-xs text-gray-400 font-medium mt-2 flex items-center gap-2 ${message.is_user ? 'justify-end' : ''}">
                    <span>${formatTime(message.timestamp)}</span>
                    <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                    <span>${message.sender_name || (message.is_user ? 'You' : 'Haven Support')}</span>
                </div>
            </div>
        </div>
        `;
    }).join('');

    // Scroll to bottom
    messagesArea.scrollTop = messagesArea.scrollHeight;
}

// Send message
async function sendMessage(event) {
    event.preventDefault();
    
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (!message) return;

    try {
        const response = await fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                message: message,
                session_id: sessionId
            })
        });
        
        if (response.ok) {
            const data = await response.json();
            if (data.success) {
                // Clear input
                input.value = '';
                
                // Reload messages
                setTimeout(() => {
                    loadChatHistory();
                }, 500);
            }
        }
    } catch (error) {
        console.error('Error sending message:', error);
    }
}

// Quick action functions
function toggleQuickActions() {
    const quickActions = document.getElementById('quickActions');
    quickActions.classList.toggle('hidden');
}

function insertQuickMessage(text) {
    document.getElementById('messageInput').value = text;
    document.getElementById('quickActions').classList.add('hidden');
}

// Refresh messages
function refreshMessages() {
    loadChatHistory();
}

// Utility functions
function formatTime(timestamp) {
    const date = new Date(timestamp);
    const now = new Date();
    const diff = now - date;
    
    if (diff < 60000) return 'Just now';
    if (diff < 3600000) return Math.floor(diff / 60000) + 'm ago';
    if (diff < 86400000) return Math.floor(diff / 3600000) + 'h ago';
    return date.toLocaleDateString();
}
</script>
@endsection
