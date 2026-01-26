@extends('layouts.app')

@section('title', 'Journal - Haven | Insights & Market Intelligence')
@section('meta_description', 'Discover exclusive insights, market intelligence, and luxury real estate trends from Haven\'s expert team. Stay informed with our premium journal.')

@section('content')
<!-- Journal Hero: Editorial Excellence -->
<div class="relative min-h-screen flex items-center overflow-hidden bg-primary-950">
    <!-- Background: Sophisticated Architecture -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=2070&q=80" 
             alt="Editorial Excellence" 
             class="w-full h-full object-cover opacity-50 transform scale-105 animate-slow-zoom">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950/95 via-primary-950/70 to-primary-950/95"></div>
    </div>

    <!-- Main Content Grid -->
    <div class="relative z-10 w-full max-w-[1600px] mx-auto px-6 lg:px-12 pt-32 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Side: Journal Introduction -->
            <div class="lg:col-span-8 space-y-12">
                <!-- Signature Badge -->
                <div class="inline-flex items-center gap-4 animate-reveal">
                    <div class="w-12 h-[2px] bg-accent-500"></div>
                    <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">The Haven Journal — Intelligence & Insights</span>
                </div>

                <!-- Main Headline -->
                <h1 class="text-6xl md:text-8xl lg:text-9xl font-black text-white leading-[0.9] tracking-tighter animate-reveal [animation-delay:0.2s]">
                    Market <br>
                    <span class="text-accent-500">Intelligence.</span>
                </h1>

                <!-- Description & CTA -->
                <div class="max-w-2xl space-y-10 animate-reveal [animation-delay:0.4s]">
                    <p class="text-xl md:text-2xl text-gray-300 font-light leading-relaxed border-l-4 border-accent-500/50 pl-8">
                        Exclusive insights, market trends, and expert analysis from Haven's team of real estate professionals. Stay ahead with intelligence that matters.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-8">
                        <a href="#featured-articles" class="px-12 py-5 bg-accent-600 text-white font-black uppercase tracking-[0.2em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-sm">
                            Explore Articles
                        </a>
                        <a href="#newsletter" class="group flex items-center gap-4 text-white hover:text-accent-400 transition-all duration-300">
                            <span class="text-[11px] font-bold uppercase tracking-[0.3em] border-b border-white/20 pb-1 group-hover:border-accent-500 transition-all">Subscribe</span>
                            <div class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center group-hover:bg-accent-500 group-hover:border-accent-500 transition-all">
                                <svg class="w-3 h-3 translate-x-[-1px] group-hover:translate-x-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Journal Stats -->
            <div class="hidden lg:block lg:col-span-4 self-end animate-reveal [animation-delay:0.6s]">
                <div class="glass-premium p-10 rounded-[50px] exceptional-shadow text-white space-y-8 max-w-[340px] ml-auto">
                    <div class="flex justify-between items-start">
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-60">Weekly Insights</span>
                        <div class="flex items-center gap-2">
                             <div class="w-2 h-2 rounded-full bg-accent-500 animate-pulse"></div>
                             <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-accent-400">Fresh Content</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-5xl font-black leading-none mb-3">50<span class="text-accent-500">+</span></div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] opacity-40 leading-relaxed">Expert Articles <br>& Market Reports</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Articles Section -->
