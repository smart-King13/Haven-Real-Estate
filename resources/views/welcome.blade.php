@extends('layouts.app')

@section('title', 'Haven - Find Your Dream Home')

@section('content')
<!-- Hero Section -->
<div class="relative min-h-[80vh] flex items-center overflow-hidden">
    <!-- Background Image with Dark Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1600596542815-2495db9dc2c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Luxury Home" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center md:items-start text-center md:text-left">
        <div class="max-w-3xl">
            <span class="inline-block py-1.5 px-4 rounded-sm bg-white/10 text-white text-xs font-bold uppercase tracking-widest mb-6 backdrop-blur-sm border border-white/20 shadow-sm">
                Premium Real Estate
            </span>
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 font-heading leading-tight animate-fade-in drop-shadow-md">
                Find Your Place <br>
                <span class="text-white">In The World.</span>
            </h1>
            <p class="text-xl text-gray-200 mb-10 max-w-2xl font-light leading-relaxed animate-slide-up mx-auto md:mx-0">
                Discover a curated selection of properties in the most sought-after locations. Trust Haven to find the home that matches your lifestyle.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start animate-slide-up w-full" style="animation-delay: 0.1s;">
                <a href="{{ route('properties.index') }}" class="btn-accent text-base px-8 py-4 shadow-lg hover:shadow-xl hover:bg-accent-500 transition-all duration-300">
                    Browse Properties
                </a>
                <a href="{{ route('register') }}" class="px-8 py-4 text-base font-medium text-white bg-transparent border border-white/40 hover:bg-white hover:text-primary-900 rounded shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                    Join Haven
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-white py-12 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="p-4">
                <div class="text-4xl font-bold text-primary-900 mb-2 font-heading">1500+</div>
                <div class="text-gray-500 font-medium">Properties Sold</div>
            </div>
            <div class="p-4">
                <div class="text-4xl font-bold text-primary-900 mb-2 font-heading">98%</div>
                <div class="text-gray-500 font-medium">Customer Satisfaction</div>
            </div>
            <div class="p-4">
                <div class="text-4xl font-bold text-primary-900 mb-2 font-heading">50+</div>
                <div class="text-gray-500 font-medium">Awards Won</div>
            </div>
            <div class="p-4">
                <div class="text-4xl font-bold text-primary-900 mb-2 font-heading">24/7</div>
                <div class="text-gray-500 font-medium">Support Available</div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Properties -->
<div class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-primary-900 mb-4 font-heading">Featured Properties</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Explore our hand-picked selection of the finest properties available right now.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Property Card 1 -->
            <div class="card-premium group overflow-hidden p-0">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=1771&q=80" alt="Modern Villa" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute top-4 left-4 bg-accent-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        For Sale
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Beverly Hills, CA
                        </p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-primary-900 font-heading group-hover:text-accent-600 transition-colors">Modern Luxury Villa</h3>
                        <p class="text-accent-600 font-bold text-lg">$2,500,000</p>
                    </div>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-2">Experience ultimate luxury in this stunning modern villa featuring panoramic city views.</p>
                    <div class="flex items-center justify-between text-gray-500 text-sm border-t border-gray-100 pt-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            5 Beds
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            4 Baths
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                            4,500 sqft
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Card 2 -->
            <div class="card-premium group overflow-hidden p-0">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" alt="Cozy Cottage" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute top-4 left-4 bg-primary-900 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        For Rent
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Austin, TX
                        </p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-primary-900 font-heading group-hover:text-accent-600 transition-colors">Cozy Family Cottage</h3>
                        <p class="text-accent-600 font-bold text-lg">$3,200<span class="text-sm text-gray-400 font-normal">/mo</span></p>
                    </div>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-2">Charming cottage with a beautiful garden, perfect for a small family.</p>
                    <div class="flex items-center justify-between text-gray-500 text-sm border-t border-gray-100 pt-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            3 Beds
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            2 Baths
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                            1,800 sqft
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Card 3 -->
            <div class="card-premium group overflow-hidden p-0">
                <div class="relative h-64 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2053&q=80" alt="Penthouse" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute top-4 left-4 bg-accent-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        For Sale
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            New York, NY
                        </p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-primary-900 font-heading group-hover:text-accent-600 transition-colors">Downtown Penthouse</h3>
                        <p class="text-accent-600 font-bold text-lg">$4,800,000</p>
                    </div>
                    <p class="text-gray-500 text-sm mb-6 line-clamp-2">Exclusive penthouse with private elevator and rooftop terrace.</p>
                    <div class="flex items-center justify-between text-gray-500 text-sm border-t border-gray-100 pt-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            4 Beds
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            3.5 Baths
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                            3,200 sqft
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('properties.index') }}" class="btn-secondary inline-flex items-center">
                View All Properties
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-primary-900 py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
        </svg>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 font-heading">Ready to Find Your Dream Home?</h2>
        <p class="text-xl text-gray-300 mb-10">Join thousands of satisfied customers who found their perfect property with Haven.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="btn-accent text-lg px-8 py-4">
                Get Started Now
            </a>
            <a href="{{ route('properties.index') }}" class="px-8 py-4 text-lg font-semibold text-white border border-white/30 hover:bg-white/10 rounded-lg transition-all duration-300">
                Browse Properties
            </a>
        </div>
    </div>
</div>
@endsection
