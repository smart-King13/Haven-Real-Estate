@extends('layouts.app')

@section('title', 'Chat with Support')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden" style="height: 600px; display: flex; flex-direction: column;">
            <!-- Chat Header -->
            <div class="bg-accent-600 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-white font-bold text-lg">Haven Support</h2>
                        <p class="text-white/80 text-sm">We're here to help</p>
                    </div>
                </div>
                <a href="{{ route('user.dashboard') }}" class="text-white hover:text-white/80">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>

            <!-- Messages Container -->
            <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50">
                <div class="text-center text-gray-500 py-8" id="loading-indicator">
                    <svg class="animate-spin h-8 w-8 mx-auto text-accent-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-2">Loading messages...</p>
                </div>
            </div>

            <!-- Message Input -->
            <div class="border-t border-gray-200 p-4 bg-white">
                <form id="message-form" class="flex gap-2">
                    @csrf
                    <input 
                        type="text" 
                        id="message-input" 
                        placeholder="Type your message..." 
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                        required
                    >
                    <button 
                        type="submit" 
                        class="px-6 py-3 bg-accent-600 text-white rounded-full hover:bg-accent-700 transition-colors font-medium flex items-center gap-2"
                    >
                        <span>Send</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let currentSession = null;
let pollingInterval = null;
const currentUserId = '{{ supabase_user()->id ?? "" }}';

// Initialize chat
async function initChat() {
    try {
        // Get or create session
        const response = await fetch('{{ route("chat.session") }}');
        const data = await response.json();
        
        if (data.success && data.session) {
            currentSession = data.session;
            await loadMessages();
            startPolling();
        }
    } catch (error) {
        console.error('Failed to initialize chat:', error);
        showError('Failed to load chat. Please refresh the page.');
    }
}

// Load messages
async function loadMessages() {
    if (!currentSession) return;
    
    try {
        const response = await fetch(`{{ route("chat.messages") }}?session_id=${currentSession.id}`);
        const data = await response.json();
        
        if (data.success) {
            displayMessages(data.messages);
            document.getElementById('loading-indicator').style.display = 'none';
        }
    } catch (error) {
        console.error('Failed to load messages:', error);
    }
}

// Display messages
function displayMessages(messages) {
    const container = document.getElementById('messages-container');
    const loadingIndicator = document.getElementById('loading-indicator');
    
    // Clear existing messages (except loading indicator)
    const existingMessages = container.querySelectorAll('.message-bubble');
    existingMessages.forEach(msg => msg.remove());
    
    messages.forEach(message => {
        const messageEl = createMessageElement(message);
        container.insertBefore(messageEl, loadingIndicator);
    });
    
    // Scroll to bottom
    container.scrollTop = container.scrollHeight;
}

// Create message element
function createMessageElement(message) {
    const isCurrentUser = message.sender_id === currentUserId;
    const div = document.createElement('div');
    div.className = `message-bubble flex ${isCurrentUser ? 'justify-end' : 'justify-start'}`;
    
    const senderName = message.sender?.name || 'Support';
    const timestamp = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    
    div.innerHTML = `
        <div class="max-w-[70%]">
            ${!isCurrentUser ? `<p class="text-xs text-gray-600 mb-1 ml-2">${senderName}</p>` : ''}
            <div class="${isCurrentUser ? 'bg-accent-600 text-white' : 'bg-white border border-gray-200'} rounded-2xl px-4 py-3 shadow-sm">
                <p class="text-sm">${escapeHtml(message.message)}</p>
            </div>
            <p class="text-xs text-gray-500 mt-1 ${isCurrentUser ? 'text-right mr-2' : 'ml-2'}">${timestamp}</p>
        </div>
    `;
    
    return div;
}

// Send message
document.getElementById('message-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const input = document.getElementById('message-input');
    const message = input.value.trim();
    
    if (!message || !currentSession) return;
    
    try {
        const response = await fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                session_id: currentSession.id,
                message: message
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            input.value = '';
            await loadMessages();
        } else {
            showError('Failed to send message. Please try again.');
        }
    } catch (error) {
        console.error('Failed to send message:', error);
        showError('Failed to send message. Please try again.');
    }
});

// Start polling for new messages
function startPolling() {
    if (pollingInterval) clearInterval(pollingInterval);
    
    pollingInterval = setInterval(async () => {
        await loadMessages();
    }, 5000); // Poll every 5 seconds
}

// Stop polling
function stopPolling() {
    if (pollingInterval) {
        clearInterval(pollingInterval);
        pollingInterval = null;
    }
}

// Utility functions
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function showError(message) {
    alert(message);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    initChat();
});

// Clean up on page unload
window.addEventListener('beforeunload', () => {
    stopPolling();
});
</script>
@endsection
