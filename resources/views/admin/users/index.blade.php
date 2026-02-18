@extends('layouts.admin')

@section('title', 'Manage Users - Admin')
@section('page-title', 'User Management')

@section('content')
    <!-- Premium Header Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-8 py-16">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1 space-y-2">
                    <h1 class="text-3xl font-semibold text-white font-heading tracking-tight underline decoration-blue-500/30 decoration-8 underline-offset-4">
                        User Management
                    </h1>
                    <p class="text-lg text-primary-100/80 font-normal">
                        Control platform access, moderate roles, and manage registered members.
                    </p>
                </div>
            </div>
        </div>
    </div>

<!-- Filters Section -->
<div class="bg-white shadow-xl shadow-gray-200/60 rounded-3xl p-8 border border-gray-50 mb-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 font-heading tracking-tight uppercase">User <span class="text-blue-600">Discovery</span> Tool</h2>
    </div>
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 relative z-10">
        <div>
            <label class="field-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="input-field" 
                   placeholder="Search by name or email...">
        </div>
        <div>
            <x-select 
                name="role" 
                label="Role" 
                height="h-10"
                :value="request('role')"
                :options="[
                    ['value' => '', 'label' => 'All Roles'],
                    ['value' => 'admin', 'label' => 'Admin'],
                    ['value' => 'user', 'label' => 'User']
                ]"
            />
        </div>
        <div>
            <x-select 
                name="status" 
                label="Status" 
                height="h-10"
                :value="request('status')"
                :options="[
                    ['value' => '', 'label' => 'All Status'],
                    ['value' => 'active', 'label' => 'Active'],
                    ['value' => 'inactive', 'label' => 'Inactive']
                ]"
            />
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-primary w-full">
                Apply Filters
            </button>
        </div>
    </form>
</div>

