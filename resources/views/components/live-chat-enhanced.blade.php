<!-- Enhanced Live Chat Component - Homepage Style -->
<div class="fixed bottom-6 right-6 z-[99999]">
    
    <!-- Chat Button -->
    <div id="chatButton">
        <button onclick="openChat()" 
                class="group relative w-16 h-16 bg-accent-500 hover:bg-accent-600 text-white rounded-full shadow-lg shadow-accent-500/30 hover:shadow-accent-500/50 flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:-translate-y-1">
            <svg class="w-7 h-7 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </button>

        <!-- Notification Badge (only shows when there are actual unread messages) -->
        <div id="notificationBadge" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg" style="display: none;">
            <span id="notificationCount">1</span>
        </div>
        
        <!-- Tooltip -->
        <div class="absolute bottom-full right-0 mb-4 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap pointer-events-none">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span>Chat with Haven Support</span>
            </div>
            <div class="absolute top-full right-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
        </div>
    </div>

    <!-- Chat Modal - No Animations -->
    <div id="chatModal" style="display: none;" 
         class="fixed bottom-0 right-0 sm:bottom-6 sm:right-6 w-full sm:w-96 h-[500px] sm:h-[600px] max-h-[90vh] card-premium flex flex-col overflow-hidden z-[99999]">
        
        <!-- Header -->
        <div class="bg-primary-900 text-white p-4 flex items-center justify-between shrink-0 rounded-t-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-accent-500 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm">Haven Support</h3>
                    <p class="text-gray-300 text-xs flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Online now
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @auth
                <button onclick="loadChatHistory()" class="text-gray-300 hover:text-white p-1 hover:bg-white/10 rounded transition-colors" title="Refresh messages">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
                @endauth
                <button onclick="closeChat()" 
                        class="text-gray-300 hover:text-white p-2 hover:bg-white/10 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Messages Area -->
        <div id="messagesContainer" class="flex-1 p-4 overflow-y-auto bg-gray-50 min-h-0">
            <div class="space-y-4">
                @auth
                    <!-- Welcome Message for Authenticated Users -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-accent-500 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="bg-white rounded-lg rounded-tl-sm p-3 shadow-sm border border-gray-100">
                                <p class="text-sm text-gray-800 leading-relaxed">
                                    Hello {{ Auth::check() ? Auth::user()->name : 'Guest' }}! Welcome to Haven support. How can I assist you with your property needs today?
                                </p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 font-medium">Just now</p>
                        </div>
                    </div>
                @else
                    <!-- Login Required Message -->
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center p-6 bg-white rounded-xl shadow-sm border border-gray-100 max-w-sm">
                            <div class="w-16 h-16 bg-accent-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-primary-900 mb-2 font-heading">Login Required</h3>
                            <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                                Please sign in to your Haven account to access our chat support.
                            </p>
                            <div class="space-y-3">
                                <a href="{{ route('login') }}" 
                                   class="btn-accent block text-center">
                                    Sign In
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="btn-secondary block text-center">
                                    Create Account
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Quick Actions -->
        @auth
        <div id="quickActions" class="px-4 pb-3 shrink-0">
            <div class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-3">Quick Actions</div>
            <div class="grid grid-cols-2 gap-2">
                <button onclick="sendQuickMessage('I\'m looking for a property to buy')" 
                        class="px-3 py-2 bg-gray-50 hover:bg-accent-500 hover:text-white text-xs font-medium rounded-lg transition-all duration-300 border border-gray-200 hover:border-accent-500 text-gray-700">
                    Looking to Buy
                </button>
                <button onclick="sendQuickMessage('I\'m interested in rental properties')" 
                        class="px-3 py-2 bg-gray-50 hover:bg-accent-500 hover:text-white text-xs font-medium rounded-lg transition-all duration-300 border border-gray-200 hover:border-accent-500 text-gray-700">
                    Looking to Rent
                </button>
                <button onclick="sendQuickMessage('I need help with property valuation')" 
                        class="px-3 py-2 bg-gray-50 hover:bg-accent-500 hover:text-white text-xs font-medium rounded-lg transition-all duration-300 border border-gray-200 hover:border-accent-500 text-gray-700">
                    Property Valuation
                </button>
                <button onclick="sendQuickMessage('I want to schedule a viewing')" 
                        class="px-3 py-2 bg-gray-50 hover:bg-accent-500 hover:text-white text-xs font-medium rounded-lg transition-all duration-300 border border-gray-200 hover:border-accent-500 text-gray-700">
                    Schedule Viewing
                </button>
            </div>
        </div>
        @endauth
        
        <!-- Input Area -->
        <div class="p-4 border-t border-gray-200 bg-white shrink-0 rounded-b-xl">
            @auth
            <form onsubmit="sendMessage(event)" class="flex items-center gap-3">
                <input type="text" id="messageInput" placeholder="Type your message..."
                       class="input-field flex-1 text-gray-800"
                       maxlength="1000">
                
                <button type="submit" id="sendButton"
                        class="w-12 h-12 bg-accent-500 hover:bg-accent-600 disabled:bg-gray-300 text-white rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-105 disabled:scale-100 shadow-lg disabled:shadow-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
            
            <!-- Connection Status -->
            <div class="flex items-center justify-center mt-3 text-xs text-gray-500">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span>Secure connection • End-to-end encrypted</span>
                </div>
            </div>
            @else
            <!-- Login Prompt for Input Area -->
            <div class="text-center py-3">
                <p class="text-sm text-gray-600 mb-3">Sign in to start chatting with our support team</p>
                <div class="flex gap-2 justify-center">
                    <a href="{{ route('login') }}" 
                       class="btn-accent text-xs px-4 py-2">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" 
                       class="btn-secondary text-xs px-4 py-2">
                        Register
                    </a>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>

