@extends('layouts.app')

@section('title', 'Haven - Find Your Perfect Home | Premium Real Estate')
@section('meta_description', 'Discover amazing properties for rent and sale with Haven. Your dream home is just a click away with our verified listings and instant alerts.')

@section('content')
<!-- Hero Section: Exceptional Asymmetric Layout -->
<div class="relative min-h-screen flex items-center overflow-hidden bg-primary-950">
    <!-- Background: Full-Scale with Slow Zoom -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=2070&q=80" 
             alt="Exceptional Luxury Architecture" 
             class="w-full h-full object-cover opacity-60 transform scale-105 animate-slow-zoom">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950/90 via-primary-950/40 to-transparent"></div>
    </div>

    <!-- Main Content Grid -->
    <div class="relative z-10 w-full max-w-[1600px] mx-auto px-6 lg:px-12 pt-52 lg:pt-40 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Side: Compelling Content -->
            <div class="lg:col-span-8 space-y-12">
                <!-- Signature Badge: Brand Safe -->
                <div class="inline-flex items-center gap-4 animate-reveal">
                    <div class="w-12 h-[2px] bg-accent-500"></div>
                    <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">The Haven Standard — Est. {{ date('Y') }}</span>
                </div>

                <!-- Main Exception Headline: Sans-Serif Bold -->
                <h1 class="text-6xl md:text-8xl lg:text-9xl font-black text-white leading-[0.9] tracking-tighter animate-reveal [animation-delay:0.2s]">
                    <span class="text-accent-500">Unveiling</span> <br>
                    Excellence.
                </h1>

                <!-- Streamlined CTA & Description -->
                <div class="max-w-xl space-y-10 animate-reveal [animation-delay:0.4s]">
                    <p class="text-lg md:text-xl text-gray-300 font-light leading-relaxed border-l-2 border-accent-500/50 pl-8">
                        A curated portfolio of the most sought-after residences, where architectural innovation meets timeless luxury.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-8">
                        <a href="#search-card" class="px-12 py-5 bg-accent-600 text-white font-black uppercase tracking-[0.2em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-sm">
                            Begin Exploration
                        </a>
                        <a href="{{ route('properties.index') }}" class="group flex items-center gap-4 text-white hover:text-accent-400 transition-all duration-300">
                            <span class="text-[11px] font-bold uppercase tracking-[0.3em] border-b border-white/20 pb-1 group-hover:border-accent-500 transition-all">View All Properties</span>
                            <div class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center group-hover:bg-accent-500 group-hover:border-accent-500 transition-all">
                                <svg class="w-3 h-3 translate-x-[-1px] group-hover:translate-x-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Floating Impact Detail -->
            <div class="hidden lg:block lg:col-span-4 self-end animate-reveal [animation-delay:0.6s]">
                <div class="glass-premium p-10 rounded-[50px] exceptional-shadow text-white space-y-8 max-w-[340px] ml-auto">
                    <div class="flex justify-between items-start">
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-60">Global Reach</span>
                        <div class="flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full bg-accent-500 animate-pulse"></div>
                             <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-accent-400">Live Portfolio</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-5xl font-black leading-none mb-3">{{ number_format($stats['total_properties']) }}<span class="text-accent-500">+</span></div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] opacity-40 leading-relaxed">Artfully Curated <br>Verified Residences</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Integrated Search: White Editorial Architectural -->