<!-- Users Table Section -->
<div class="bg-white shadow-2xl shadow-gray-200/60 rounded-3xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">User Profile</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Permission</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Account Status</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Member Since</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Activity</th>
                    <th class="px-8 py-5 text-right text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($users as $user)
                <?php 
                    // Convert to object if array
                    $u = is_array($user) ? (object)$user : $user;
                ?>
                <tr class="group border-b border-gray-50 hover:bg-gray-50/50 transition-all duration-200">
                    <td class="px-8 py-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-14 w-14">
                                @if(isset($u->avatar) && $u->avatar)
                                    <img class="h-14 w-14 rounded-2xl object-cover border-4 border-white shadow-md" src="{{ asset('storage/' . $u->avatar) }}" alt="{{ $u->name ?? 'User' }}">
                                @else
                                    <div class="h-14 w-14 rounded-2xl bg-primary-50 border-4 border-white shadow-md flex items-center justify-center">
                                        <span class="text-lg font-semibold text-primary-600 uppercase">{{ substr($u->name ?? 'U', 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $u->name ?? 'Unknown' }}</div>
                                <div class="text-sm text-gray-600 mt-1">{{ $u->email ?? 'No email' }}</div>
                                @if(isset($u->phone) && $u->phone)
                                    <div class="text-xs text-gray-500 mt-1">{{ $u->phone }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium border
                            {{ ($u->role ?? 'user') === 'admin' ? 'bg-gray-100 text-gray-800 border-gray-200' : 'bg-teal-50 text-teal-700 border-teal-200' }}">
                            {{ ucfirst($u->role ?? 'user') }}
                        </span>
                    </td>
                    <td class="px-6 py-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium border
                            {{ ($u->is_active ?? true) ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                            {{ ($u->is_active ?? true) ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-6 text-sm text-gray-600">
                        {{ isset($u->created_at) ? date('M d, Y', strtotime($u->created_at)) : 'N/A' }}
                    </td>
                    <td class="px-6 py-6 text-sm text-gray-600">
                        {{ ($u->role ?? 'user') === 'admin' ? '0 properties' : '0 saved' }}
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <button onclick="viewUser('{{ $u->id }}')" 
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-400 hover:text-primary-900 hover:bg-gray-100 transition-all duration-200 border border-transparent hover:border-gray-100"
                                    title="View User">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                            <button onclick="toggleUserStatus('{{ $u->id }}', {{ ($u->is_active ?? true) ? 'false' : 'true' }})" 
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-400 hover:text-{{ ($u->is_active ?? true) ? 'red' : 'green' }}-600 hover:bg-{{ ($u->is_active ?? true) ? 'red' : 'green' }}-50 transition-all duration-200 border border-transparent hover:border-{{ ($u->is_active ?? true) ? 'red' : 'green' }}-100"
                                    title="{{ ($u->is_active ?? true) ? 'Deactivate' : 'Activate' }} User">
                                @if($u->is_active ?? true)
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                            <p class="text-gray-600 max-w-sm">No users match your current filters. Try adjusting your search criteria.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination removed - Supabase returns arrays not paginated collections --}}
</div>

<!-- User Details Modal -->
<div id="userModal" class="fixed inset-0 bg-primary-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-all duration-300">
    <div class="relative top-20 mx-auto p-10 border border-white/20 w-full max-w-md shadow-2xl rounded-3xl bg-white animate-fade-in-up">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-medium text-gray-900">User Details</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="userDetails">
            <!-- User details will be loaded here -->
        </div>
    </div>
</div>

<!-- Custom Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 bg-primary-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-all duration-300">
    <div class="relative top-1/2 -translate-y-1/2 mx-auto p-8 border border-white/20 w-full max-w-md shadow-2xl rounded-3xl bg-white animate-fade-in-up">
        <div class="text-center">
            <div id="confirmIcon" class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-6">
                <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-primary-950 mb-3 uppercase tracking-tight" id="confirmTitle">Confirm Action</h3>
            <p class="text-sm text-gray-600 mb-8 leading-relaxed" id="confirmMessage">Are you sure you want to proceed?</p>
            <div class="flex gap-3">
                <button onclick="closeConfirmModal()" class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-300">
                    Cancel
                </button>
                <button id="confirmButton" class="flex-1 px-6 py-3 bg-accent-600 text-white font-semibold rounded-xl hover:bg-accent-500 transition-all duration-300 shadow-lg shadow-accent-600/30">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Alert Modal -->
<div id="alertModal" class="fixed inset-0 bg-primary-900/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-all duration-300">
    <div class="relative top-1/2 -translate-y-1/2 mx-auto p-8 border border-white/20 w-full max-w-md shadow-2xl rounded-3xl bg-white animate-fade-in-up">
        <div class="text-center">
            <div id="alertIcon" class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-primary-950 mb-3 uppercase tracking-tight" id="alertTitle">Success</h3>
            <p class="text-sm text-gray-600 mb-8 leading-relaxed" id="alertMessage">Operation completed successfully!</p>
            <button onclick="closeAlertModal()" class="w-full px-6 py-3 bg-accent-600 text-white font-semibold rounded-xl hover:bg-accent-500 transition-all duration-300 shadow-lg shadow-accent-600/30">
                OK
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Custom confirm function
function customConfirm(message, title = 'Confirm Action') {
    return new Promise((resolve) => {
        const modal = document.getElementById('confirmModal');
        const titleEl = document.getElementById('confirmTitle');
        const messageEl = document.getElementById('confirmMessage');
        const confirmBtn = document.getElementById('confirmButton');
        
        titleEl.textContent = title;
        messageEl.textContent = message;
        modal.classList.remove('hidden');
        
        const handleConfirm = () => {
            modal.classList.add('hidden');
            confirmBtn.removeEventListener('click', handleConfirm);
            resolve(true);
        };
        
        confirmBtn.addEventListener('click', handleConfirm);
        
        window.closeConfirmModal = () => {
            modal.classList.add('hidden');
            confirmBtn.removeEventListener('click', handleConfirm);
            resolve(false);
        };
    });
}

// Custom alert function
function customAlert(message, title = 'Success', type = 'success') {
    return new Promise((resolve) => {
        const modal = document.getElementById('alertModal');
        const titleEl = document.getElementById('alertTitle');
        const messageEl = document.getElementById('alertMessage');
        const iconEl = document.getElementById('alertIcon');
        
        titleEl.textContent = title;
        messageEl.textContent = message;
        
        // Update icon based on type
        if (type === 'error') {
            iconEl.className = 'mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6';
            iconEl.innerHTML = '<svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>';
        } else {
            iconEl.className = 'mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6';
            iconEl.innerHTML = '<svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>';
        }
        
        modal.classList.remove('hidden');
        
        window.closeAlertModal = () => {
            modal.classList.add('hidden');
            resolve();
        };
    });
}


let currentChatSessionId = null;

function viewUser(userId) {
    const modal = document.getElementById('userModal');
    const content = document.getElementById('userDetails');
    
    // Show loading state
    content.innerHTML = `
        <div class="flex flex-col items-center justify-center py-12">
            <svg class="animate-spin h-10 w-10 text-accent-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-500 font-medium">Loading user details...</p>
        </div>
    `;
    modal.classList.remove('hidden');

    // Fetch user details
    fetch(`/admin/users/${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                const session = data.chat_session;
                const messages = data.messages || [];
                
                currentChatSessionId = session ? session.id : null;
                
                let messagesHtml = '';
                if (messages.length > 0) {
                    messagesHtml = messages.map(msg => `
                        <div class="flex ${!msg.is_user ? 'justify-end' : 'justify-start'}">
                            <div class="max-w-[85%] ${!msg.is_user ? 'bg-accent-600 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-none'} rounded-2xl px-4 py-2 shadow-sm">
                                <p class="text-sm">${msg.text}</p>
                                <p class="text-[10px] ${!msg.is_user ? 'text-accent-100' : 'text-gray-400'} mt-1 text-right">${msg.created_at_formatted}</p>
                            </div>
                        </div>
                    `).join('');
                } else {
                    messagesHtml = `
                        <div class="flex flex-col items-center justify-center h-full text-gray-400">
                            <p class="text-sm">No chat history found.</p>
                        </div>
                    `;
                }
                
                const avatarHtml = user.avatar 
                    ? `<img src="/storage/${user.avatar}" class="h-20 w-20 rounded-2xl object-cover shadow-md mx-auto mb-4">`
                    : `<div class="h-20 w-20 rounded-2xl bg-primary-100 text-primary-600 flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-md">${(user.name || 'U').charAt(0)}</div>`;

                content.innerHTML = `
                    <div class="space-y-8">
                        <!-- User Profile Header -->
                        <div class="text-center relative">
                            ${avatarHtml}
                            <h4 class="text-xl font-bold text-gray-900 font-heading">${user.name || 'Unknown User'}</h4>
                            <p class="text-sm text-gray-500 font-medium">${user.email || 'No email'}</p>
                            <div class="flex items-center justify-center gap-2 mt-3">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold ${user.role === 'admin' ? 'bg-primary-100 text-primary-700' : 'bg-gray-100 text-gray-700'}">
                                    ${(user.role || 'user').toUpperCase()}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold ${user.is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">
                                    ${user.is_active ? 'ACTIVE' : 'INACTIVE'}
                                </span>
                            </div>
                        </div>

                        <!-- Chat Section -->
                        <div class="bg-gray-50 rounded-2xl p-1 border border-gray-100">
                            <div class="px-4 py-3 border-b border-gray-200/50 flex items-center justify-between">
                                <h5 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                    Review Chat History
                                </h5>
                                ${session ? `<span class="text-[10px] text-gray-400">Session ID: ${session.id.substring(0, 8)}...</span>` : ''}
                            </div>
                            
                            <div id="modalChatHistory" class="p-4 h-64 overflow-y-auto space-y-3 custom-scrollbar">
                                ${messagesHtml}
                            </div>
                            
                            ${session ? `
                            <div class="p-3 bg-white border-t border-gray-100 rounded-b-xl">
                                <form id="adminReplyForm" onsubmit="sendAdminReply(event)" class="flex gap-2">
                                    <input type="text" id="replyMessage" class="flex-1 rounded-xl border-gray-200 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm py-2.5" placeholder="Type a reply..." required>
                                    <button type="submit" class="px-4 py-2 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition-colors font-medium text-sm shadow-lg shadow-primary-900/10 flex items-center gap-2">
                                        <span>Send</span>
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                                    </button>
                                </form>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `;
                
                // Scroll to bottom of chat
                const chatContainer = document.getElementById('modalChatHistory');
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
                
            } else {
                content.innerHTML = `
                    <div class="text-center py-8">
                        <div class="text-red-500 mb-2">
                            <svg class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-gray-800 font-semibold">Failed to load user details</p>
                        <p class="text-gray-500 text-sm mt-1">${data.message}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching user details:', error);
            content.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-500 font-medium">Error loading details</p>
                </div>
            `;
        });
}

function sendAdminReply(event) {
    event.preventDefault();
    
    if (!currentChatSessionId) return;
    
    const input = document.getElementById('replyMessage');
    const message = input.value.trim();
    const button = event.target.querySelector('button');
    const originalBtnContent = button.innerHTML;
    
    if (!message) return;
    
    // Disable button to prevent double submit
    button.disabled = true;
    button.innerHTML = '<svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    fetch(`/admin/chat/sessions/${currentChatSessionId}/messages`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: message })
    })
    .then(response => response.json())
    .then(data => {
        button.disabled = false;
        button.innerHTML = originalBtnContent;
        
        if (data.success) {
            input.value = '';
            
            // Append message to chat
            const chatContainer = document.getElementById('modalChatHistory');
            const newMsgHtml = `
                <div class="flex justify-end animate-fade-in-up">
                    <div class="max-w-[85%] bg-accent-600 text-white rounded-2xl rounded-br-none px-4 py-2 shadow-sm">
                        <p class="text-sm">${message}</p>
                        <p class="text-[10px] text-accent-100 mt-1 text-right">Just now</p>
                    </div>
                </div>
            `;
            chatContainer.insertAdjacentHTML('beforeend', newMsgHtml);
            chatContainer.scrollTop = chatContainer.scrollHeight;
            
        } else {
            customAlert(data.error || 'Failed to send message', 'Error', 'error');
        }
    })
    .catch(error => {
        button.disabled = false;
        button.innerHTML = originalBtnContent;
        customAlert('Network error occurred', 'Error', 'error');
    });
}

function closeModal() {
    document.getElementById('userModal').classList.add('hidden');
}

async function toggleUserStatus(userId, newStatus) {
    const action = newStatus === 'true' ? 'activate' : 'deactivate';
    
    const confirmed = await customConfirm(
        `Are you sure you want to ${action} this user? This will ${action === 'activate' ? 'restore' : 'revoke'} their access to the platform.`,
        `${action.charAt(0).toUpperCase() + action.slice(1)} User`
    );
    
    if (confirmed) {
        // Show loading state
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        
        // Make AJAX request
        fetch(`/admin/users/${userId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(async data => {
            if (data.success) {
                // Show success message
                await customAlert(`User ${action}d successfully!`, 'Success', 'success');
                // Reload page to reflect changes
                location.reload();
            } else {
                await customAlert('Error: ' + data.message, 'Error', 'error');
                button.disabled = false;
                button.innerHTML = originalContent;
            }
        })
        .catch(async error => {
            console.error('Error:', error);
            await customAlert('An error occurred while updating user status', 'Error', 'error');
            button.disabled = false;
            button.innerHTML = originalContent;
        });
    }
}
</script>
@endpush
@endsection