<script>
let messages = [];
let messageId = 1;
let isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
let userName = '{{ Auth::check() ? Auth::user()->name : 'Guest' }}';
let currentUserAvatar = '{{ Auth::check() && Auth::user()->avatar ? asset("storage/" . Auth::user()->avatar) : "" }}';
let unreadCount = 0;
let hasUnreadMessages = false;

function openChat() {
    console.log('Opening enhanced chat...');
    document.getElementById('chatButton').style.display = 'none';
    const modal = document.getElementById('chatModal');
    modal.style.display = 'flex';
    
    // Clear notifications when chat is opened
    clearNotifications();
    
    scrollToBottom();
    
    // Load chat history if authenticated
    if (isAuthenticated) {
        loadChatHistory();
    }
}

function clearNotifications() {
    unreadCount = 0;
    hasUnreadMessages = false;
    const badge = document.getElementById('notificationBadge');
    if (badge) {
        badge.style.display = 'none';
    }
}

function showNotification(count = 1) {
    // Only show notification if there are actual unread messages (no dummy data)
    if (count > 0) {
        unreadCount = count;
        hasUnreadMessages = true;
        
        const badge = document.getElementById('notificationBadge');
        const countElement = document.getElementById('notificationCount');
        
        if (badge && countElement) {
            countElement.textContent = count;
            badge.style.display = 'flex';
            
            // Add bounce animation
            badge.classList.add('animate-bounce');
            setTimeout(() => {
                badge.classList.remove('animate-bounce');
            }, 1000);
            
            console.log(`Showing notification badge with ${count} unread messages`);
        }
    }
}

function closeChat() {
    console.log('Closing enhanced chat...');
    document.getElementById('chatButton').style.display = 'block';
    document.getElementById('chatModal').style.display = 'none';
}

async function sendMessage(event) {
    event.preventDefault();
    
    // Check authentication
    if (!isAuthenticated) {
        alert('Please sign in to send messages.');
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Add user message
    addMessage(message, true, currentUserAvatar || null);
    input.value = '';
    
    // Hide quick actions after first message
    const quickActions = document.getElementById('quickActions');
    if (quickActions) {
        quickActions.style.display = 'none';
    }
    
    // Send to server (no automatic bot response)
    try {
        const response = await fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                message: message,
                session_id: getSessionId()
            })
        });
        
        if (response.ok) {
            const data = await response.json();
            if (data.success) {
                // Message sent successfully - no automatic response
                console.log('Message sent successfully');
                
                // Show a subtle confirmation that message was sent
                showMessageSentConfirmation();
            }
        } else {
            throw new Error('Failed to send message');
        }
    } catch (error) {
        console.error('Error sending message:', error);
        showErrorMessage('Sorry, there was an error sending your message. Please try again.');
    }
}