<div id="search-card" class="relative z-20 -mt-16 px-6 animate-reveal [animation-delay:0.8s]">
    <div class="max-w-[1300px] mx-auto">
        <div class="bg-white rounded-[30px] md:rounded-full shadow-[0_32px_64px_-16px_rgba(0,0,0,0.15)] p-4 md:p-3 border border-gray-100 flex flex-col md:flex-row items-center gap-2">
            
            <!-- Location -->
            <div class="flex-1 w-full px-8 md:px-10 py-5 group/input relative">
                <label class="block text-[9px] font-black uppercase tracking-[0.4em] text-gray-400 mb-3 group-focus-within/input:text-accent-600 transition-colors">Location</label>
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <input type="text" placeholder="Where is your haven?" 
                           class="w-full bg-transparent border-none p-0 focus:ring-0 text-base font-black text-primary-950 placeholder-gray-300 tracking-wide uppercase">
                </div>
                <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[1px] h-12 bg-gray-100 hidden md:block"></div>
            </div>
            
            <!-- Custom Type Dropdown -->
            <div class="flex-1 w-full px-8 md:px-10 py-5 group/input relative" x-data="{ open: false, selected: 'Full Portfolio' }">
                <label class="block text-[9px] font-black uppercase tracking-[0.4em] text-gray-400 mb-3 group-focus-within/input:text-accent-600 transition-colors">Portfolio Type</label>
                <div @click="open = !open" @click.away="open = false" class="relative flex items-center gap-4 cursor-pointer">
                    <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="text-base font-black text-primary-950 tracking-wide uppercase" x-text="selected"></span>
                    <svg class="w-3 h-3 text-gray-400 absolute right-0 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute left-0 right-0 top-full mt-4 bg-white/95 backdrop-blur-xl rounded-[30px] shadow-2xl border border-gray-100 overflow-hidden z-50 p-2">
                    @foreach(['Full Portfolio', 'Legacy Estate', 'Urban Sanctuary'] as $type)
                        <div @click="selected = '{{ $type }}'; open = false" 
                             class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-primary-950 hover:bg-accent-500 hover:text-white rounded-[20px] transition-all cursor-pointer">
                            {{ $type }}
                        </div>
                    @endforeach
                </div>
                <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[1px] h-12 bg-gray-100 hidden md:block"></div>
            </div>

            <!-- Custom Price Dropdown -->
            <div class="flex-1 w-full px-8 md:px-10 py-5 group/input relative" x-data="{ open: false, selected: 'Any Magnitude' }">
                <label class="block text-[9px] font-black uppercase tracking-[0.4em] text-gray-400 mb-3 group-focus-within/input:text-accent-600 transition-colors">Investment</label>
                <div @click="open = !open" @click.away="open = false" class="relative flex items-center gap-4 cursor-pointer">
                    <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-base font-black text-primary-950 tracking-wide uppercase" x-text="selected"></span>
                    <svg class="w-3 h-3 text-gray-400 absolute right-0 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute left-0 right-0 top-full mt-4 bg-white/95 backdrop-blur-xl rounded-[30px] shadow-2xl border border-gray-100 overflow-hidden z-50 p-2">
                    @foreach(['Any Magnitude', 'Up to $5M', '$5M - $25M', '$25M+'] as $price)
                        <div @click="selected = '{{ $price }}'; open = false" 
                             class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.3em] text-primary-950 hover:bg-accent-500 hover:text-white rounded-[20px] transition-all cursor-pointer">
                            {{ $price }}
                        </div>
                    @endforeach
                </div>
            </div>

            <button class="w-full md:w-auto px-12 py-4 md:py-6 bg-accent-600 text-white font-black uppercase tracking-[0.3em] rounded-[20px] md:rounded-full hover:bg-accent-500 transition-all duration-500 text-[10px] shadow-2xl active:scale-95 group/btn">
                <span class="flex items-center justify-center gap-3">
                    Search Portfolio
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </span>
            </button>
        </div>
    </div>
</div>

