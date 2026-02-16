@extends('layouts.app')

@php
    $hideNavbar = true;
    
    // Convert images array to objects
    if (isset($property->images) && is_array($property->images)) {
        $property->images = array_map(function($img) {
            return is_array($img) ? (object)$img : $img;
        }, $property->images);
    }
@endphp

@section('title', $property->title . ' - Haven')
@section('meta_description', Str::limit($property->description, 160))

@section('content')
<!-- Property Hero: Immersive Cinematic Reveal -->
<div class="relative min-h-[70vh] flex items-end overflow-hidden bg-primary-950">
    <!-- Background: Main Property Image -->
    <div class="absolute inset-0 z-0 cursor-pointer" onclick="openPropertyModal()">
        @if(count($property->images ?? []) > 0)
            <img src="{{ property_image_url($property->images[0]->image_path) }}" 
                 alt="{{ $property->title }}" 
                 class="w-full h-full object-cover opacity-60 transform scale-105 animate-slow-zoom hover:opacity-70 transition-opacity">
        @else
            <div class="w-full h-full bg-primary-900 opacity-60"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-950/40 to-transparent"></div>
        
        <!-- Click to View Indicator -->
        <div class="absolute top-6 right-6 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-4 py-2 flex items-center gap-2 text-white text-sm font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Click to view
        </div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 w-full max-w-[1600px] mx-auto px-6 lg:px-12 pb-24">
        <!-- Breadcrumb Glassmorphic -->
        <nav class="inline-flex px-4 py-2 rounded-full bg-white/5 backdrop-blur-md border border-white/10 mb-8 animate-reveal" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 md:space-x-4">
                <li>
                    <a href="{{ route('home') }}" class="text-[10px] font-black uppercase tracking-widest text-white/60 hover:text-white transition-colors">Home</a>
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-white/20 text-[10px]">/</span>
                    <a href="{{ route('properties.index') }}" class="text-[10px] font-black uppercase tracking-widest text-white/60 hover:text-white transition-colors">Properties</a>
                </li>
            </ol>
        </nav>

        <div class="max-w-4xl">
            <div class="flex items-center gap-4 animate-reveal mb-6">
                <span class="inline-flex items-center px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-accent-600 text-white shadow-xl shadow-accent-600/20">
                    {{ ucfirst($property->type) }}
                </span>
                <span class="inline-flex items-center px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-white/10 backdrop-blur-md text-white border border-white/10">
                    Category: {{ is_object($property->category) ? $property->category->name : ($property->category['name'] ?? 'N/A') }}
                </span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white leading-[0.9] tracking-tighter animate-reveal [animation-delay:0.2s] mb-6">
                {{ $property->title }}
            </h1>
            <div class="flex items-center gap-6 animate-reveal [animation-delay:0.3s]">
                <p class="text-xl text-white/60 font-medium flex items-center">
                    <svg class="h-5 w-5 mr-2 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                    {{ $property->location }}
                </p>
                <div class="w-12 h-[1px] bg-white/20"></div>
                <div class="text-3xl font-black text-accent-500 font-heading tracking-tight">{{ format_naira($property->price) }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="relative z-20 -mt-12 pb-24">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">
            <!-- Left Column: Media & Description -->
            <div class="lg:col-span-2 space-y-12">

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                    @if($property->bedrooms)
                    <div class="text-center p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-accent-200 transition-colors">
                        <svg class="h-8 w-8 mx-auto text-accent-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                        </svg>
                        <div class="text-lg font-bold text-gray-900 font-heading">{{ $property->bedrooms }}</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Bedrooms</div>
                    </div>
                    @endif

                    @if($property->bathrooms)
                    <div class="text-center p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-accent-200 transition-colors">
                        <svg class="h-8 w-8 mx-auto text-accent-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                        <div class="text-lg font-bold text-gray-900 font-heading">{{ $property->bathrooms }}</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Bathrooms</div>
                    </div>
                    @endif

                    @if($property->area)
                    <div class="text-center p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-accent-200 transition-colors">
                        <svg class="h-8 w-8 mx-auto text-accent-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                        <div class="text-lg font-bold text-gray-900 font-heading">{{ number_format($property->area) }}</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Sq Ft</div>
                    </div>
                    @endif

                    @if($property->property_type)
                    <div class="text-center p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-accent-200 transition-colors">
                        <svg class="h-8 w-8 mx-auto text-accent-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <div class="text-lg font-bold text-gray-900 font-heading">{{ ucfirst($property->property_type) }}</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Type</div>
                    </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $property->description }}</p>
                </div>

                <!-- Features -->
                @if($property->features && count($property->features) > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Features & Amenities</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($property->features as $feature)
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">{{ ucfirst($feature) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Contact Information Section -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 font-heading">Contact Information</h3>
                    
                    <!-- Email Display -->
                    <div class="flex items-center p-4 rounded-2xl bg-accent-50 border border-accent-100 mb-6">
                        <div class="w-12 h-12 rounded-full bg-accent-600 flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="text-gray-900 font-medium">{{ is_object($property->owner) ? ($property->owner->email ?? 'admin@haven.com') : ($property->owner['email'] ?? 'admin@haven.com') }}</span>
                    </div>

                    <!-- Primary Action: Purchase/Rent Now -->
                    @if($property->status === 'available')
                        @auth
                        <a href="{{ route('properties.checkout', $property->slug ?? $property->id) }}" 
                           class="w-full h-14 bg-accent-600 text-white font-bold text-sm uppercase tracking-wide rounded-2xl hover:bg-accent-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center group mb-4">
                            <span>{{ $property->type === 'sale' ? 'Purchase Now' : 'Rent Now' }}</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        @else
                        <a href="{{ route('login', ['redirect' => route('properties.checkout', $property->slug ?? $property->id)]) }}" 
                           class="w-full h-14 bg-accent-600 text-white font-bold text-sm uppercase tracking-wide rounded-2xl hover:bg-accent-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center group mb-4">
                            <span>{{ $property->type === 'sale' ? 'Purchase Now' : 'Rent Now' }}</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        @endauth
                    @else
                        <div class="w-full h-14 bg-gray-200 text-gray-500 font-bold text-sm uppercase tracking-wide rounded-2xl flex items-center justify-center cursor-not-allowed mb-4">
                            <span>{{ ucfirst($property->status) }}</span>
                        </div>
                    @endif

                    <!-- Secondary Actions -->
                    <div class="grid grid-cols-2 gap-4">
                        <button class="h-14 bg-accent-600 text-white font-bold text-sm rounded-2xl hover:bg-accent-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Contact
                        </button>
                        
                        @auth
                        <button onclick="toggleSave('{{ $property->slug }}')" 
                                class="h-14 bg-accent-600 text-white font-bold text-sm rounded-2xl hover:bg-accent-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center"
                                id="save-btn-text-{{ $property->slug }}">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            {{ $isSaved ? 'Saved' : 'Save' }}
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="h-14 bg-accent-600 text-white font-bold text-sm rounded-2xl hover:bg-accent-700 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Save
                        </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Property Details -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 font-heading">Property Details</h3>
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6 font-heading">Property Details</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500">Category</span>
                        <span class="font-bold text-gray-900">{{ is_object($property->category) ? $property->category->name : ($property->category['name'] ?? 'N/A') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500">Listed</span>
                        <span class="font-bold text-gray-900">{{ date('M d, Y', strtotime($property->created_at)) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-500">Property Code</span>
                        <span class="font-bold text-gray-900">#{{ strtoupper($property->slug) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Similar Properties -->
    @if(isset($similarProperties) && count($similarProperties) > 0)
    <div class="mt-16 lg:mt-24 px-6 lg:px-12">
        <div class="max-w-[1600px] mx-auto">
            <!-- Section Header -->
            <div class="mb-12 text-center">
                <div class="inline-flex items-center gap-4 mb-6">
                    <div class="w-8 h-[2px] bg-accent-500"></div>
                    <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px]">You Might Also Like</span>
                    <div class="w-8 h-[2px] bg-accent-500"></div>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-primary-950 leading-[1.1] tracking-tighter">
                    Similar <span class="text-accent-500 italic">Properties.</span>
                </h2>
            </div>

            <!-- Properties Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
                @foreach($similarProperties as $similar)
                <div class="group bg-white rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200">
                    <!-- Image -->
                    <div class="relative aspect-[4/3] overflow-hidden">
                        @if($similar->primaryImage)
                            <img src="{{ property_image_url($similar->primaryImage->image_path) }}" 
                                 alt="{{ $similar->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Property Type Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="px-2 py-1 bg-accent-600 text-white text-xs font-semibold rounded">
                                {{ ucfirst($similar->type) }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4">
                        <!-- Price -->
                        <div class="mb-2">
                            <div class="text-lg sm:text-xl font-bold text-gray-900">
                                {{ format_naira($similar->price) }}
                                @if($similar->type === 'rent')
                                    <span class="text-sm font-normal text-gray-500">/mo</span>
                                @endif
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="text-sm sm:text-base font-semibold text-gray-900 mb-2 truncate">
                            <a href="{{ route('properties.show', $similar->slug) }}" class="hover:text-accent-600 transition-colors">
                                {{ Str::limit($similar->title, 30) }}
                            </a>
                        </h3>

                        <!-- Location -->
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 truncate">{{ Str::limit($similar->location, 25) }}</p>

                        <!-- Property Details -->
                        @if($similar->bedrooms || $similar->bathrooms || $similar->area)
                        <div class="flex items-center text-xs text-gray-600 space-x-3 mb-3">
                            @if($similar->bedrooms)
                            <span class="flex items-center">
                                <strong class="text-gray-900">{{ $similar->bedrooms }}</strong>
                                <span class="ml-1">bd</span>
                            </span>
                            @endif
                            @if($similar->bathrooms)
                            <span class="flex items-center">
                                <strong class="text-gray-900">{{ $similar->bathrooms }}</strong>
                                <span class="ml-1">ba</span>
                            </span>
                            @endif
                            @if($similar->area)
                            <span class="flex items-center">
                                <strong class="text-gray-900">{{ number_format($similar->area) }}</strong>
                                <span class="ml-1">sqft</span>
                            </span>
                            @endif
                        </div>
                        @endif

                        <!-- View Details Button -->
                        <div class="pt-2">
                            <a href="{{ route('properties.show', $similar->slug) }}" 
                               class="text-accent-600 hover:text-accent-700 text-sm font-medium">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

@auth
@push('scripts')
<script>
function toggleSave(propertySlug) {
    fetch(`/properties/${propertySlug}/toggle-save`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const button = document.getElementById(`save-btn-${propertySlug}`);
            const textButton = document.getElementById(`save-btn-text-${propertySlug}`);
            const icon = button.querySelector('svg');
            
            if (data.saved) {
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-red-500');
                icon.setAttribute('fill', 'currentColor');
                if (textButton) textButton.textContent = 'Remove from Favorites';
            } else {
                icon.classList.remove('text-red-500');
                icon.classList.add('text-gray-400');
                icon.setAttribute('fill', 'none');
                if (textButton) textButton.textContent = 'Save Property';
            }
            
            showToast(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.');
    });
}

function changeMainImage(src) {
    document.querySelector('#main-image img').src = src;
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endpush
@endauth
@endsection