<div id="featured-articles" class="py-40 bg-white overflow-hidden">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <!-- Section Header -->
        <div class="text-center mb-24 animate-reveal">
            <div class="inline-flex items-center gap-4 mb-8">
                <div class="w-8 h-[2px] bg-accent-500"></div>
                <span class="text-accent-600 font-bold uppercase tracking-[0.4em] text-[10px]">Featured Content</span>
                <div class="w-8 h-[2px] bg-accent-500"></div>
            </div>
            <h2 class="text-4xl md:text-6xl font-black text-primary-950 leading-[1.1] tracking-tighter mb-6">
                Latest <span class="text-accent-500 italic">Insights.</span>
            </h2>
            <p class="text-lg text-gray-600 font-light leading-relaxed max-w-2xl mx-auto">
                Stay informed with our curated selection of market intelligence, investment strategies, and luxury real estate trends.
            </p>
        </div>

        <!-- Featured Article Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-32">
            <!-- Main Featured Article -->
            <div class="group relative animate-reveal overflow-hidden rounded-[40px] shadow-2xl hover:shadow-accent-500/10 transition-all duration-700 bg-white">
                <div class="aspect-[4/3] overflow-hidden rounded-[40px]">
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?auto=format&fit=crop&w=1200&q=80" 
                         alt="Market Trends 2024" 
                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-950/90 via-primary-950/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    <!-- Article Badge -->
                    <div class="absolute top-8 left-8">
                        <span class="px-4 py-2 bg-accent-600/90 backdrop-blur-xl border border-accent-500/30 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full">
                            Market Analysis
                        </span>
                    </div>

                    <!-- Article Content -->
                    <div class="absolute inset-x-0 bottom-0 p-10 space-y-6">
                        <div class="space-y-3">
                            <div class="text-accent-400 font-black text-[10px] uppercase tracking-[0.4em]">December 26, 2024</div>
                            <h3 class="text-3xl font-black text-white leading-[1.1] tracking-tighter">Luxury Real Estate Market Trends for 2025</h3>
                            <p class="text-white/70 text-sm font-light leading-relaxed">
                                Comprehensive analysis of emerging trends, investment opportunities, and market predictions for the luxury real estate sector.
                            </p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-accent-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-black text-[10px]">HT</span>
                                </div>
                                <div>
                                    <div class="text-white font-bold text-xs">Haven Team</div>
                                    <div class="text-white/50 text-[10px] font-medium">Market Analysts</div>
                                </div>
                            </div>
                            <a href="#" class="w-12 h-12 bg-accent-600 text-white rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 flex items-center justify-center shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Featured Article -->
            <div class="group relative animate-reveal overflow-hidden rounded-[40px] shadow-2xl hover:shadow-accent-500/10 transition-all duration-700 bg-white [animation-delay:0.2s]">
                <div class="aspect-[4/3] overflow-hidden rounded-[40px]">
                    <img src="https://images.unsplash.com/photo-1582407947304-fd86f028f716?auto=format&fit=crop&w=1200&q=80" 
                         alt="Investment Strategies" 
                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-950/90 via-primary-950/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    <!-- Article Badge -->
                    <div class="absolute top-8 left-8">
                        <span class="px-4 py-2 bg-white/10 backdrop-blur-xl border border-white/20 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full">
                            Investment Guide
                        </span>
                    </div>

                    <!-- Article Content -->
                    <div class="absolute inset-x-0 bottom-0 p-10 space-y-6">
                        <div class="space-y-3">
                            <div class="text-accent-400 font-black text-[10px] uppercase tracking-[0.4em]">December 24, 2024</div>
                            <h3 class="text-3xl font-black text-white leading-[1.1] tracking-tighter">Smart Investment Strategies for Premium Properties</h3>
                            <p class="text-white/70 text-sm font-light leading-relaxed">
                                Expert guidance on maximizing returns and building wealth through strategic luxury real estate investments.
                            </p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-accent-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-black text-[10px]">SA</span>
                                </div>
                                <div>
                                    <div class="text-white font-bold text-xs">Sarah Anderson</div>
                                    <div class="text-white/50 text-[10px] font-medium">Investment Advisor</div>
                                </div>
                            </div>
                            <a href="#" class="w-12 h-12 bg-accent-600 text-white rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 flex items-center justify-center shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-32">
            <!-- Market Intelligence -->
            <div class="group text-center space-y-8 p-12 bg-gray-50 rounded-[40px] hover:bg-primary-950 hover:text-white transition-all duration-700 animate-reveal">
                <div class="w-20 h-20 bg-accent-100 group-hover:bg-accent-600 rounded-[25px] flex items-center justify-center mx-auto transition-all duration-700">
                    <svg class="w-10 h-10 text-accent-600 group-hover:text-white transition-colors duration-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="space-y-4">
                    <h3 class="text-2xl font-black text-primary-950 group-hover:text-white uppercase tracking-tighter transition-colors duration-700">Market Intelligence</h3>
                    <p class="text-gray-600 group-hover:text-white/80 font-light leading-relaxed transition-colors duration-700">
                        In-depth market analysis, pricing trends, and economic indicators affecting luxury real estate.
                    </p>
                    <div class="text-accent-600 group-hover:text-accent-400 font-black text-2xl transition-colors duration-700">12 Articles</div>
                </div>
            </div>

            <!-- Investment Strategies -->
            <div class="group text-center space-y-8 p-12 bg-gray-50 rounded-[40px] hover:bg-primary-950 hover:text-white transition-all duration-700 animate-reveal [animation-delay:0.2s]">
                <div class="w-20 h-20 bg-accent-100 group-hover:bg-accent-600 rounded-[25px] flex items-center justify-center mx-auto transition-all duration-700">
                    <svg class="w-10 h-10 text-accent-600 group-hover:text-white transition-colors duration-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="space-y-4">
                    <h3 class="text-2xl font-black text-primary-950 group-hover:text-white uppercase tracking-tighter transition-colors duration-700">Investment Strategies</h3>
                    <p class="text-gray-600 group-hover:text-white/80 font-light leading-relaxed transition-colors duration-700">
                        Expert guidance on portfolio diversification, ROI optimization, and wealth building through real estate.
                    </p>
                    <div class="text-accent-600 group-hover:text-accent-400 font-black text-2xl transition-colors duration-700">18 Articles</div>
                </div>
            </div>

            <!-- Lifestyle & Design -->
            <div class="group text-center space-y-8 p-12 bg-gray-50 rounded-[40px] hover:bg-primary-950 hover:text-white transition-all duration-700 animate-reveal [animation-delay:0.4s]">
                <div class="w-20 h-20 bg-accent-100 group-hover:bg-accent-600 rounded-[25px] flex items-center justify-center mx-auto transition-all duration-700">
                    <svg class="w-10 h-10 text-accent-600 group-hover:text-white transition-colors duration-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="space-y-4">
                    <h3 class="text-2xl font-black text-primary-950 group-hover:text-white uppercase tracking-tighter transition-colors duration-700">Lifestyle & Design</h3>
                    <p class="text-gray-600 group-hover:text-white/80 font-light leading-relaxed transition-colors duration-700">
                        Architectural trends, interior design insights, and luxury lifestyle content for discerning clients.
                    </p>
                    <div class="text-accent-600 group-hover:text-accent-400 font-black text-2xl transition-colors duration-700">24 Articles</div>
                </div>
            </div>
        </div>

        <!-- Recent Articles List -->
        <div class="space-y-8 animate-reveal">
            <div class="flex items-center justify-between">
                <h3 class="text-3xl font-black text-primary-950 uppercase tracking-tighter">Recent Articles</h3>
                <a href="#" class="text-accent-600 hover:text-primary-950 font-black text-sm uppercase tracking-[0.3em] transition-colors">View All</a>
            </div>
            
            <div class="space-y-6">
                <!-- Article Item -->
                <div class="group flex items-center gap-8 p-8 bg-gray-50 rounded-[30px] hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <div class="w-24 h-24 bg-accent-100 rounded-[20px] flex items-center justify-center shrink-0 group-hover:bg-accent-600 transition-all duration-500">
                        <svg class="w-12 h-12 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="text-accent-600 font-black text-[10px] uppercase tracking-[0.4em]">December 22, 2024</div>
                        <h4 class="text-xl font-black text-primary-950 group-hover:text-accent-600 transition-colors duration-500">Q4 2024 Market Performance Review</h4>
                        <p class="text-gray-600 font-light leading-relaxed">Comprehensive analysis of market performance, key metrics, and outlook for the coming quarter.</p>
                    </div>
                    <div class="w-12 h-12 bg-primary-950 group-hover:bg-accent-600 text-white rounded-full flex items-center justify-center transition-all duration-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>

                <!-- Article Item -->
                <div class="group flex items-center gap-8 p-8 bg-gray-50 rounded-[30px] hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <div class="w-24 h-24 bg-accent-100 rounded-[20px] flex items-center justify-center shrink-0 group-hover:bg-accent-600 transition-all duration-500">
                        <svg class="w-12 h-12 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                        </svg>
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="text-accent-600 font-black text-[10px] uppercase tracking-[0.4em]">December 20, 2024</div>
                        <h4 class="text-xl font-black text-primary-950 group-hover:text-accent-600 transition-colors duration-500">Emerging Neighborhoods: Where to Invest Next</h4>
                        <p class="text-gray-600 font-light leading-relaxed">Identifying up-and-coming areas with strong growth potential and investment opportunities.</p>
                    </div>
                    <div class="w-12 h-12 bg-primary-950 group-hover:bg-accent-600 text-white rounded-full flex items-center justify-center transition-all duration-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>

                <!-- Article Item -->
                <div class="group flex items-center gap-8 p-8 bg-gray-50 rounded-[30px] hover:bg-white hover:shadow-2xl transition-all duration-500">
                    <div class="w-24 h-24 bg-accent-100 rounded-[20px] flex items-center justify-center shrink-0 group-hover:bg-accent-600 transition-all duration-500">
                        <svg class="w-12 h-12 text-accent-600 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="text-accent-600 font-black text-[10px] uppercase tracking-[0.4em]">December 18, 2024</div>
                        <h4 class="text-xl font-black text-primary-950 group-hover:text-accent-600 transition-colors duration-500">Sustainable Luxury: The Future of Premium Real Estate</h4>
                        <p class="text-gray-600 font-light leading-relaxed">How sustainability and luxury converge in modern real estate development and investment.</p>
                    </div>
                    <div class="w-12 h-12 bg-primary-950 group-hover:bg-accent-600 text-white rounded-full flex items-center justify-center transition-all duration-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Subscription Section -->