<!-- The Philosophy: Brand-Safe Excellence -->
<div class="py-40 bg-white overflow-hidden">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
            <!-- Left: High-Impact Visual -->
            <div class="relative group">
                <div class="aspect-[4/5] rounded-[60px] overflow-hidden shadow-2xl">
                    <img src="{{ asset('images/philosophy-detail.png') }}" alt="Architectural Detail" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                </div>
                <!-- Overlapping Brand Element -->
                <div class="absolute -bottom-12 -right-12 bg-primary-950 p-10 rounded-[40px] shadow-2xl max-w-[300px] hidden md:block animate-reveal">
                    <p class="text-xl text-white font-light italic leading-relaxed">
                        "Elegance isn't about being noticed, it's about being <span class="text-accent-400 font-bold not-italic">remembered.</span>"
                    </p>
                </div>
            </div>

            <!-- Right: Brand Narrative -->
            <div class="space-y-12">
                <div class="space-y-6">
                    <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px]">The Philosophy</span>
                    <h2 class="text-5xl md:text-7xl font-black text-primary-950 leading-[1.1] tracking-tighter">
                        Where Vision <br>
                        <span class="text-accent-500 italic">Meets Reality.</span>
                    </h2>
                </div>
                
                <div class="space-y-8 text-lg text-gray-500 font-light leading-relaxed max-w-xl">
                    <p>
                        Haven was founded on a singular premise: that a home is more than a structure. It is a sanctuary of self-expression and a legacy for generations.
                    </p>
                    <p>
                        We curate only the most exceptional properties, ensuring each listing meets our rigorous standards for architectural integrity and modern living.
                    </p>
                </div>

                <div class="pt-6">
                    <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-6 group">
                        <span class="text-[11px] font-black uppercase tracking-[0.3em] border-b-2 border-gray-100 pb-2 group-hover:border-accent-500 transition-all">View All Properties</span>
                        <div class="w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center group-hover:bg-primary-950 group-hover:border-primary-950 group-hover:text-white transition-all duration-500">
                            <svg class="w-4 h-4 translate-x-[-2px] group-hover:translate-x-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Collection: Brand-Safe Editorial Gallery -->
@if(count($featuredProperties) > 0)
<div class="py-40 bg-gray-50">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-32 gap-12">
            <div class="space-y-6">
                <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px]">Curated Portfolio</span>
                <h2 class="text-6xl md:text-8xl font-black text-primary-950 leading-none tracking-tighter">Exceptional <br>Collections.</h2>
            </div>
            <div class="max-w-md">
                <p class="text-gray-500 font-light leading-relaxed mb-10">
                    Discover our most recent architectural acquisitions. Each residence is selected for its unique story and uncompromising quality.
                </p>
                <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-4 text-primary-950 hover:text-accent-600 transition-all font-bold uppercase tracking-[0.3em] text-[10px]">
                    Explore All Properties
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>

        <!-- Editorial Grid: Dynamic Aspect Ratios -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 lg:gap-32">
            @foreach($featuredProperties as $index => $property)
            <?php 
                // Convert to object if array
                $prop = is_array($property) ? (object)$property : $property;
                $primaryImage = null;
                if (isset($prop->images) && is_array($prop->images) && count($prop->images) > 0) {
                    $primaryImage = is_array($prop->images[0]) ? (object)$prop->images[0] : $prop->images[0];
                } elseif (isset($prop->primaryImage)) {
                    $primaryImage = is_array($prop->primaryImage) ? (object)$prop->primaryImage : $prop->primaryImage;
                }
                $category = isset($prop->category) ? (is_array($prop->category) ? (object)$prop->category : $prop->category) : null;
            ?>
            <div class="group {{ $index % 2 != 0 ? 'md:mt-40' : '' }}">
                <a href="{{ route('properties.show', $prop->slug ?? $prop->id) }}" class="block space-y-10 group">
                    <div class="relative overflow-hidden rounded-[60px] aspect-[4/5] exceptional-shadow bg-gray-200">
                        @if($primaryImage)
                            <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center opacity-20">
                                <svg class="h-20 w-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Hover Overlay: Brand Accent -->
                        <div class="absolute inset-0 bg-primary-950/20 opacity-0 group-hover:opacity-100 transition-opacity duration-700 flex items-center justify-center p-12">
                            <div class="glass-premium px-10 py-6 rounded-full text-white font-bold uppercase tracking-[0.3em] text-[10px]">
                                View Details — {{ format_naira($prop->price) }}
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-start pt-6 border-t border-gray-100 group-hover:border-accent-500/50 transition-all duration-500">
                        <div class="space-y-3">
                            <span class="text-accent-600 font-bold uppercase tracking-[0.3em] text-[9px]">{{ $category ? $category->name : 'Uncategorized' }}</span>
                            <h3 class="text-3xl font-black text-primary-950 group-hover:text-accent-600 transition-colors">{{ $prop->title }}</h3>
                        </div>
                        <div class="text-right space-y-2 opacity-50 group-hover:opacity-100 transition-opacity">
                            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-primary-950">{{ $prop->location }}</div>
                            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-accent-600">{{ $prop->bedrooms }} Bed • {{ $prop->bathrooms }} Bath</div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Latest Properties: Sophisticated Grid -->
