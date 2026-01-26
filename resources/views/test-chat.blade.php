<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Chat Test - Haven</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-black text-primary-950 mb-4">Live Chat System Test</h1>
                <p class="text-gray-600 mb-6">This page demonstrates the Haven live chat system functionality.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Test Instructions -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-bold text-primary-950">Test Instructions</h2>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-accent-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</div>
                                <p>Click the chat button in the bottom-right corner</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-accent-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</div>
                                <p>Try sending different types of messages (buy, rent, valuation, etc.)</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-accent-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</div>
                                <p>Test the quick action buttons</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-accent-600 text-white rounded-full flex items-center justify-center text-xs font-bold">4</div>
                                <p>Close and reopen the chat to test persistence</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-accent-600 text-white rounded-full flex items-center justify-center text-xs font-bold">5</div>
                                <p>Check the admin panel at <a href="/admin/chat" class="text-accent-600 hover:underline">/admin/chat</a></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Test Messages -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-bold text-primary-950">Sample Test Messages</h2>
                        <div class="space-y-2 text-sm">
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <strong>Property Buying:</strong> "I'm looking for a property to buy"
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <strong>Rental Inquiry:</strong> "I need a rental property"
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <strong>Valuation:</strong> "What's my property worth?"
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <strong>Viewing:</strong> "I want to schedule a viewing"
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <strong>Investment:</strong> "Tell me about investment opportunities"
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <strong>General:</strong> "Hello, I need help"
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- API Status -->
                <div class="mt-8 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <h3 class="font-bold text-green-800 mb-2">System Status</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span>Chat API: Online</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span>Database: Connected</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span>Real-time: Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Live Chat Component -->
    @include('components.live-chat')
</body>
</html>
