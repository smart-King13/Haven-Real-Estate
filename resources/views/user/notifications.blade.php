@extends('layouts.user')

@section('title', 'Notifications - Haven')
@section('page-title', 'Notifications')

@section('content')
    <!-- Premium Welcome Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 sm:gap-6 lg:gap-8">
                <div class="space-y-2 sm:space-y-3">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white uppercase tracking-tighter">
                        Notifications
                    </h1>
                    <p class="text-sm sm:text-base text-primary-100/80 font-light">
                        Stay updated with the latest news and updates
                    </p>
                </div>
                @if($unreadCount > 0)
                <div>
                    <form action="{{ route('user.notifications.read-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 sm:px-6 py-2 sm:py-3 bg-accent-600 hover:bg-accent-500 text-white text-sm font-bold rounded-xl transition-all">
                            Mark All as Read
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="mt-6 sm:mt-8">
        @if($notifications->count() > 0)
        <div class="space-y-4">
            @foreach($notifications as $notification)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow
                {{ !$notification->is_read ? 'ring-2 ring-accent-500/20' : '' }}">
                <div class="p-4 sm:p-6">
                    <div class="flex items-start gap-4">
                        <!-- Icon -->
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center shrink-0
                            @if($notification->type === 'success') bg-green-100
                            @elseif($notification->type === 'warning') bg-yellow-100
                            @elseif($notification->type === 'danger') bg-red-100
                            @else bg-blue-100
                            @endif">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6
                                @if($notification->type === 'success') text-green-600
                                @elseif($notification->type === 'warning') text-yellow-600
                                @elseif($notification->type === 'danger') text-red-600
                                @else text-blue-600
                                @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($notification->type === 'success')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                @elseif($notification->type === 'warning')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                @elseif($notification->type === 'danger')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @endif
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900">{{ $notification->title }}</h3>
                                @if(!$notification->is_read)
                                <span class="px-2 py-1 bg-accent-100 text-accent-700 text-xs font-medium rounded-full shrink-0">New</span>
                                @endif
                            </div>
                            <p class="text-sm sm:text-base text-gray-600 mb-3">{{ $notification->message }}</p>
                            
                            <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                                <span class="text-xs sm:text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                
                                @if($notification->link)
                                <a href="{{ $notification->link }}" target="_blank" class="text-xs sm:text-sm text-accent-600 hover:text-accent-700 font-medium">
                                    View Details →
                                </a>
                                @endif

                                @if(!$notification->is_read)
                                <button onclick="markAsRead({{ $notification->id }})" class="text-xs sm:text-sm text-gray-500 hover:text-gray-700 font-medium">
                                    Mark as Read
                                </button>
                                @endif

                                <form action="{{ route('user.notifications.destroy', $notification->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this notification?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs sm:text-sm text-red-600 hover:text-red-700 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2">No Notifications</h3>
            <p class="text-sm sm:text-base text-gray-600">You're all caught up! Check back later for updates.</p>
        </div>
        @endif
    </div>

    <script>
        function markAsRead(notificationId) {
            fetch(`/dashboard/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    </script>
@endsection
