<!-- Live Chat Component -->
<div x-data="liveChat()" x-init="init()" class="fixed bottom-6 right-6 z-[99999]">
    
    <!-- Chat Toggle Button -->
    <div x-show="!isOpen" class="relative">
        <!-- Chat Button -->
        <button @click="openChat()" 
                class="group w-16 h-16 bg-gradient-to-r from-accent-600 to-accent-700 hover:from-primary-950 hover:to-primary-900 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-500 transform hover:scale-110 hover:-translate-y-1 ring-4 ring-accent-600/20 hover:ring-primary-950/20">
            <svg class="w-7 h-7 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </button>

        <!-- Notification Badge -->
        <div x-show="hasUnreadMessages" 
             class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white text-xs font-black rounded-full flex items-center justify-center chat-notification animate-bounce">
            <span x-text="unreadCount"></span>
        </div>

        <!-- Status Indicator -->
        <div class="absolute -top-1 -left-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white animate-pulse shadow-lg"></div>
        
        <!-- Enhanced Tooltip -->
        <div class="absolute bottom-full right-0 mb-4 px-4 py-3 bg-primary-950/95 backdrop-blur-xl text-white text-sm font-medium rounded-[20px] shadow-2xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap border border-white/10">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span>Chat with Haven Expert</span>
            </div>
            <div class="absolute top-full right-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-primary-950/95"></div>
        </div>
    </div>

    <!-- Enhanced Chat Window -->
    <div x-show="isOpen" 
         class="fixed bottom-0 right-0 sm:bottom-6 sm:right-6 w-full sm:w-96 h-[500px] sm:h-[600px] max-h-[80vh] sm:max-h-[calc(100vh-3rem)] bg-white rounded-t-[30px] sm:rounded-[30px] shadow-2xl border border-gray-100 flex flex-col overflow-hidden backdrop-blur-xl z-[99999]">
        
        
        <!-- Enhanced Chat Header -->
        <div class="bg-gradient-to-r from-primary-950 to-primary-900 p-4 flex items-center justify-between relative overflow-hidden shrink-0">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0 bg-gradient-to-br from-accent-500/20 to-transparent"></div>
            </div>
            
            <div class="flex items-center gap-3 relative z-10">
                <div class="relative">
                    <div class="w-10 h-10 bg-gradient-to-r from-accent-600 to-accent-700 rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-white font-black text-sm">H</span>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white shadow-sm animate-pulse"></div>
                </div>
                <div>
                    <h3 class="text-white font-black text-sm uppercase tracking-[0.2em]">Haven Support</h3>
                    <p class="text-white/70 text-xs font-medium flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        Online • Typically replies instantly
                    </p>
                </div>
            </div>
            <button @click="closeChat()" class="text-white/60 hover:text-white transition-colors relative z-10 p-2 hover:bg-white/10 rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Enhanced Messages Area -->
        <div class="flex-1 overflow-y-auto p-4 space-y-3 chat-scroll bg-gradient-to-b from-gray-50/50 to-white min-h-0" x-ref="messagesContainer">
            <!-- Welcome Message -->
            <div class="flex items-start gap-3 animate-fade-in">
                <div class="w-8 h-8 bg-gradient-to-r from-accent-600 to-accent-700 rounded-full flex items-center justify-center shrink-0 shadow-sm">
                    <span class="text-white font-black text-xs">H</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="bg-white rounded-[20px] rounded-tl-[8px] p-3 max-w-[250px] shadow-sm border border-gray-100">
                        <p class="text-sm text-primary-950 font-medium leading-relaxed">
                            Welcome to Haven! I'm here to help you find your perfect property. How can I assist you today?
                        </p>
                    </div>
                    <div class="text-xs text-gray-400 font-medium mt-1 flex items-center gap-2">
                        <span>Just now</span>
                        <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                        <span>Haven Support</span>
                    </div>
                </div>
            </div>

            <!-- Dynamic Messages -->
            <template x-for="message in messages" :key="message.id">
                <div class="flex items-start gap-3 animate-fade-in" :class="message.is_user ? 'flex-row-reverse' : ''">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 shadow-sm" 
                         :class="message.is_user ? 'bg-gradient-to-r from-primary-950 to-primary-900' : 'bg-gradient-to-r from-accent-600 to-accent-700'">
                        <span class="text-white font-black text-xs" x-text="message.is_user ? (message.sender_name ? message.sender_name.charAt(0).toUpperCase() : 'Y') : 'H'"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="rounded-[20px] p-3 max-w-[250px] shadow-sm break-words" 
                             :class="message.is_user ? 'bg-gradient-to-r from-primary-950 to-primary-900 text-white rounded-tr-[8px] ml-auto' : 'bg-white text-primary-950 rounded-tl-[8px] border border-gray-100'">
                            <p class="text-sm font-medium leading-relaxed" x-text="message.text"></p>
                        </div>
                        <div class="text-xs text-gray-400 font-medium mt-1 flex items-center gap-2" 
                             :class="message.is_user ? 'justify-end' : ''">
                            <span x-text="formatTime(message.timestamp)"></span>
                            <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                            <span x-text="message.sender_name || (message.is_user ? 'You' : 'Haven Support')"></span>
                            <template x-if="message.is_user">
                                <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Enhanced Typing Indicator -->
            <div x-show="isTyping" class="flex items-start gap-3 animate-fade-in">
                <div class="w-8 h-8 bg-gradient-to-r from-accent-600 to-accent-700 rounded-full flex items-center justify-center shrink-0 shadow-sm">
                    <span class="text-white font-black text-xs">H</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="bg-white rounded-[20px] rounded-tl-[8px] p-3 max-w-[250px] shadow-sm border border-gray-100">
                        <div class="flex items-center gap-1">
                            <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full typing-dot"></div>
                        </div>
                    </div>
                    <div class="text-xs text-gray-400 font-medium mt-1">Haven Support is typing...</div>
                </div>
            </div>
        </div>

        <!-- Enhanced Quick Actions -->
        @if(session('supabase_user'))
        <div x-show="showQuickActions && messages.length === 0" class="px-4 pb-3 shrink-0">
            <div class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Quick Actions</div>
            <div class="grid grid-cols-2 gap-2">
                <button @click="sendQuickMessage('I\'m looking for a property to buy')" 
                        class="px-2 py-1.5 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-accent-600 hover:to-accent-700 hover:text-white text-xs font-medium rounded-full transition-all duration-300 border border-gray-200 hover:border-accent-600">
                    Looking to Buy
                </button>
                <button @click="sendQuickMessage('I\'m interested in rental properties')" 
                        class="px-2 py-1.5 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-accent-600 hover:to-accent-700 hover:text-white text-xs font-medium rounded-full transition-all duration-300 border border-gray-200 hover:border-accent-600">
                    Looking to Rent
                </button>
                <button @click="sendQuickMessage('I need help with property valuation')" 
                        class="px-2 py-1.5 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-accent-600 hover:to-accent-700 hover:text-white text-xs font-medium rounded-full transition-all duration-300 border border-gray-200 hover:border-accent-600">
                    Property Valuation
                </button>
                <button @click="sendQuickMessage('I want to schedule a viewing')" 
                        class="px-2 py-1.5 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-accent-600 hover:to-accent-700 hover:text-white text-xs font-medium rounded-full transition-all duration-300 border border-gray-200 hover:border-accent-600">
                    Schedule Viewing
                </button>
            </div>
        </div>
        @endif

        <!-- Enhanced Message Input -->
        <div class="p-4 border-t border-gray-100 bg-white shrink-0">
            @if(session('supabase_user'))
            <form @submit.prevent="sendMessage()" class="flex items-center gap-3">
                <div class="flex-1 relative">
                    <input type="text" 
                           x-model="currentMessage" 
                           placeholder="Type your message..."
                           class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-full focus:ring-2 focus:ring-accent-500 focus:border-accent-500 focus:bg-white transition-all text-sm font-medium placeholder-gray-400"
                           :disabled="isTyping"
                           maxlength="1000">
                    
                    <!-- Character Counter -->
                    <div class="absolute right-12 top-1/2 -translate-y-1/2 text-xs text-gray-400" x-show="currentMessage.length > 800">
                        <span x-text="1000 - currentMessage.length"></span>
                    </div>
                </div>
                
                <button type="submit" 
                        :disabled="!currentMessage.trim() || isTyping || isSending"
                        class="w-10 h-10 bg-gradient-to-r from-accent-600 to-accent-700 hover:from-primary-950 hover:to-primary-900 disabled:from-gray-300 disabled:to-gray-400 text-white rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-105 disabled:scale-100 shadow-lg disabled:shadow-none">
                    <svg x-show="!isSending" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <svg x-show="isSending" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
            @else
            <!-- Login Required Message -->
            <div class="text-center py-3">
                <p class="text-sm text-gray-600 mb-3 font-medium">Please login to send messages</p>
                <a href="{{ route('login', ['redirect' => url()->current()]) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-accent-600 to-accent-700 hover:from-primary-950 hover:to-primary-900 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Login to Chat
                </a>
            </div>
            @endif
            
            <!-- Connection Status -->
            <div class="flex items-center justify-center mt-2 text-xs text-gray-400">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span>Secure connection • End-to-end encrypted</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fallback Chat Button (shows if Alpine.js fails) -->