<div id="newsletter" class="py-40 bg-primary-950 relative overflow-hidden">
    <!-- Abstract Brand Watermark -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-[0.03] select-none pointer-events-none">
        <span class="text-[300px] font-black leading-none tracking-tighter text-white">JOURNAL</span>
    </div>
    
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10 space-y-16">
        <div class="space-y-6">
            <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[10px]">Stay Informed</span>
            <h2 class="text-5xl md:text-7xl font-black text-white leading-none tracking-tighter">
                Never Miss <br>
                <span class="text-accent-500">An Insight.</span>
            </h2>
        </div>
        
        <p class="text-xl text-gray-400 font-light leading-relaxed max-w-2xl mx-auto opacity-80">
            Subscribe to Haven Journal and receive exclusive market intelligence, investment insights, and luxury real estate trends delivered to your inbox weekly.
        </p>
        
        <!-- Newsletter Form -->
        <div class="max-w-2xl mx-auto">
            <form class="flex flex-col sm:flex-row gap-4 p-2 bg-white/10 backdrop-blur-xl rounded-full border border-white/20">
                <input type="email" placeholder="Enter your email address" 
                       class="flex-1 px-8 py-4 bg-transparent border-none text-white placeholder-white/60 focus:ring-0 focus:outline-none font-medium">
                <button type="submit" class="px-12 py-4 bg-accent-600 text-white font-black uppercase tracking-[0.3em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl text-sm">
                    Subscribe
                </button>
            </form>
            <p class="text-white/40 text-xs font-medium mt-4">
                Join 5,000+ real estate professionals and investors. Unsubscribe anytime.
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-10 justify-center items-center pt-8">
            <a href="{{ route('properties.index') }}" class="px-16 py-7 bg-white/10 backdrop-blur-xl border border-white/20 text-white font-black uppercase tracking-[0.3em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-xs">
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
