<!-- Simple Live Chat Test -->
<div x-data="{ isOpen: false, test: 'Alpine Working!' }" class="fixed bottom-6 right-6 z-[99999]">
    
    <!-- Debug Info -->
    <div class="absolute -top-20 right-0 bg-yellow-400 text-black text-xs p-2 rounded shadow-lg">
        <div>Status: <span x-text="test">Loading...</span></div>
        <div>Chat Open: <span x-text="isOpen ? 'YES' : 'NO'">Unknown</span></div>
        <button @click="isOpen = !isOpen; console.log('Toggle clicked, isOpen now:', isOpen)" 
                class="bg-blue-500 text-white px-2 py-1 rounded mt-1 hover:bg-blue-600">
            Toggle Chat
        </button>
    </div>
    
    <!-- Chat Button -->
    <div x-show="!isOpen">
        <button @click="isOpen = true; console.log('Alpine button clicked, isOpen:', isOpen)" 
                onclick="console.log('Basic onclick working'); alert('Button clicked!');"
                class="w-16 h-16 bg-red-500 text-white rounded-full shadow-2xl flex items-center justify-center hover:bg-red-600">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </button>
    </div>

    <!-- Chat Modal -->
    <div x-show="isOpen" 
         class="fixed bottom-6 right-6 w-80 h-96 bg-white rounded-lg shadow-2xl border border-gray-200 flex flex-col z-[99999]">
        
        <!-- Header -->
        <div class="bg-blue-600 text-white p-3 rounded-t-lg flex items-center justify-between">
            <h3 class="font-bold">Test Chat</h3>
            <button @click="isOpen = false; console.log('Close clicked, isOpen:', isOpen)" 
                    class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Content -->
        <div class="flex-1 p-4 bg-gray-50">
            <div class="bg-white p-3 rounded shadow">
                <p class="text-sm">Chat is working! This is a test message.</p>
            </div>
        </div>
        
        <!-- Input -->
        <div class="p-3 border-t">
            <input type="text" placeholder="Type a message..." 
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>
</div>

<script>
// Test Alpine.js
document.addEventListener('alpine:init', () => {
    console.log('Alpine.js initialized successfully');
});

// Test if Alpine is loaded
setTimeout(() => {
    if (window.Alpine) {
        console.log('Alpine.js is available:', window.Alpine);
    } else {
        console.error('Alpine.js is NOT available');
    }
}, 1000);
</script>
