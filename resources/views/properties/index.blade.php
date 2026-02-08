@extends('layouts.app')

@section('title', 'Browse Properties - Haven | Luxury Real Estate & Rentals')
@section('meta_description', 'Explore our curated collection of luxury properties, homes for sale, and premium rentals. Filter by location, price, and property type to find your perfect match.')

@section('content')
<!-- Search Overlay for Mobile -->
<div x-data="{ open: false }" class="lg:hidden">
    <!-- Filter Button -->
    <div class="fixed bottom-6 right-6 z-40">
        <button @click="open = true" class="bg-accent-600 text-white p-4 rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-transform border border-white/20">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
        </button>
    </div>

    <!-- Mobile Filter Drawer -->
    <div x-show="open" class="fixed inset-0 z-50 flex justify-end" style="display: none;">
        <div class="fixed inset-0 bg-primary-950/50 backdrop-blur-sm" @click="open = false" x-transition.opacity></div>
        <div class="relative w-full max-w-sm bg-white h-full overflow-y-auto p-8 shadow-2xl" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full">
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
                <h3 class="text-xs font-black uppercase tracking-[0.5em] text-primary-950">Refine Collection</h3>
                <button @click="open = false" class="text-gray-400 hover:text-primary-950 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="space-y-8">
                @include('properties.partials.filter-form')
            </div>
        </div>
    </div>
</div>

