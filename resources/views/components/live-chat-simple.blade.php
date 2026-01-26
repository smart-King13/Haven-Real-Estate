<!-- Live Chat Component -->
<div x-data="{ isOpen: false }" class="fixed bottom-6 right-6 z-[9999]">
    
    <!-- Chat Button -->
    <div x-show="!isOpen" class="relative">
        <button @click="isOpen = true" 
                class="w-16 h-16 bg-gradient-to-r from-teal-600 to-teal-700 text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-transform">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </button>
        
        <!-- Status indicator -->
        <div class="absolute -top-1 -left-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
    </div>

    <!-- Chat Modal -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="w-96 max-w-[calc(100vw-2rem)] h-[500px] max-h-[calc(100vh-2rem)] bg-white rounded-2xl shadow-2xl border border-gray-200 flex flex-col"
         style="position: fixed; bottom: 24px; right: 24px; z-index: 10000;">
        
        <!-- Header -->
        <div class="bg-teal-600 text-white p-4 rounded-t-2xl flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-teal-700 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-sm">H</span>
                </div>
                <div>
                    <h3 class="font-bold text-sm">Haven Support</h3>
                    <p class="text-teal-100 text-xs">Online now</p>
                </div>
            </div>
            <button @click="isOpen = false" 
                    class="text-teal-200 hover:text-white p-1 rounded">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Messages Area -->
        <div class="flex-1 p-4 overflow-y-auto bg-gray-50 min-h-0">
            <div class="space-y-4">
                <!-- Welcome Message -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-xs">H</span>
                    </div>
                    <div class="flex-1">
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <p class="text-sm text-gray-800">
                                Welcome to Haven! How can I help you today?
                            </p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Just now</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Input Area -->
        <div class="p-4 border-t border-gray-200 shrink-0">
            <div class="flex items-center gap-3">
                <input type="text" 
                       placeholder="Type your message..."
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                <button class="w-10 h-10 bg-teal-600 text-white rounded-full flex items-center justify-center hover:bg-teal-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
