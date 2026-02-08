<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Haven - Premium Real Estate Management & Listings')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/haven-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/haven-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/haven-logo.png') }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Discover your dream home with Haven. Premium real estate listings, verified properties, and seamless property management services.')">
    <meta name="keywords" content="real estate, property management, luxury homes, rent, sale, Haven real estate">
    <meta name="author" content="Haven Real Estate">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Haven - Premium Real Estate Management & Listings')">
    <meta property="og:description" content="@yield('meta_description', 'Discover your dream home with Haven. Premium real estate listings, verified properties, and seamless property management services.')">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Haven - Premium Real Estate Management & Listings')">
    <meta property="twitter:description" content="@yield('meta_description', 'Discover your dream home with Haven. Premium real estate listings, verified properties, and seamless property management services.')">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Loading Spinner -->
    @include('components.loading-spinner')
    
    <!-- Additional CSS -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 leading-relaxed selection:bg-accent-500 selection:text-white">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        @unless(isset($hideNavbar) && $hideNavbar)
            @include('layouts.navigation')
        @endunless

        @hasSection('header')
            <header class="bg-white shadow-sm border-b border-gray-100">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Flash Messages -->
        <!-- Flash Messages -->
        @if(session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 1500)"
                 x-transition:enter="transform ease-out duration-300 transition"
                 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed top-24 right-6 z-50 max-w-sm w-full bg-white/90 backdrop-blur-xl border border-white/20 shadow-2xl rounded-[20px] p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-black uppercase tracking-widest text-green-600 mb-0.5">Success</p>
                    <p class="text-xs font-semibold text-primary-950">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-primary-950 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 1500)"
                 x-transition:enter="transform ease-out duration-300 transition"
                 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed top-24 right-6 z-50 max-w-sm w-full bg-white/90 backdrop-blur-xl border border-white/20 shadow-2xl rounded-[20px] p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-red-500/10 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-black uppercase tracking-widest text-red-600 mb-0.5">Error</p>
                    <p class="text-xs font-semibold text-primary-950">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-primary-950 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Live Chat Component (only on public pages) -->
        @if(!request()->is('dashboard*') && !request()->is('admin*'))
            @include('components.live-chat')
        @endif

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    @stack('scripts')
</body>
</html>
