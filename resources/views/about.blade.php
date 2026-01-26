@extends('layouts.app')

@section('title', 'About Haven - Our Mission & Vision')
@section('meta_description', 'Discover Haven\'s mission to redefine luxury real estate. Learn about our commitment to architectural excellence, verified properties, and exceptional client experiences.')

@section('content')
<!-- Hero Section: Brand Introduction -->
<div class="relative min-h-screen flex items-center overflow-hidden bg-primary-950">
    <!-- Background: Architectural Detail -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=2070&q=80" 
             alt="Luxury Architecture" 
             class="w-full h-full object-cover opacity-40 transform scale-105 animate-slow-zoom">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950/95 via-primary-950/60 to-primary-950/95"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-[1600px] mx-auto px-6 lg:px-12 pt-32 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Side: Brand Story -->
            <div class="lg:col-span-8 space-y-12">
                <!-- Brand Badge -->
                <div class="inline-flex items-center gap-4 animate-reveal">
                    <div class="w-12 h-[2px] bg-accent-500"></div>
                    <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">About Haven</span>
                </div>

                <!-- Main Headline -->
                <h1 class="text-6xl md:text-8xl lg:text-9xl font-black text-white leading-[0.9] tracking-tighter animate-reveal [animation-delay:0.2s]">
                    Redefining <br>
                    <span class="text-accent-500">Excellence.</span>
                </h1>

                <!-- Mission Statement -->
                <div class="max-w-2xl space-y-8 animate-reveal [animation-delay:0.4s]">
                    <p class="text-xl md:text-2xl text-gray-300 font-light leading-relaxed border-l-4 border-accent-500/50 pl-8">
                        Haven exists to transform how people discover, experience, and acquire exceptional properties. We curate only the finest residences where architectural innovation meets timeless luxury.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-8">
                        <a href="#mission" class="px-12 py-5 bg-accent-600 text-white font-black uppercase tracking-[0.2em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-sm">
                            Our Mission
                        </a>
                        <a href="#vision" class="group flex items-center gap-4 text-white hover:text-accent-400 transition-all duration-300">
                            <span class="text-[11px] font-bold uppercase tracking-[0.3em] border-b border-white/20 pb-1 group-hover:border-accent-500 transition-all">Our Vision</span>
                            <div class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center group-hover:bg-accent-500 group-hover:border-accent-500 transition-all">
                                <svg class="w-3 h-3 translate-x-[-1px] group-hover:translate-x-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m0 0l7-7"></path></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Trust Indicators -->
            <div class="hidden lg:block lg:col-span-4 self-end animate-reveal [animation-delay:0.6s]">
                <div class="glass-premium p-10 rounded-[50px] exceptional-shadow text-white space-y-8 max-w-[340px] ml-auto">
                    <div class="flex justify-between items-start">
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-60">Since 2024</span>
                        <div class="flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full bg-accent-500 animate-pulse"></div>
                             <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-accent-400">Verified Excellence</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-5xl font-black leading-none mb-3">100<span class="text-accent-500">%</span></div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] opacity-40 leading-relaxed">Verified Properties <br>Architectural Standards</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mission Section -->
<div id="mission" class="py-40 bg-white overflow-hidden">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
            <!-- Left: Mission Content -->
            <div class="space-y-12">
                <div class="space-y-6">
                    <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px]">Our Mission</span>
                    <h2 class="text-5xl md:text-7xl font-black text-primary-950 leading-[1.1] tracking-tighter">
                        Curating <br>
                        <span class="text-accent-500 italic">Exceptional Homes.</span>
                    </h2>
                </div>
                
                <div class="space-y-8 text-lg text-gray-600 font-light leading-relaxed max-w-xl">
                    <p>
                        <strong class="text-primary-950 font-semibold">Haven was founded on a singular belief:</strong> that finding your perfect home should be an extraordinary experience, not a compromise.
                    </p>
                    <p>
                        We meticulously verify every property in our portfolio, ensuring each residence meets our uncompromising standards for architectural integrity, location desirability, and modern living excellence.
                    </p>
                    <p>
                        Our mission extends beyond transactions—we're building lasting relationships and helping families discover spaces where memories are made and legacies begin.
                    </p>
                </div>

                <!-- Mission Points -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-8">
                    <div class="space-y-3">
                        <div class="w-12 h-12 bg-accent-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-primary-950">Verified Excellence</h3>
                        <p class="text-sm text-gray-600">Every property undergoes rigorous verification for quality, authenticity, and value.</p>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="w-12 h-12 bg-accent-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-primary-950">Client-Centric</h3>
                        <p class="text-sm text-gray-600">Your dreams and requirements guide every recommendation we make.</p>
                    </div>
                </div>
            </div>

            <!-- Right: Visual Element -->
            <div class="relative group">
                <div class="aspect-[4/5] rounded-[60px] overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1000&q=80" alt="Luxury Interior" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                </div>
                <!-- Floating Quote -->
                <div class="absolute -bottom-12 -left-12 bg-primary-950 p-10 rounded-[40px] shadow-2xl max-w-[300px] hidden md:block">
                    <p class="text-lg text-white font-light italic leading-relaxed">
                        "Excellence isn't about perfection, it's about <span class="text-accent-400 font-semibold not-italic">exceeding expectations.</span>"
                    </p>
                    <div class="mt-4 text-xs text-white/60 uppercase tracking-wider">Haven Philosophy</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vision Section -->
