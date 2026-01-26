@extends('layouts.admin')

@section('title', 'Live Chat Management - Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-primary-950 uppercase tracking-tighter">Live Chat Management</h1>
                    <p class="text-gray-600 font-light mt-2">Monitor and respond to customer inquiries in real-time</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-700">Online</span>
                    </div>
                    <button onclick="toggleAutoRefresh()" 
                            class="px-3 py-2 text-sm font-medium rounded-lg transition-colors"
                            :class="isAutoRefreshEnabled ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            id="autoRefreshBtn">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Auto-refresh: ON
                    </button>
                    <button onclick="refreshChats()" class="px-4 py-2 bg-accent-600 text-white font-medium rounded-lg hover:bg-accent-700 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Refresh Now
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Chat Sessions List -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-black text-primary-950 uppercase tracking-wide">Active Chats</h2>
                        <p class="text-sm text-gray-600 mt-1">Recent customer conversations</p>
                    </div>
                    
                    <div class="divide-y divide-gray-100 max-h-[600px] overflow-y-auto" id="chatSessionsList">
                        <!-- Chat sessions will be loaded here -->
                        <div class="p-6 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="font-medium">No active chats</p>
                            <p class="text-sm text-gray-400 mt-1">New conversations will appear here</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Conversation -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden h-[700px] flex flex-col">
                    <!-- Chat Header -->
                    <div class="p-6 border-b border-gray-100 bg-primary-950 text-white" id="chatHeader">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-accent-600 rounded-full flex items-center justify-center">
                                    <span class="font-black text-sm">?</span>
                                </div>
                                <div>
                                    <h3 class="font-black text-sm uppercase tracking-wide">Select a conversation</h3>
                                    <p class="text-white/60 text-xs">Choose a chat from the left panel</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                <span class="text-xs font-medium text-white/60">Offline</span>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Area -->
                    <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50" id="messagesArea">
                        <div class="text-center text-gray-500 mt-20">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z"/>
                            </svg>
                            <p class="font-medium text-lg">No conversation selected</p>
                            <p class="text-sm text-gray-400 mt-1">Select a chat session to view messages</p>
                        </div>
                    </div>

                    <!-- Message Input -->
                    <div class="p-6 border-t border-gray-100 bg-white" id="messageInput" style="display: none;">
                        <form onsubmit="sendAdminMessage(event)" class="flex items-center gap-4">
                            <div class="flex-1 relative">
                                <input type="text" 
                                       id="adminMessageInput"
                                       placeholder="Type your response..."
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-full focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all text-sm font-medium">
                                
                                <!-- Quick Responses -->
                                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <button type="button" onclick="toggleQuickResponses()" class="text-gray-400 hover:text-accent-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <button type="submit" 
                                    class="w-12 h-12 bg-accent-600 hover:bg-accent-700 text-white rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </button>
                        </form>

                        <!-- Quick Response Templates -->
                        <div id="quickResponses" class="mt-4 hidden">
                            <div class="text-xs font-black uppercase tracking-wide text-gray-400 mb-3">Quick Responses</div>
                            <div class="flex flex-wrap gap-2">
                                <button onclick="insertQuickResponse('Thank you for contacting Haven. How can I assist you today?')" 
                                        class="px-3 py-2 bg-gray-100 hover:bg-accent-600 hover:text-white text-xs font-medium rounded-full transition-all">
                                    Welcome Message
                                </button>
                                <button onclick="insertQuickResponse('I\'d be happy to help you find the perfect property. Let me connect you with one of our specialists.')" 
                                        class="px-3 py-2 bg-gray-100 hover:bg-accent-600 hover:text-white text-xs font-medium rounded-full transition-all">
                                    Property Inquiry
                                </button>
                                <button onclick="insertQuickResponse('Let me schedule a consultation for you. What time works best?')" 
                                        class="px-3 py-2 bg-gray-100 hover:bg-accent-600 hover:text-white text-xs font-medium rounded-full transition-all">
                                    Schedule Meeting
                                </button>
                                <button onclick="insertQuickResponse('Thank you for your patience. I\'ll get back to you shortly with more information.')" 
                                        class="px-3 py-2 bg-gray-100 hover:bg-accent-600 hover:text-white text-xs font-medium rounded-full transition-all">
                                    Follow Up
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Statistics -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Chats</p>
                        <p class="text-3xl font-black text-primary-950" id="activeChatsCount">0</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Today's Chats</p>
                        <p class="text-3xl font-black text-primary-950" id="todayChatsCount">0</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Avg Response Time</p>
                        <p class="text-3xl font-black text-primary-950" id="avgResponseTime">2m</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Satisfaction Rate</p>
                        <p class="text-3xl font-black text-primary-950" id="satisfactionRate">98%</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentChatSession = null;
let chatSessions = [];
let lastUpdateTime = null;
let isAutoRefreshEnabled = true;

// Initialize chat management
document.addEventListener('DOMContentLoaded', function() {
    loadChatSessions();
    loadStatistics();
    
    // Reasonable refresh intervals - only if auto-refresh is enabled
    setInterval(() => {
        if (isAutoRefreshEnabled) {
            loadChatSessions();
        }
    }, 15000); // Every 15 seconds
    
    setInterval(() => {
        if (isAutoRefreshEnabled) {
            loadStatistics();
        }
    }, 60000); // Every 60 seconds
    
    // Auto-refresh current conversation less frequently
    setInterval(() => {
        if (currentChatSession && isAutoRefreshEnabled) {
            selectChatSession(currentChatSession.id);
        }
    }, 10000); // Every 10 seconds
});

// Load chat sessions from server
async function loadChatSessions() {
    try {
        const response = await fetch('/admin/chat/sessions', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            if (data.success) {
                chatSessions = data.sessions;
                renderChatSessions();
            }
        }
    } catch (error) {
        console.error('Error loading chat sessions:', error);
    }
}

// Load statistics from server
async function loadStatistics() {
    try {
        const response = await fetch('/admin/chat/statistics', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            if (data.success) {
                updateStatisticsDisplay(data.statistics);
            }
        }
    } catch (error) {
        console.error('Error loading statistics:', error);
    }
}

// Update statistics display
function updateStatisticsDisplay(stats) {
    document.getElementById('activeChatsCount').textContent = stats.active_chats;
    document.getElementById('todayChatsCount').textContent = stats.today_chats;
    document.getElementById('avgResponseTime').textContent = stats.avg_response_time;
    document.getElementById('satisfactionRate').textContent = stats.satisfaction_rate;
}

// Render chat sessions list
function renderChatSessions() {
    const container = document.getElementById('chatSessionsList');
    
    if (chatSessions.length === 0) {
        container.innerHTML = `
            <div class="p-6 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p class="font-medium">No active chats</p>
                <p class="text-sm text-gray-400 mt-1">New conversations will appear here</p>
            </div>
        `;
        return;
    }

    container.innerHTML = chatSessions.map(session => {
        // Determine user avatar content
        let avatarContent;
        if (session.user_avatar) {
            avatarContent = `<img src="${session.user_avatar}" alt="Profile" class="w-full h-full object-cover rounded-full">`;
        } else {
            avatarContent = `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>`;
        }
        
        return `
        <div class="p-4 hover:bg-gray-50 cursor-pointer transition-all duration-200 border-l-4 ${currentChatSession?.id === session.id ? 'bg-accent-50 border-accent-600 shadow-sm' : 'border-transparent hover:border-gray-200'}" 
             onclick="selectChatSession(${session.id})">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 bg-gradient-to-r from-accent-600 to-accent-700 rounded-full flex items-center justify-center shadow-sm overflow-hidden">
                            ${avatarContent}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 rounded-full border-2 border-white ${session.status === 'active' ? 'bg-green-500 animate-pulse' : 'bg-yellow-500'}"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-sm text-primary-950 truncate">${session.user_name || 'Anonymous User'}</h4>
                        <p class="text-xs text-gray-500 truncate">${session.user_email || ''}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    ${session.unread_count > 0 ? `<div class="w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse shadow-lg">${session.unread_count}</div>` : ''}
                    <div class="text-xs text-gray-400 font-medium">${formatTime(session.last_activity)}</div>
                </div>
            </div>
            <p class="text-sm text-gray-600 truncate mb-1 pl-13">${session.last_message || 'New conversation'}</p>
            <div class="flex items-center justify-between text-xs text-gray-400 pl-13">
                <span class="flex items-center gap-1">
                    <div class="w-1 h-1 rounded-full ${session.status === 'active' ? 'bg-green-500' : 'bg-yellow-500'}"></div>
                    ${session.status === 'active' ? 'Active' : 'Waiting'}
                </span>
                ${currentChatSession?.id === session.id ? '<span class="text-accent-600 font-medium">Selected</span>' : ''}
            </div>
        </div>
        `;
    }).join('');
}

// Select chat session and load messages
async function selectChatSession(sessionId) {
    try {
        const response = await fetch(`/admin/chat/sessions/${sessionId}/messages`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            if (data.success) {
                currentChatSession = data.session;
                currentChatSession.id = sessionId;
                
                // Update header
                updateChatHeader(data.session);
                
                // Load messages
                renderMessages(data.messages);
                
                // Show message input
                document.getElementById('messageInput').style.display = 'block';
                
                // Mark as read
                await markSessionAsRead(sessionId);
                
                // Re-render sessions to update selection
                renderChatSessions();
            }
        }
    } catch (error) {
        console.error('Error loading chat session:', error);
    }
}

// Update chat header
function updateChatHeader(session) {
    document.getElementById('chatHeader').innerHTML = `
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-r from-accent-600 to-accent-700 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-black text-sm uppercase tracking-wide text-white">${session.user_name || 'Anonymous User'}</h3>
                    <p class="text-white/60 text-xs">${session.user_email || ''}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 ${session.status === 'active' ? 'bg-green-500 animate-pulse' : 'bg-yellow-500'} rounded-full"></div>
                <span class="text-xs font-medium text-white/60">${session.status === 'active' ? 'Active' : 'Waiting'}</span>
            </div>
        </div>
    `;
}

// Render messages
function renderMessages(messages) {
    const messagesArea = document.getElementById('messagesArea');
    
    if (messages.length === 0) {
        messagesArea.innerHTML = `
            <div class="text-center text-gray-500 mt-20">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z"/>
                </svg>
                <p class="font-medium text-lg">No messages yet</p>
                <p class="text-sm text-gray-400 mt-1">Start the conversation with this user</p>
            </div>
        `;
        return;
    }

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
                    <span>${message.sender_name || (message.is_user ? 'User' : 'Haven Support')}</span>
                    ${message.is_user && message.is_read ? '<svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>' : ''}
                </div>
            </div>
        </div>
        `;
    }).join('');

    // Scroll to bottom
    messagesArea.scrollTop = messagesArea.scrollHeight;
}

// Send admin message
async function sendAdminMessage(event) {
    event.preventDefault();
    
    const input = document.getElementById('adminMessageInput');
    const message = input.value.trim();
    
    if (!message || !currentChatSession) return;

    try {
        const response = await fetch(`/admin/chat/sessions/${currentChatSession.id}/send`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message })
        });
        
        if (response.ok) {
            const data = await response.json();
            if (data.success) {
                // Add message to UI immediately
                const messagesArea = document.getElementById('messagesArea');
                
                // Determine admin avatar content
                const adminAvatar = data.message.sender_avatar;
                let avatarContent;
                if (adminAvatar) {
                    avatarContent = `<img src="${adminAvatar}" alt="Profile" class="w-full h-full object-cover rounded-full">`;
                } else {
                    avatarContent = `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>`;
                }
                
                const messageHtml = `
                    <div class="flex items-start gap-3 animate-fade-in">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 shadow-sm overflow-hidden bg-gradient-to-r from-accent-600 to-accent-700">
                            ${avatarContent}
                        </div>
                        <div class="flex-1 max-w-xs">
                            <div class="rounded-2xl p-4 bg-white text-primary-950 rounded-tl-sm shadow-sm border border-gray-100">
                                <p class="text-sm font-medium leading-relaxed">${message}</p>
                            </div>
                            <div class="text-xs text-gray-400 font-medium mt-2 flex items-center gap-2">
                                <span>Just now</span>
                                <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                                <span>${data.message.sender_name}</span>
                            </div>
                        </div>
                    </div>
                `;
                
                messagesArea.insertAdjacentHTML('beforeend', messageHtml);
                messagesArea.scrollTop = messagesArea.scrollHeight;
                
                // Clear input
                input.value = '';
                
                // Refresh sessions to update last message
                setTimeout(() => {
                    loadChatSessions();
                }, 500);
            } else {
                console.error('Failed to send admin message:', data);
            }
        } else {
            console.error('Failed to send admin message:', response.status);
        }
    } catch (error) {
        console.error('Error sending admin message:', error);
    }
}

// Mark session as read
async function markSessionAsRead(sessionId) {
    try {
        await fetch(`/admin/chat/sessions/${sessionId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    } catch (error) {
        console.error('Error marking session as read:', error);
    }
}

// Quick response functions
function toggleQuickResponses() {
    const quickResponses = document.getElementById('quickResponses');
    quickResponses.classList.toggle('hidden');
}

function insertQuickResponse(text) {
    document.getElementById('adminMessageInput').value = text;
    document.getElementById('quickResponses').classList.add('hidden');
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

function refreshChats() {
    console.log('Manual refresh triggered');
    loadChatSessions();
    loadStatistics();
    if (currentChatSession) {
        selectChatSession(currentChatSession.id);
    }
}

function toggleAutoRefresh() {
    isAutoRefreshEnabled = !isAutoRefreshEnabled;
    const btn = document.getElementById('autoRefreshBtn');
    
    if (isAutoRefreshEnabled) {
        btn.className = 'px-3 py-2 text-sm font-medium rounded-lg transition-colors bg-green-100 text-green-700 hover:bg-green-200';
        btn.innerHTML = `
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Auto-refresh: ON
        `;
        console.log('Auto-refresh enabled');
    } else {
        btn.className = 'px-3 py-2 text-sm font-medium rounded-lg transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200';
        btn.innerHTML = `
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Auto-refresh: OFF
        `;
        console.log('Auto-refresh disabled');
    }
}
</script>
@endsection
