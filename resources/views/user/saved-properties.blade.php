@extends('layouts.user')

@section('title', 'Saved Properties - Haven')
@section('page-title', 'Saved Properties')

@section('header')
    <h1 class="text-3xl font-bold text-gray-900">Saved Properties</h1>
    <p class="mt-2 text-sm text-gray-600">Your favorite properties collection</p>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(isset($properties) && count($properties) > 0)
        <div class="mb-6 flex justify-between items-center">
            <p class="text-gray-600">{{ count($properties) }} saved {{ count($properties) === 1 ? 'property' : 'properties' }}</p>
            <a href="{{ route('properties.index') }}" class="text-accent-600 hover:text-accent-500 font-medium">
                Browse More Properties
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($properties as $property)
            <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    @if($property->primaryImage)
                        <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $property->primaryImage->image_path) }}" alt="{{ $property->title }}">
                    @else
                        <div class="h-48 w-full bg-gray-300 flex items-center justify-center">
                            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-2 left-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent-100 text-accent-800">
                            {{ ucfirst($property->type) }}
                        </span>
                    </div>
                    <div class="absolute top-2 right-2">
                        <form method="POST" action="{{ route('user.saved-properties.remove', $property->id) }}" 
                              onsubmit="return confirm('Remove this property from your favorites?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-full bg-white shadow-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-accent-600">{{ isset($property->category) ? $property->category : 'Uncategorized' }}</p>
                        <p class="text-2xl font-bold text-gray-900">₦{{ number_format($property->price) }}</p>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        <a href="{{ route('properties.show', $property->slug) }}" class="hover:text-accent-600">
                            {{ $property->title }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $property->location }}</p>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        @if($property->bedrooms)
                            <span class="flex items-center mr-4">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                </svg>
                                {{ $property->bedrooms }} bed
                            </span>
                        @endif
                        @if($property->bathrooms)
                            <span class="flex items-center mr-4">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                                {{ $property->bathrooms }} bath
                            </span>
                        @endif
                        @if($property->area)
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                </svg>
                                {{ number_format($property->area) }} sqft
                            </span>
                        @endif
                    </div>

                    <div class="flex space-x-3">
                        <a href="{{ route('properties.show', $property->slug) }}" 
                           class="flex-1 bg-accent-600 border border-transparent rounded-md py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-accent-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                            View Details
                        </a>
                        <form method="POST" action="{{ route('user.saved-properties.remove', $property->id) }}" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Remove this property from your favorites?')"
                                    class="bg-gray-200 border border-transparent rounded-md py-2 px-4 inline-flex justify-center text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No saved properties yet</h3>
            <p class="mt-2 text-sm text-gray-500">
                Start browsing properties and save your favorites to see them here.
            </p>
            <div class="mt-6">
                <a href="{{ route('properties.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-accent-600 hover:bg-accent-500">
                    <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Browse Properties
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