<div id="vision" class="py-40 bg-gray-50">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <!-- Section Header -->
        <div class="text-center mb-24">
            <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px] mb-6 block">Our Vision</span>
            <h2 class="text-5xl md:text-7xl font-black text-primary-950 leading-none tracking-tighter mb-8">
                The Future of <br>
                <span class="text-accent-500">Real Estate.</span>
            </h2>
            <p class="text-xl text-gray-600 font-light leading-relaxed max-w-3xl mx-auto">
                We envision a world where finding your perfect home is seamless, transparent, and inspiring. Where technology enhances human connection, not replaces it.
            </p>
        </div>

        <!-- Vision Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Innovation -->
            <div class="text-center space-y-6">
                <div class="w-20 h-20 bg-primary-950 rounded-[30px] flex items-center justify-center mx-auto shadow-xl">
                    <svg class="w-10 h-10 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-primary-950">Innovation</h3>
                <p class="text-gray-600 leading-relaxed">
                    Leveraging cutting-edge technology to create intuitive, powerful tools that simplify the property discovery process while maintaining the human touch.
                </p>
            </div>

            <!-- Transparency -->
            <div class="text-center space-y-6">
                <div class="w-20 h-20 bg-primary-950 rounded-[30px] flex items-center justify-center mx-auto shadow-xl">
                    <svg class="w-10 h-10 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-primary-950">Transparency</h3>
                <p class="text-gray-600 leading-relaxed">
                    Complete openness in every transaction. No hidden fees, no surprises—just honest, straightforward communication throughout your journey.
                </p>
            </div>

            <!-- Excellence -->
            <div class="text-center space-y-6">
                <div class="w-20 h-20 bg-primary-950 rounded-[30px] flex items-center justify-center mx-auto shadow-xl">
                    <svg class="w-10 h-10 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-primary-950">Excellence</h3>
                <p class="text-gray-600 leading-relaxed">
                    Setting new standards for quality, service, and client satisfaction. Every interaction reflects our commitment to exceptional experiences.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- What We Offer Section -->
