<!-- Live Chat Component - Fixed Version -->
<div x-data="liveChatFixed()" x-init="init()" class="fixed bottom-6 right-6 z-[99999]">
    
    <!-- Chat Toggle Button -->
    <div x-show="!isOpen" class="relative">
        <!-- Chat Button -->
        <button @click="openChat()" 
                class="group w-16 h-16 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:-translate-y-1">
            <svg class="w-7 h-7 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </button>

        <!-- Status Indicator -->
        <div class="absolute -top-1 -left-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white animate-pulse shadow-lg"></div>
        
        <!-- Tooltip -->
        <div class="absolute bottom-full right-0 mb-4 px-3 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span>Chat with Haven Support</span>
            </div>
            <div class="absolute top-full right-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
        </div>
    </div>

    <!-- Chat Modal -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="fixed bottom-0 right-0 sm:bottom-6 sm:right-6 w-full sm:w-96 h-[500px] sm:h-[600px] max-h-[90vh] bg-white rounded-t-[24px] sm:rounded-[24px] shadow-2xl border border-gray-200 flex flex-col overflow-hidden z-[99999]"
         style="display: none;">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 text-white p-4 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-teal-800 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-sm">H</span>
                </div>
                <div>
                    <h3 class="font-bold text-sm">Haven Support</h3>
                    <p class="text-teal-100 text-xs flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Online now
                    </p>
                </div>
            </div>
            <button @click="closeChat()" 
                    class="text-teal-200 hover:text-white p-2 hover:bg-teal-800 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Messages Area -->
        <div class="flex-1 p-4 overflow-y-auto bg-gray-50 min-h-0" x-ref="messagesContainer">
            <div class="space-y-4">
                <!-- Welcome Message -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center shrink-0">
                        <span class="text-white font-bold text-xs">H</span>
                    </div>
                    <div class="flex-1">
                        <div class="bg-white rounded-lg rounded-tl-sm p-3 shadow-sm border border-gray-100">
                            <p class="text-sm text-gray-800">
                                Welcome to Haven! I'm here to help you find your perfect property. How can I assist you today?
                            </p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Just now</p>
                    </div>
                </div>

                <!-- Dynamic Messages -->
                <template x-for="message in messages" :key="message.id">
                    <div class="flex items-start gap-3" :class="message.is_user ? 'flex-row-reverse' : ''">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" 
                             :class="message.is_user ? 'bg-gray-600' : 'bg-teal-600'">
                            <span class="text-white font-bold text-xs" x-text="message.is_user ? 'Y' : 'H'"></span>
                        </div>
                        <div class="flex-1">
                            <div class="rounded-lg p-3 shadow-sm max-w-[250px]" 
                                 :class="message.is_user ? 'bg-gray-600 text-white rounded-tr-sm ml-auto' : 'bg-white text-gray-800 rounded-tl-sm border border-gray-100'">
                                <p class="text-sm" x-text="message.text"></p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1" 
                               :class="message.is_user ? 'text-right' : ''"
                               x-text="formatTime(message.timestamp)"></p>
                        </div>
                    </div>
                </template>

                <!-- Typing Indicator -->
                <div x-show="isTyping" class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center shrink-0">
                        <span class="text-white font-bold text-xs">H</span>
                    </div>
                    <div class="flex-1">
                        <div class="bg-white rounded-lg rounded-tl-sm p-3 shadow-sm border border-gray-100">
                            <div class="flex items-center gap-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Haven Support is typing...</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Input Area -->
        <div class="p-4 border-t border-gray-200 bg-white shrink-0">
            <form @submit.prevent="sendMessage()" class="flex items-center gap-3">
                <input type="text" 
                       x-model="currentMessage" 
                       placeholder="Type your message..."
                       class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-full focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:bg-white transition-all text-sm"
                       :disabled="isTyping || isSending"
                       maxlength="1000">
                
                <button type="submit" 
                        :disabled="!currentMessage.trim() || isTyping || isSending"
                        class="w-12 h-12 bg-teal-600 hover:bg-teal-700 disabled:bg-gray-300 text-white rounded-full flex items-center justify-center transition-all duration-200 transform hover:scale-105 disabled:scale-100 shadow-lg disabled:shadow-none">
                    <svg x-show="!isSending" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <svg x-show="isSending" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function liveChatFixed() {
    return {
        isOpen: false,
        messages: [],
        currentMessage: '',
        isTyping: false,
        isSending: false,
        sessionId: null,
        
        init() {
            console.log('Live chat fixed version initializing...');
            this.sessionId = this.getSessionId();
            console.log('Chat initialized with session:', this.sessionId);
        },
        
        getSessionId() {
            let sessionId = localStorage.getItem('haven_chat_session');
            if (!sessionId) {
                sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                localStorage.setItem('haven_chat_session', sessionId);
            }
            return sessionId;
        },
        
        openChat() {
            console.log('Opening chat...');
            this.isOpen = true;
            this.scrollToBottom();
        },
        
        closeChat() {
            console.log('Closing chat...');
            this.isOpen = false;
        },
        
        async sendMessage() {
            if (!this.currentMessage.trim() || this.isSending) return;
            
            const messageText = this.currentMessage.trim();
            this.currentMessage = '';
            this.isSending = true;
            
            // Add user message immediately
            const userMessage = {
                id: Date.now(),
                text: messageText,
                is_user: true,
                timestamp: new Date().toISOString()
            };
            
            this.messages.push(userMessage);
            this.scrollToBottom();
            
            try {
                // Simulate API call for now
                this.isTyping = true;
                
                setTimeout(() => {
                    this.isTyping = false;
                    
                    // Add bot response
                    const botMessage = {
                        id: Date.now() + 1,
                        text: this.generateResponse(messageText),
                        is_user: false,
                        timestamp: new Date().toISOString()
                    };
                    
                    this.messages.push(botMessage);
                    this.scrollToBottom();
                }, 1500);
                
            } catch (error) {
                console.error('Error sending message:', error);
            } finally {
                this.isSending = false;
            }
        },
        
        generateResponse(message) {
            const responses = [
                "Thank you for your message! I'd be happy to help you find the perfect property.",
                "That's a great question! Let me connect you with one of our property experts.",
                "I understand you're looking for property information. What specific area interests you?",
                "Thanks for reaching out! Our team specializes in helping clients find their dream homes.",
                "I'd love to help you with that! What's your budget range and preferred location?"
            ];
            return responses[Math.floor(Math.random() * responses.length)];
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
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    }
}
</script>