@if(count($recentProperties) > 0)
<div class="py-40 bg-white">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-24 gap-12">
            <div class="space-y-6">
                <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px]">New Acquisitions</span>
                <h2 class="text-5xl md:text-7xl font-black text-primary-950 leading-none tracking-tighter">The Latest <br>Arrivals.</h2>
            </div>
            <div class="max-w-xs xl:max-w-md">
                <p class="text-gray-500 font-light leading-relaxed">
                    A first look at the most recent architectural statements to enter our verified collection.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            @foreach($recentProperties as $property)
            <?php 
                // Convert to object if array
                $prop = is_array($property) ? (object)$property : $property;
                $primaryImage = null;
                if (isset($prop->images) && is_array($prop->images) && count($prop->images) > 0) {
                    $primaryImage = is_array($prop->images[0]) ? (object)$prop->images[0] : $prop->images[0];
                } elseif (isset($prop->primaryImage)) {
                    $primaryImage = is_array($prop->primaryImage) ? (object)$prop->primaryImage : $prop->primaryImage;
                }
            ?>
            <div class="group">
                <a href="{{ route('properties.show', $prop->slug ?? $prop->id) }}" class="space-y-8 block group">
                    <div class="relative aspect-square overflow-hidden rounded-[40px] shadow-lg group-hover:shadow-2xl transition-all duration-700">
                        @if($primaryImage)
                            <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <svg class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <!-- Subtle Brand Tag -->
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/90 backdrop-blur-md text-[9px] font-black uppercase tracking-[0.3em] px-5 py-2 rounded-full text-primary-950 shadow-sm border border-gray-100">
                                {{ $prop->type == 'sale' ? 'Purchase' : 'Lease' }}
                            </span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-bold text-primary-950 group-hover:text-accent-600 transition-colors">{{ $prop->title }}</h3>
                            <span class="text-accent-600 font-black text-[11px] tracking-tight whitespace-nowrap">{{ format_naira($prop->price) }}</span>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-hover:text-gray-950 transition-colors">{{ $prop->location }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@include('partials.newsletter')

<!-- CTA: The Legacy Statement (Brand Safe) -->
<div class="py-60 bg-primary-950 relative overflow-hidden">
    <!-- Abstract Brand Watermark -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-[0.03] select-none pointer-events-none">
        <span class="text-[300px] font-black leading-none tracking-tighter text-white">HAVEN</span>
    </div>
    
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10 space-y-16">
        <div class="space-y-6">
            <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">Join Our Network</span>
            <h2 class="text-6xl md:text-9xl font-black text-white leading-none tracking-tighter">Defining the <br>Legacy.</h2>
        </div>
        
        <p class="text-xl text-gray-400 font-light leading-relaxed max-w-2xl mx-auto opacity-80">
            We are not just listing properties; we are curating lifestyles and preserving architectural heritage. Experience the Haven standard.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-10 justify-center items-center pt-8">
            @guest
                <a href="{{ route('register') }}" class="px-16 py-7 bg-accent-600 text-white font-black uppercase tracking-[0.3em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-xs">
                    Get Started Free
                </a>
            @endguest
            <a href="{{ route('properties.index') }}" class="group flex items-center gap-4 text-white hover:text-accent-400 transition-all duration-500">
                <span class="font-bold text-[11px] uppercase tracking-[0.3em] border-b border-white/20 pb-2 group-hover:border-accent-500 transition-all">Explore Full Portfolio</span>
                <div class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center group-hover:bg-accent-500 group-hover:border-accent-500 transition-all duration-500">
                    <svg class="w-4 h-4 translate-x-[-1px] group-hover:translate-x-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