<div class="py-40 bg-white">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-24 gap-12">
            <div class="space-y-6">
                <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px]">What We Offer</span>
                <h2 class="text-5xl md:text-7xl font-black text-primary-950 leading-none tracking-tighter">
                    Comprehensive <br>
                    <span class="text-accent-500">Solutions.</span>
                </h2>
            </div>
            <div class="max-w-md">
                <p class="text-gray-600 font-light leading-relaxed">
                    From initial discovery to final transaction, we provide end-to-end support for your real estate journey.
                </p>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Property Discovery -->
            <div class="group">
                <div class="bg-gray-50 rounded-[30px] p-8 h-full transition-all duration-500 hover:bg-primary-950 hover:text-white">
                    <div class="w-16 h-16 bg-accent-100 group-hover:bg-accent-600 rounded-[20px] flex items-center justify-center mb-6 transition-all duration-500">
                        <svg class="w-8 h-8 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary-950 group-hover:text-white mb-4 transition-colors duration-500">Property Discovery</h3>
                    <p class="text-gray-600 group-hover:text-white/80 text-sm leading-relaxed transition-colors duration-500">
                        Advanced search and filtering tools to help you discover properties that match your exact criteria and lifestyle preferences.
                    </p>
                </div>
            </div>

            <!-- Verification Services -->
            <div class="group">
                <div class="bg-gray-50 rounded-[30px] p-8 h-full transition-all duration-500 hover:bg-primary-950 hover:text-white">
                    <div class="w-16 h-16 bg-accent-100 group-hover:bg-accent-600 rounded-[20px] flex items-center justify-center mb-6 transition-all duration-500">
                        <svg class="w-8 h-8 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary-950 group-hover:text-white mb-4 transition-colors duration-500">Verification Services</h3>
                    <p class="text-gray-600 group-hover:text-white/80 text-sm leading-relaxed transition-colors duration-500">
                        Comprehensive property verification including legal checks, structural assessments, and market value analysis.
                    </p>
                </div>
            </div>

            <!-- Transaction Support -->
            <div class="group">
                <div class="bg-gray-50 rounded-[30px] p-8 h-full transition-all duration-500 hover:bg-primary-950 hover:text-white">
                    <div class="w-16 h-16 bg-accent-100 group-hover:bg-accent-600 rounded-[20px] flex items-center justify-center mb-6 transition-all duration-500">
                        <svg class="w-8 h-8 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary-950 group-hover:text-white mb-4 transition-colors duration-500">Transaction Support</h3>
                    <p class="text-gray-600 group-hover:text-white/80 text-sm leading-relaxed transition-colors duration-500">
                        Secure payment processing, legal documentation, and end-to-end transaction management for peace of mind.
                    </p>
                </div>
            </div>

            <!-- Ongoing Support -->
            <div class="group">
                <div class="bg-gray-50 rounded-[30px] p-8 h-full transition-all duration-500 hover:bg-primary-950 hover:text-white">
                    <div class="w-16 h-16 bg-accent-100 group-hover:bg-accent-600 rounded-[20px] flex items-center justify-center mb-6 transition-all duration-500">
                        <svg class="w-8 h-8 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary-950 group-hover:text-white mb-4 transition-colors duration-500">Ongoing Support</h3>
                    <p class="text-gray-600 group-hover:text-white/80 text-sm leading-relaxed transition-colors duration-500">
                        Continued relationship beyond the transaction with property management recommendations and market insights.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Trust & Credibility Section -->
<div class="py-40 bg-primary-950 relative overflow-hidden">
    <!-- Abstract Brand Watermark -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-[0.03] select-none pointer-events-none">
        <span class="text-[300px] font-black leading-none tracking-tighter text-white">TRUST</span>
    </div>
    
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10 space-y-16">
        <div class="space-y-6">
            <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">Built on Trust</span>
            <h2 class="text-5xl md:text-7xl font-black text-white leading-none tracking-tighter">
                Your Success is <br>
                <span class="text-accent-500">Our Legacy.</span>
            </h2>
        </div>
        
        <p class="text-xl text-gray-400 font-light leading-relaxed max-w-2xl mx-auto opacity-80">
            Every decision we make, every property we curate, and every relationship we build is guided by one principle: your complete satisfaction and success.
        </p>
        
        <!-- Trust Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 pt-16">
            <div class="text-center">
                <div class="text-4xl font-black text-accent-500 mb-2">100%</div>
                <div class="text-sm font-bold uppercase tracking-wider text-white/60">Verified Properties</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-black text-accent-500 mb-2">24/7</div>
                <div class="text-sm font-bold uppercase tracking-wider text-white/60">Client Support</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-black text-accent-500 mb-2">∞</div>
                <div class="text-sm font-bold uppercase tracking-wider text-white/60">Commitment</div>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-10 justify-center items-center pt-8">
            <a href="{{ route('properties.index') }}" class="px-16 py-7 bg-accent-600 text-white font-black uppercase tracking-[0.3em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-xs">
                Explore Properties
            </a>
            <a href="{{ route('home') }}" class="group flex items-center gap-4 text-white hover:text-accent-400 transition-all duration-500">
                <span class="font-bold text-[11px] uppercase tracking-[0.3em] border-b border-white/20 pb-2 group-hover:border-accent-500 transition-all">Return Home</span>
                <div class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center group-hover:bg-accent-500 group-hover:border-accent-500 transition-all duration-500">
                    <svg class="w-4 h-4 translate-x-[-1px] group-hover:translate-x-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