<!-- Properties Hero: Immersive Architectural Entry -->
<div class="relative min-h-screen flex items-center overflow-hidden bg-primary-950">
    <!-- Background: Full-Scale with Slow Zoom -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=2070&q=80" 
             alt="Luxury Property Collection" 
             class="w-full h-full object-cover opacity-60 transform scale-105 animate-slow-zoom">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950/95 via-primary-950/60 to-primary-950/95"></div>
    </div>

    <!-- Main Content Grid -->
    <div class="relative z-10 w-full max-w-[1600px] mx-auto px-6 lg:px-12 pt-32 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Side: Portfolio Introduction -->
            <div class="lg:col-span-8 space-y-12">
                <!-- Signature Badge -->
                <div class="inline-flex items-center gap-4 animate-reveal">
                    <div class="w-12 h-[2px] bg-accent-500"></div>
                    <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">The Collection — Curated Excellence</span>
                </div>

                <!-- Main Headline -->
                <h1 class="text-6xl md:text-8xl lg:text-9xl font-black text-white leading-[0.9] tracking-tighter animate-reveal [animation-delay:0.2s]">
                    Explore the <br>
                    <span class="text-accent-500">Extraordinary.</span>
                </h1>

                <!-- Description & CTA -->
                <div class="max-w-2xl space-y-10 animate-reveal [animation-delay:0.4s]">
                    <p class="text-xl md:text-2xl text-gray-300 font-light leading-relaxed border-l-4 border-accent-500/50 pl-8">
                        A curated gallery of our most prestigious residences, from urban sanctuaries to sprawling legacy estates. Discover the Haven standard of living.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-8">
                        <a href="#filters" class="px-12 py-5 bg-accent-600 text-white font-black uppercase tracking-[0.2em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-sm">
                            Refine Search
                        </a>
                        <a href="{{ route('home') }}" class="group flex items-center gap-4 text-white hover:text-accent-400 transition-all duration-300">
                            <span class="text-[11px] font-bold uppercase tracking-[0.3em] border-b border-white/20 pb-1 group-hover:border-accent-500 transition-all">Return Home</span>
                            <div class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center group-hover:bg-accent-500 group-hover:border-accent-500 transition-all">
                                <svg class="w-3 h-3 translate-x-[-1px] group-hover:translate-x-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Portfolio Stats -->
            <div class="hidden lg:block lg:col-span-4 self-end animate-reveal [animation-delay:0.6s]">
                <div class="glass-premium p-10 rounded-[50px] exceptional-shadow text-white space-y-8 max-w-[340px] ml-auto">
                    <div class="flex justify-between items-start">
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-60">Live Collection</span>
                        <div class="flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full bg-accent-500 animate-pulse"></div>
                             <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-accent-400">Updated Daily</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-5xl font-black leading-none mb-3">{{ count($properties) }}<span class="text-accent-500">+</span></div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] opacity-40 leading-relaxed">Premium Properties <br>Available Now</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div class="relative z-20 -mt-16 pb-40">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <!-- Integrated Search: White Editorial Architectural -->
        <div id="filters" class="relative z-30 mb-24 animate-reveal [animation-delay:0.8s]">
            <div class="max-w-[1300px] mx-auto">
                @include('properties.partials.filter-form')
            </div>
        </div>

        <!-- Results Header -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between mb-16 gap-8 animate-reveal">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-4">
                    <div class="w-8 h-[2px] bg-accent-500"></div>
                    <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px]">Current Portfolio</span>
                </div>
                <h2 class="text-4xl md:text-6xl font-black text-primary-950 leading-[1.1] tracking-tighter">
                    Available <span class="text-accent-500 italic">Properties.</span>
                </h2>
            </div>
            <div class="text-right space-y-2">
                <div class="text-accent-600 font-black text-5xl md:text-6xl leading-none">{{ count($properties) }}</div>
                <div class="text-[10px] font-black uppercase tracking-[0.3em] text-primary-950/60">Exceptional Listings</div>
            </div>
        </div>

        @if(count($properties) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($properties as $property)
                @php
                    // Convert array to object for consistent access
                    $property = is_array($property) ? (object)$property : $property;
                    $property->images = $property->images ?? [];
                    $property->primaryImage = $property->primaryImage ?? null;
                    $property->category = is_array($property->category ?? null) ? (object)$property->category : ($property->category ?? (object)['name' => 'Uncategorized']);
                    $property->is_featured = $property->is_featured ?? false;
                    $property->bedrooms = $property->bedrooms ?? 0;
                    $property->bathrooms = $property->bathrooms ?? 0;
                    $property->area = $property->area ?? 0;
                    $property->type = $property->type ?? 'sale';
                    $property->slug = $property->slug ?? '';
                    $property->title = $property->title ?? 'Property';
                    $property->price = $property->price ?? 0;
                    $property->location = $property->location ?? 'Location not specified';
                @endphp
                <div class="group bg-white rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200">
                    <!-- Image Carousel -->
                    <div class="relative aspect-[4/3] overflow-hidden" 
                         @if(count($property->images ?? []) > 0)
                         x-data="imageCarousel({{ count($property->images) }})"
                         @endif>
                        @if(count($property->images ?? []) > 0)
                            <!-- Images -->
                            <div class="relative h-full">
                                @foreach($property->images as $index => $image)
                                <div class="absolute inset-0 transition-opacity duration-300" 
                                     x-show="currentSlide === {{ $index }}"
                                     x-transition:enter="transition-opacity duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition-opacity duration-300"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0">
                                    <img class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                         src="{{ asset('storage/' . (is_object($image) ? $image->image_path : $image['image_path'])) }}" 
                                         alt="{{ $property->title }} - Image {{ $index + 1 }}">
                                </div>
                                @endforeach
                            </div>

                            <!-- Navigation Arrows (only show if more than 1 image) -->
                            @if(count($property->images) > 1)
                            <div class="absolute inset-0 flex items-center justify-between px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <!-- Previous Button -->
                                <button @click="previousSlide()" 
                                        class="w-8 h-8 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-md transition-all duration-200 hover:scale-110">
                                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                
                                <!-- Next Button -->
                                <button @click="nextSlide()" 
                                        class="w-8 h-8 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-md transition-all duration-200 hover:scale-110">
                                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Dots Indicator -->
                            <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex space-x-1">
                                @foreach($property->images as $index => $image)
                                <button @click="goToSlide({{ $index }})" 
                                        class="w-2 h-2 rounded-full transition-all duration-200"
                                        :class="currentSlide === {{ $index }} ? 'bg-white' : 'bg-white/50 hover:bg-white/75'">
                                </button>
                                @endforeach
                            </div>
                            @endif
                        @else
                            <!-- Fallback to Primary Image or Placeholder -->
                            @php
                                $prop = is_array($property) ? (object)$property : $property;
                                $primaryImage = $prop->primaryImage ?? null;
                            @endphp
                            @if($primaryImage)
                            <div class="h-full">
                                @php
                                    $imgPath = is_object($primaryImage) ? $primaryImage->image_path : (is_array($primaryImage) ? $primaryImage['image_path'] : $primaryImage);
                                @endphp
                                <img class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                     src="{{ asset('storage/' . $imgPath) }}" 
                                     alt="{{ $prop->title }}">
                            </div>
                            @else
                            <!-- No Images Placeholder -->
                            <div class="flex items-center justify-center h-full bg-gray-100">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                        @endif
                        
                        <!-- Save Button -->
                        @if(session('supabase_user'))
                        <div class="absolute top-3 right-3">
                            <button onclick="toggleSave('{{ $property->slug }}')" 
                                    id="save-btn-{{ $property->slug }}"
                                    class="w-8 h-8 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-200">
                                <svg class="w-4 h-4 text-gray-600" 
                                     fill="none" 
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </div>
                        @endif

                        <!-- Featured Badge -->
                        @if($property->is_featured ?? false)
                        <div class="absolute top-3 left-3">
                            <span class="px-2 py-1 bg-accent-600 text-white text-xs font-semibold rounded">
                                Featured
                            </span>
                        </div>
                        @endif

                        <!-- Image Counter (like Zillow) -->
                        @if(count($property->images ?? []) > 1)
                        <div class="absolute top-3 left-1/2 transform -translate-x-1/2">
                            <div class="bg-black/50 text-white text-xs px-2 py-1 rounded-full">
                                <span x-text="currentSlide + 1"></span> / {{ count($property->images) }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-4">
                        <!-- Price -->
                        <div class="mb-2">
                            <div class="text-xl font-bold text-gray-900">
                                {{ format_naira($property->price) }}
                                @if($property->type === 'rent')
                                    <span class="text-sm font-normal text-gray-500">/mo</span>
                                @endif
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="flex items-center text-sm text-gray-600 mb-2 space-x-4">
                            <span class="flex items-center">
                                <strong class="text-gray-900">{{ $property->bedrooms }}</strong>
                                <span class="ml-1">bd</span>
                            </span>
                            <span class="flex items-center">
                                <strong class="text-gray-900">{{ $property->bathrooms }}</strong>
                                <span class="ml-1">ba</span>
                            </span>
                            <span class="flex items-center">
                                <strong class="text-gray-900">{{ number_format($property->area) }}</strong>
                                <span class="ml-1">sqft</span>
                            </span>
                        </div>

                        <!-- Address -->
                        <div class="text-sm text-gray-600 mb-2">
                            {{ $property->location }}
                        </div>

                        <!-- Property Type -->
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 uppercase font-medium">
                                {{ ucfirst($property->type ?? 'sale') }} • {{ $property->category->name ?? 'Uncategorized' }}
                            </span>
                            @if($property->slug)
                                <a href="{{ route('properties.show', $property->slug) }}" 
                                   class="text-accent-600 hover:text-accent-700 text-sm font-medium">
                                    View Details
                                </a>
                            @else
                                <span class="text-gray-400 text-sm font-medium">
                                    No Details
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(count($properties) > 12)
            <div class="mt-32 flex justify-center">
                <div class="bg-white rounded-[30px] shadow-2xl border border-gray-100 p-2">
                    {{-- Pagination removed for now - Supabase returns arrays not paginated collections --}}
                    <p class="text-sm text-gray-500 px-6 py-3">Showing {{ count($properties) }} properties</p>
                </div>
            </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-gray-50 rounded-[60px] p-32 md:p-48 text-center border-2 border-dashed border-gray-200 animate-reveal">
                <div class="space-y-8">
                    <div class="w-24 h-24 bg-primary-950/5 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-12 h-12 text-primary-950/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-3xl md:text-4xl font-black text-primary-950 uppercase tracking-tighter">No Properties Found</h3>
                        <p class="text-lg text-gray-600 font-light leading-relaxed max-w-md mx-auto">
                            Our current collection doesn't match these specific criteria. Try adjusting your search parameters.
                        </p>
                    </div>
                    <div class="pt-8">
                        <a href="{{ route('properties.index') }}" 
                           class="px-12 py-5 bg-accent-600 text-white font-black uppercase tracking-[0.3em] rounded-full hover:bg-accent-500 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-sm">
                            Reset Filters
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Image Carousel Component
function imageCarousel(totalImages) {
    return {
        currentSlide: 0,
        totalSlides: Math.max(totalImages || 1, 1),
        
        init() {
            console.log('Carousel initialized with', this.totalSlides, 'slides');
        },
        
        nextSlide() {
            if (this.totalSlides > 1) {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            }
        },
        
        previousSlide() {
            if (this.totalSlides > 1) {
                this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
            }
        },
        
        goToSlide(index) {
            if (this.totalSlides > 1 && index >= 0 && index < this.totalSlides) {
                this.currentSlide = index;
            }
        }
    }
}

// Property Save/Unsave functionality (only for authenticated users)
@auth
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
            const icon = button.querySelector('svg');
            
            if (data.saved) {
                icon.classList.remove('text-gray-600');
                icon.classList.add('text-red-500');
                icon.setAttribute('fill', 'currentColor');
            } else {
                icon.classList.remove('text-red-500');
                icon.classList.add('text-gray-600');
                icon.setAttribute('fill', 'none');
            }
            
            // Show toast message
            showToast(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.');
    });
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Slide in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Slide out and remove
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => toast.remove(), 300); 
    }, 1500);
}
@endauth
</script>
@endpush
@endsection
