@extends('layouts.admin')

@section('title', 'Newsletter Management - Haven Admin')
@section('page-title', 'Newsletter Management')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Active Subscribers</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_subscribers'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Unsubscribed</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_unsubscribed'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Campaigns</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_campaigns'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex gap-4">
        <a href="{{ route('admin.newsletter.create-campaign') }}" class="px-6 py-3 bg-accent-600 text-white font-semibold rounded-xl hover:bg-accent-700 transition-colors">
            Create Campaign
        </a>
        <a href="{{ route('admin.newsletter.subscribers') }}" class="px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
            View All Subscribers
        </a>
    </div>

    <!-- Recent Subscribers -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Recent Subscribers</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribed</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentSubscribers as $subscriber)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ is_object($subscriber) ? $subscriber->email : $subscriber['email'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ is_object($subscriber) ? ($subscriber->name ?? 'N/A') : ($subscriber['name'] ?? 'N/A') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ (is_object($subscriber) ? $subscriber->status : $subscriber['status']) === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst(is_object($subscriber) ? $subscriber->status : $subscriber['status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ date('M d, Y', strtotime(is_object($subscriber) ? $subscriber->created_at : $subscriber['created_at'])) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">No subscribers yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Campaigns -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Recent Campaigns</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipients</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($campaigns as $campaign)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ is_object($campaign) ? $campaign->title : $campaign['title'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ is_object($campaign) ? $campaign->subject : $campaign['subject'] }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ (is_object($campaign) ? $campaign->status : $campaign['status']) === 'sent' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst(is_object($campaign) ? $campaign->status : $campaign['status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ is_object($campaign) ? ($campaign->total_recipients ?? 0) : ($campaign['total_recipients'] ?? 0) }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if((is_object($campaign) ? $campaign->status : $campaign['status']) === 'draft')
                            <form action="{{ route('admin.newsletter.send-campaign', is_object($campaign) ? $campaign->id : $campaign['id']) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-accent-600 hover:text-accent-700 font-medium">Send Now</button>
                            </form>
                            @else
                            <span class="text-gray-400">Sent</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No campaigns yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
