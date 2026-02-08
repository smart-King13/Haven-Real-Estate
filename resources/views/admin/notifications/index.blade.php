@extends('layouts.admin')

@section('title', 'Notifications Management - Haven')
@section('page-title', 'Notifications')

@section('content')
    <!-- Premium Header Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-8 py-16">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1 space-y-2">
                    <h1 class="text-3xl font-semibold text-white font-heading tracking-tight underline decoration-indigo-500/30 decoration-8 underline-offset-4">
                        Notifications Management
                    </h1>
                    <p class="text-lg text-primary-100/80 font-normal">
                        Send notifications and announcements to your users
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.notifications.create') }}" class="inline-flex items-center px-6 py-3 bg-accent-600 hover:bg-accent-500 text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Send Notification
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Notifications</p>
                    <p class="text-3xl font-bold text-primary-900 mt-2">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Unread</p>
                    <p class="text-3xl font-bold text-accent-600 mt-2">{{ $stats['unread'] }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sent Today</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['today'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-black text-primary-950 uppercase tracking-wide">All Notifications</h2>
            @if(count($notifications) > 0)
            <form action="{{ route('admin.notifications.destroy-all') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete all notifications?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">
                    Delete All
                </button>
            </form>
            @endif
        </div>

        @if(count($notifications) > 0)
        <div class="divide-y divide-gray-100">
            @foreach($notifications as $notification)
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-4 flex-1">
                        <!-- Icon -->
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                            @if($notification->type === 'success') bg-green-100
                            @elseif($notification->type === 'warning') bg-yellow-100
                            @elseif($notification->type === 'danger') bg-red-100
                            @else bg-blue-100
                            @endif">
                            <svg class="w-5 h-5
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
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-sm font-bold text-gray-900">{{ $notification->title }}</h3>
                                @if($notification->send_to_all)
                                <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-medium rounded">All Users</span>
                                @endif
                                @if(!$notification->is_read)
                                <span class="px-2 py-0.5 bg-accent-100 text-accent-700 text-xs font-medium rounded">Unread</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $notification->message }}</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span>To: {{ $notification->user ? $notification->user->name : 'All Users' }}</span>
                                <span>•</span>
                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                                @if($notification->link)
                                <span>•</span>
                                <a href="{{ $notification->link }}" target="_blank" class="text-accent-600 hover:text-accent-700">View Link</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination removed - Supabase returns arrays not paginated collections --}}
        @else
        <div class="p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Notifications Yet</h3>
            <p class="text-gray-600 mb-6">Start sending notifications to your users</p>
            <a href="{{ route('admin.notifications.create') }}" class="inline-flex items-center px-6 py-3 bg-accent-600 hover:bg-accent-500 text-white font-bold rounded-xl transition-all">
                Send First Notification
            </a>
        </div>
        @endif
    </div>
@endsection