function sendQuickMessage(message) {
    if (!isAuthenticated) {
        alert('Please sign in to send messages.');
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    document.getElementById('messageInput').value = message;
    sendMessage({ preventDefault: () => {} });
}

async function loadChatHistory() {
    if (!isAuthenticated) return;
    
    try {
        const response = await fetch(`/chat/history?session_id=${getSessionId()}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            console.log('Chat history loaded:', data); // Debug log
            
            if (data.success && data.messages && data.messages.length > 0) {
                // Clear existing dynamic messages (keep welcome message)
                const container = document.getElementById('messagesContainer').querySelector('.space-y-4');
                const welcomeMessage = container.firstElementChild;
                
                // Remove all messages except the welcome message
                while (container.children.length > 1) {
                    container.removeChild(container.lastChild);
                }
                
                // Add chat history messages
                data.messages.forEach(msg => {
                    addMessage(msg.text || msg.message, msg.is_user || msg.is_from_user, msg.sender_avatar);
                });
                
                console.log(`Loaded ${data.messages.length} messages from history`);
            }
        } else {
            console.error('Failed to load chat history:', response.status);
        }
    } catch (error) {
        console.error('Error loading chat history:', error);
    }
}

function getSessionId() {
    let sessionId = localStorage.getItem('haven_chat_session');
    if (!sessionId) {
        sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('haven_chat_session', sessionId);
    }
    return sessionId;
}

function addMessage(text, isUser, senderAvatar = null) {
    if (!isAuthenticated) return;
    
    const messagesContainer = document.getElementById('messagesContainer').querySelector('.space-y-4');
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `flex items-start gap-3 ${isUser ? 'flex-row-reverse' : ''}`;
    
    const userIcon = `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>`;
    
    const supportIcon = `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
    </svg>`;
    
    // Determine avatar content
    let avatarContent;
    if (senderAvatar) {
        avatarContent = `<img src="${senderAvatar}" alt="Profile" class="w-full h-full object-cover rounded-full">`;
    } else {
        avatarContent = isUser ? userIcon : supportIcon;
    }
    
    messageDiv.innerHTML = `
        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 overflow-hidden ${isUser ? 'bg-primary-900' : 'bg-accent-500'}">
            ${avatarContent}
        </div>
        <div class="flex-1">
            <div class="rounded-lg p-3 shadow-sm max-w-[250px] ${isUser ? 'bg-primary-900 text-white rounded-tr-sm ml-auto' : 'bg-white text-gray-800 rounded-tl-sm border border-gray-100'}">
                <p class="text-sm leading-relaxed">${text}</p>
            </div>
            <p class="text-xs text-gray-500 mt-1 font-medium ${isUser ? 'text-right mr-1' : ''}">Just now</p>
        </div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    messages.push({ id: messageId++, text, isUser, timestamp: new Date(), senderAvatar });
    
    scrollToBottom();
}

function showMessageSentConfirmation() {
    // Show a subtle confirmation that the message was sent
    const container = document.getElementById('messagesContainer').querySelector('.space-y-4');
    
    const confirmDiv = document.createElement('div');
    confirmDiv.className = 'text-center py-2';
    confirmDiv.innerHTML = `
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 text-xs rounded-full border border-green-200">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Message sent successfully
        </div>
    `;
    
    container.appendChild(confirmDiv);
    
    // Remove confirmation after 3 seconds
    setTimeout(() => {
        if (confirmDiv.parentNode) {
            confirmDiv.remove();
        }
    }, 3000);
    
    scrollToBottom();
}

function showErrorMessage(message) {
    const container = document.getElementById('messagesContainer').querySelector('.space-y-4');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'text-center py-2';
    errorDiv.innerHTML = `
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-50 text-red-700 text-xs rounded-full border border-red-200">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            ${message}
        </div>
    `;
    
    container.appendChild(errorDiv);
    
    // Remove error after 5 seconds
    setTimeout(() => {
        if (errorDiv.parentNode) {
            errorDiv.remove();
        }
    }, 5000);
    
    scrollToBottom();
}

// Function to check for new messages from support staff
async function checkForNewMessages() {
    if (!isAuthenticated) return;
    
    try {
        const response = await fetch(`/chat/history?session_id=${getSessionId()}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            console.log('Checking for new messages:', data);
            
            if (data.success && data.messages && data.messages.length > 0) {
                // Only count messages from support staff (not user messages)
                const supportMessages = data.messages.filter(msg => !msg.is_user && !msg.is_from_user);
                const currentSupportMessages = messages.filter(msg => !msg.isUser);
                
                console.log(`Current support messages: ${currentSupportMessages.length}, Server support messages: ${supportMessages.length}`);
                
                if (supportMessages.length > currentSupportMessages.length) {
                    console.log('New support messages found');
                    
                    // Check if chat is closed to show notification
                    const modal = document.getElementById('chatModal');
                    const isChatClosed = !modal || modal.style.display !== 'flex';
                    
                    if (isChatClosed) {
                        // Calculate new support messages count
                        const newSupportMessagesCount = supportMessages.length - currentSupportMessages.length;
                        
                        // Only show notification if there are actual new support messages (no dummy data)
                        if (newSupportMessagesCount > 0) {
                            showNotification(newSupportMessagesCount);
                            console.log(`Showing notification for ${newSupportMessagesCount} new support messages`);
                        }
                    }
                    
                    // Reload all messages to get the latest
                    loadChatHistory();
                }
            } else {
                // No messages - ensure notification is hidden
                clearNotifications();
            }
        } else {
            console.error('Failed to check for new messages:', response.status);
        }
    } catch (error) {
        console.error('Error checking for new messages:', error);
    }
}

function scrollToBottom() {
    const container = document.getElementById('messagesContainer');
    setTimeout(() => {
        container.scrollTop = container.scrollHeight;
    }, 100);
}

// Initialize chat
document.addEventListener('DOMContentLoaded', function() {
    console.log('Enhanced chat initialized successfully');
    console.log('User authenticated:', isAuthenticated);
    
    // Ensure notification badge is hidden on page load (no dummy data)
    const badge = document.getElementById('notificationBadge');
    if (badge) {
        badge.style.display = 'none';
    }
    
    // Reset notification counters
    unreadCount = 0;
    hasUnreadMessages = false;
    
    // Check for new messages every 5 seconds if authenticated (only shows real notifications)
    if (isAuthenticated) {
        setInterval(() => {
            console.log('Polling for new messages...');
            checkForNewMessages();
        }, 5000); // Check every 5 seconds
    }
});
</script>