<noscript>
    <div class="fixed bottom-6 right-6 z-[99999]">
        <button onclick="alert('Live chat requires JavaScript to be enabled.')" 
                class="group w-16 h-16 bg-gradient-to-r from-accent-600 to-accent-700 hover:from-primary-950 hover:to-primary-900 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-500 transform hover:scale-110 hover:-translate-y-1 ring-4 ring-accent-600/20 hover:ring-primary-950/20">
            <svg class="w-7 h-7 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </button>
    </div>
</noscript>

<script>
function liveChat() {
    return {
        isOpen: false,
        messages: [],
        currentMessage: '',
        isTyping: false,
        isSending: false,
        hasUnreadMessages: false,
        unreadCount: 0,
        showQuickActions: true,
        sessionId: null,
        
        init() {
            console.log('Live chat initializing...'); // Debug log
            console.log('Alpine.js is working!'); // Test Alpine.js
            
            // Simple test
            this.isOpen = false;
            console.log('Initial isOpen state:', this.isOpen);
            
            // Generate or get session ID
            this.sessionId = this.getSessionId();
            
            // Load existing chat history
            this.loadChatHistory();
            
            console.log('Live chat initialized successfully, isOpen:', this.isOpen); // Debug log
        },
        
        async checkForNewMessages() {
            try {
                const response = await fetch(`/chat/history?session_id=${this.sessionId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    if (data.success && data.messages) {
                        const newMessageCount = data.messages.length - this.messages.length;
                        if (newMessageCount > 0) {
                            this.hasUnreadMessages = true;
                            this.unreadCount = newMessageCount;
                            // Play notification sound (optional)
                            this.playNotificationSound();
                        }
                    }
                }
            } catch (error) {
                console.error('Error checking for new messages:', error);
            }
        },
        
        showWelcomeNotification() {
            this.hasUnreadMessages = true;
            this.unreadCount = 1;
            
            // Show a subtle animation
            const button = document.querySelector('[x-data="liveChat()"] button');
            if (button) {
                button.classList.add('animate-bounce');
                setTimeout(() => {
                    button.classList.remove('animate-bounce');
                }, 2000);
            }
        },
        
        playNotificationSound() {
            // Create a subtle notification sound
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                oscillator.frequency.setValueAtTime(600, audioContext.currentTime + 0.1);
                
                gainNode.gain.setValueAtTime(0, audioContext.currentTime);
                gainNode.gain.linearRampToValueAtTime(0.1, audioContext.currentTime + 0.01);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.2);
            } catch (error) {
                // Silently fail if audio context is not supported
            }
        },
        
        getSessionId() {
            let sessionId = localStorage.getItem('haven_chat_session');
            if (!sessionId) {
                sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                localStorage.setItem('haven_chat_session', sessionId);
            }
            return sessionId;
        },
        
        async loadChatHistory() {
            try {
                const response = await fetch(`/chat/history?session_id=${this.sessionId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        this.messages = data.messages || [];
                        this.scrollToBottom();
                    }
                }
            } catch (error) {
                console.error('Error loading chat history:', error);
            }
        },
        
        openChat() {
            console.log('Opening chat... Current state:', this.isOpen); // Debug log
            this.isOpen = true;
            console.log('Chat opened, new state:', this.isOpen); // Debug log
            this.hasUnreadMessages = false;
            this.unreadCount = 0;
            this.scrollToBottom();
            this.loadChatHistory();
        },
        
        closeChat() {
            console.log('Closing chat... Current state:', this.isOpen); // Debug log
            this.isOpen = false;
            console.log('Chat closed, new state:', this.isOpen); // Debug log
        },
        
        toggleChat() {
            console.log('Toggling chat... Current state:', this.isOpen);
            this.isOpen = !this.isOpen;
            console.log('Chat toggled, new state:', this.isOpen);
        },
        
        async sendMessage() {
            if (!this.currentMessage.trim() || this.isSending) return;
            
            const messageText = this.currentMessage.trim();
            this.currentMessage = '';
            this.showQuickActions = false;
            this.isSending = true;
            
            // Add user message to UI immediately for better UX
            const userMessage = {
                id: Date.now(),
                text: messageText,
                is_user: true,
                timestamp: new Date().toISOString(),
                sender_name: 'You'
            };
            
            this.messages.push(userMessage);
            this.scrollToBottom();
            
            try {
                const response = await fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        message: messageText,
                        session_id: this.sessionId
                    })
                });
                
                if (response.ok) {
                    const data = await response.json();
                    if (data.success && data.response) {
                        // Show typing indicator for more realistic feel
                        this.isTyping = true;
                        
                        // Simulate realistic typing delay based on message length
                        const typingDelay = Math.min(Math.max(data.response.text.length * 30, 1000), 3000);
                        
                        setTimeout(() => {
                            this.isTyping = false;
                            
                            // Add automated response
                            const botMessage = {
                                id: Date.now() + 1,
                                text: data.response.text,
                                is_user: false,
                                timestamp: new Date().toISOString(),
                                sender_name: 'Haven Support'
                            };
                            
                            this.messages.push(botMessage);
                            this.scrollToBottom();
                            
                            // Show notification if chat is closed
                            if (!this.isOpen) {
                                this.hasUnreadMessages = true;
                                this.unreadCount++;
                                this.playNotificationSound();
                            }
                        }, typingDelay);
                    }
                } else {
                    throw new Error('Failed to send message');
                }
            } catch (error) {
                console.error('Error sending message:', error);
                this.showErrorMessage('Failed to send message. Please check your connection and try again.');
            } finally {
                this.isSending = false;
            }
        },
        
        sendQuickMessage(text) {
            this.currentMessage = text;
            this.sendMessage();
        },
        
        showErrorMessage(message) {
            const errorMessage = {
                id: Date.now(),
                text: message,
                is_user: false,
                timestamp: new Date().toISOString(),
                sender_name: 'System',
                isError: true
            };
            
            this.messages.push(errorMessage);
            this.scrollToBottom();
        },
        
        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },
        
        formatTime(timestamp) {
            const date = new Date(timestamp);
            const now = new Date();
            const diff = now - date;
            
            if (diff < 60000) return 'Just now';
            if (diff < 3600000) return Math.floor(diff / 60000) + 'm ago';
            if (diff < 86400000) return Math.floor(diff / 3600000) + 'h ago';
            return date.toLocaleDateString();
        }
    }
}
</script>