@extends('layouts.admin')

@section('title', 'Send Notification - Haven')
@section('page-title', 'Send Notification')

@section('content')
    <!-- Premium Header Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-8 py-16">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.notifications.index') }}" class="text-white/60 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-3xl font-semibold text-white font-heading tracking-tight">
                        Send New Notification
                    </h1>
                    <p class="text-lg text-primary-100/80 font-normal mt-2">
                        Create and send notifications to your users
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Form -->
    <div class="max-w-4xl">
        <form action="{{ route('admin.notifications.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @csrf

            <div class="p-8 space-y-6">
                <!-- Notification Type -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Notification Type</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="notification-types">
                        <label class="relative cursor-pointer notification-type-option" data-type="info">
                            <input type="radio" name="type" value="info" checked class="hidden">
                            <div class="p-4 border-2 border-blue-500 bg-blue-50 rounded-xl transition-all hover:shadow-md">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900">Info</p>
                            </div>
                        </label>

                        <label class="relative cursor-pointer notification-type-option" data-type="success">
                            <input type="radio" name="type" value="success" class="hidden">
                            <div class="p-4 border-2 border-gray-200 rounded-xl transition-all hover:shadow-md">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900">Success</p>
                            </div>
                        </label>

                        <label class="relative cursor-pointer notification-type-option" data-type="warning">
                            <input type="radio" name="type" value="warning" class="hidden">
                            <div class="p-4 border-2 border-gray-200 rounded-xl transition-all hover:shadow-md">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900">Warning</p>
                            </div>
                        </label>

                        <label class="relative cursor-pointer notification-type-option" data-type="danger">
                            <input type="radio" name="type" value="danger" class="hidden">
                            <div class="p-4 border-2 border-gray-200 rounded-xl transition-all hover:shadow-md">
                                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900">Danger</p>
                            </div>
                        </label>
                    </div>
                    @error('type')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Notification Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all"
                           placeholder="Enter notification title">
                    @error('title')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-bold text-gray-700 mb-2">Message *</label>
                    <textarea name="message" id="message" rows="5" required
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all resize-none"
                              placeholder="Enter your notification message">{{ old('message') }}</textarea>
                    @error('message')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link (Optional) -->
                <div>
                    <label for="link" class="block text-sm font-bold text-gray-700 mb-2">Link (Optional)</label>
                    <input type="url" name="link" id="link" value="{{ old('link') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all"
                           placeholder="https://example.com">
                    <p class="text-xs text-gray-500 mt-1">Add a link for users to click (optional)</p>
                    @error('link')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Send To -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Send To *</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-all">
                            <input type="radio" name="send_to" value="all" checked class="w-4 h-4 text-accent-600 focus:ring-accent-500" onchange="toggleUserSelect()">
                            <div class="ml-3">
                                <p class="text-sm font-bold text-gray-900">All Users</p>
                                <p class="text-xs text-gray-500">Send notification to all registered users</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-all">
                            <input type="radio" name="send_to" value="specific" class="w-4 h-4 text-accent-600 focus:ring-accent-500" onchange="toggleUserSelect()">
                            <div class="ml-3">
                                <p class="text-sm font-bold text-gray-900">Specific Users</p>
                                <p class="text-xs text-gray-500">Select individual users to notify</p>
                            </div>
                        </label>
                    </div>
                    @error('send_to')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User Selection (Hidden by default) -->
                <div id="user-select-container" class="hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Select Users *</label>
                    <div class="border border-gray-200 rounded-xl p-4 max-h-64 overflow-y-auto space-y-2">
                        @foreach($users as $user)
                        <?php 
                            $u = is_array($user) ? (object)$user : $user;
                        ?>
                        <label class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors">
                            <input type="checkbox" name="user_ids[]" value="{{ $u->id }}" class="w-4 h-4 text-accent-600 focus:ring-accent-500 rounded">
                            <div class="ml-3 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-accent-600 flex items-center justify-center text-xs font-bold text-white overflow-hidden">
                                    @if(isset($u->avatar) && $u->avatar)
                                        <img src="{{ asset('storage/' . $u->avatar) }}" alt="{{ $u->name ?? 'User' }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($u->name ?? 'U', 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $u->name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-gray-500">{{ $u->email ?? 'No email' }}</p>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('user_ids')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ route('admin.notifications.index') }}" class="px-6 py-3 text-gray-700 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-accent-600 hover:bg-accent-500 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Send Notification
                </button>
            </div>
        </form>
    </div>

    <script>
        // Handle notification type selection
        document.querySelectorAll('.notification-type-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected state from all options
                document.querySelectorAll('.notification-type-option').forEach(opt => {
                    const div = opt.querySelector('div');
                    div.classList.remove('border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50', 'border-yellow-500', 'bg-yellow-50', 'border-red-500', 'bg-red-50');
                    div.classList.add('border-gray-200');
                    opt.querySelector('input').checked = false;
                });
                
                // Add selected state to clicked option
                const type = this.dataset.type;
                const div = this.querySelector('div');
                div.classList.remove('border-gray-200');
                
                if (type === 'info') {
                    div.classList.add('border-blue-500', 'bg-blue-50');
                } else if (type === 'success') {
                    div.classList.add('border-green-500', 'bg-green-50');
                } else if (type === 'warning') {
                    div.classList.add('border-yellow-500', 'bg-yellow-50');
                } else if (type === 'danger') {
                    div.classList.add('border-red-500', 'bg-red-50');
                }
                
                this.querySelector('input').checked = true;
            });
        });

        // Handle user selection toggle
        function toggleUserSelect() {
            const sendTo = document.querySelector('input[name="send_to"]:checked').value;
            const userSelectContainer = document.getElementById('user-select-container');
            
            if (sendTo === 'specific') {
                userSelectContainer.classList.remove('hidden');
            } else {
                userSelectContainer.classList.add('hidden');
            }
        }
    </script>
@endsection
