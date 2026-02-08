@extends('layouts.admin')

@section('title', 'Create Campaign - Haven Admin')
@section('page-title', 'Create Newsletter Campaign')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <form action="{{ route('admin.newsletter.store-campaign') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Campaign Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Email Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Email Content</label>
                    <textarea name="content" id="content" rows="12" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">You can use HTML for formatting</p>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="px-6 py-3 bg-accent-600 text-white font-semibold rounded-xl hover:bg-accent-700 transition-colors">
                        Create Campaign
                    </button>
                    <a href="{{ route('admin.newsletter.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
