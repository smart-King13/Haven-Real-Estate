@extends('layouts.admin')

@section('title', 'Newsletter Subscribers - Haven Admin')
@section('page-title', 'Newsletter Subscribers')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">All Subscribers ({{ count($subscribers) }})</h2>
        <a href="{{ route('admin.newsletter.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200">
            Back to Dashboard
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribed</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($subscribers as $subscriber)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ is_object($subscriber) ? $subscriber->email : $subscriber['email'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ is_object($subscriber) ? ($subscriber->name ?? 'N/A') : ($subscriber['name'] ?? 'N/A') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ (is_object($subscriber) ? $subscriber->status : $subscriber['status']) === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst(is_object($subscriber) ? $subscriber->status : $subscriber['status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ ucfirst(is_object($subscriber) ? ($subscriber->source ?? 'website') : ($subscriber['source'] ?? 'website')) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ date('M d, Y', strtotime(is_object($subscriber) ? $subscriber->created_at : $subscriber['created_at'])) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <form action="{{ route('admin.newsletter.delete-subscriber', is_object($subscriber) ? $subscriber->id : $subscriber['id']) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No subscribers yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
