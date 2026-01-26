<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard - Haven')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional CSS -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 leading-relaxed">
    <div class="min-h-screen flex overflow-hidden">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-72 bg-gradient-to-b from-primary-900 via-primary-900 to-primary-800 text-white shadow-2xl z-50 transform -translate-x-full transition-transform duration-300 lg:static lg:translate-x-0 overflow-y-auto" id="sidebar">
            <div class="flex flex-col h-full">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between h-24 px-8 border-b border-white/10 shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="overflow-hidden">
                            @if(file_exists(public_path('images/haven-logo.png')))
                                <img src="{{ asset('images/haven-logo.png') }}" alt="Haven Logo" class="h-10 w-10 object-contain rounded-lg">
                            @else
                                <div class="p-2 bg-accent-600 rounded-lg shadow-lg shadow-accent-600/20">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <span class="text-xl font-semibold font-heading tracking-tight uppercase">Haven <span class="text-accent-400">Admin</span></span>
                    </a>
                    <button class="lg:hidden p-2 text-white/50 hover:text-white" onclick="toggleSidebar()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-6 py-8 space-y-1">
                    <div class="text-xs font-semibold text-white/30 uppercase tracking-widest pl-4 mb-4">Main Menu</div>
                    
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-accent-600 text-white shadow-lg shadow-accent-600/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-white/40 group-hover:text-accent-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.properties.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.properties.*') ? 'bg-accent-600 text-white shadow-lg shadow-accent-600/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.properties.*') ? 'text-white' : 'text-white/40 group-hover:text-accent-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Properties
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-accent-600 text-white shadow-lg shadow-accent-600/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-white/40 group-hover:text-accent-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </a>

                    <a href="{{ route('admin.payments.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.payments.*') ? 'bg-accent-600 text-white shadow-lg shadow-accent-600/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.payments.*') ? 'text-white' : 'text-white/40 group-hover:text-accent-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Payments
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-accent-600 text-white shadow-lg shadow-accent-600/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-white/40 group-hover:text-accent-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        </svg>
                        Categories
                    </a>

                    <a href="{{ route('admin.chat.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.chat.*') ? 'bg-accent-600 text-white shadow-lg shadow-accent-600/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.chat.*') ? 'text-white' : 'text-white/40 group-hover:text-accent-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Live Chat
                        <span class="ml-auto w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    </a>

                    <a href="{{ route('admin.notifications.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.notifications.*') ? 'bg-accent-600 text-white shadow-lg shadow-accent-600/20' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.notifications.*') ? 'text-white' : 'text-white/40 group-hover:text-accent-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Notifications
                    </a>

                    <div class="pt-8 space-y-1">
                        <div class="text-xs font-semibold text-white/30 uppercase tracking-widest pl-4 mb-4">Quick Links</div>
                        <a href="{{ route('admin.properties.create') }}" class="group flex items-center px-4 py-2 text-sm text-white/60 hover:text-white transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent-500 mr-3"></span> Add Property
                        </a>
                        <a href="{{ route('home') }}" class="group flex items-center px-4 py-2 text-sm text-white/60 hover:text-white transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span> View Public Site
                        </a>
                    </div>
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-6 border-t border-white/10 shrink-0">
                    <div class="flex items-center gap-4 px-4 py-4 rounded-2xl bg-white/5">
                        <div class="h-10 w-10 rounded-xl bg-accent-500 flex items-center justify-center font-bold text-white shadow-lg overflow-hidden">
                            @if(Auth::user()->avatar && Illuminate\Support\Facades\Storage::disk('public')->exists(Auth::user()->avatar))
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-white/40 truncate italic">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300 opacity-0"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Top Navbar -->
            <header class="h-16 sm:h-20 bg-white border-b border-gray-100 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-sm shrink-0">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button class="lg:hidden p-2 text-gray-400 hover:text-gray-900" onclick="toggleSidebar()">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg sm:text-xl font-medium text-gray-900 font-heading tracking-tight truncate">@yield('page-title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4 sm:gap-6">
                    <!-- Notifications (Static for UI) -->
                    <button class="p-2 text-gray-400 hover:text-primary-900 transition-colors relative">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1 right-1 sm:top-1.5 sm:right-1.5 w-1.5 h-1.5 sm:w-2 sm:h-2 bg-red-500 rounded-full ring-1 sm:ring-2 ring-white"></span>
                    </button>

                    <!-- User Actions -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-1 sm:gap-2 focus:outline-none group">
                            <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-lg sm:rounded-xl bg-gray-100 flex items-center justify-center text-xs sm:text-sm font-medium text-gray-900 group-hover:bg-gray-200 transition-colors overflow-hidden">
                                @if(Auth::user()->avatar && Illuminate\Support\Facades\Storage::disk('public')->exists(Auth::user()->avatar))
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                                @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                            <svg class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </button>

                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 sm:mt-3 w-48 sm:w-56 bg-white rounded-xl sm:rounded-2xl shadow-2xl border border-gray-100 py-2 z-50 transform origin-top-right transition-all duration-200"
                             style="display: none;">
                            <div class="px-3 sm:px-4 py-2 sm:py-3 border-b border-gray-50">
                                <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('admin.profile') }}" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-600 hover:bg-gray-50 hover:text-accent-600 transition-colors">
                                <svg class="mr-2 sm:mr-3 h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                My Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="mr-2 sm:mr-3 h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50/50 p-4 sm:p-6 lg:p-8">
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
                         class="fixed top-20 sm:top-24 right-4 sm:right-6 z-50 max-w-xs sm:max-w-sm w-full bg-white/90 backdrop-blur-xl border border-white/20 shadow-2xl rounded-2xl sm:rounded-[20px] p-3 sm:p-4 flex items-center gap-3 sm:gap-4">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-green-500/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-green-600 mb-0.5">Success</p>
                            <p class="text-xs font-semibold text-primary-950 truncate">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-primary-950 transition-colors shrink-0">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                @if(session('error') || $errors->any())
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-init="setTimeout(() => show = false, 1500)"
                         x-transition:enter="transform ease-out duration-300 transition"
                         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed top-20 sm:top-24 right-4 sm:right-6 z-50 max-w-xs sm:max-w-sm w-full bg-white/90 backdrop-blur-xl border border-white/20 shadow-2xl rounded-2xl sm:rounded-[20px] p-3 sm:p-4 flex items-center gap-3 sm:gap-4">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-red-500/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-red-600 mb-0.5">Error</p>
                            <p class="text-xs font-semibold text-primary-950 truncate">
                                {{ session('error') ?? 'Please check value requirements.' }}
                            </p>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-primary-950 transition-colors shrink-0">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                <div class="max-w-[1600px] mx-auto pb-8 sm:pb-12">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                overlay.classList.add('hidden');
                overlay.classList.remove('block', 'opacity-100');
                overlay.classList.add('opacity-0');
            } else {
                overlay.classList.remove('hidden');
                overlay.classList.add('block');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    overlay.classList.add('opacity-100');
                }, 10);
            }
        }

        // Close sidebar when clicking links on mobile
        document.querySelectorAll('#sidebar nav a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    toggleSidebar();
                }
            });
        });

        // Refresh CSRF token periodically to prevent 419 errors
        setInterval(function() {
            fetch('/refresh-csrf', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                    // Update all CSRF token inputs
                    document.querySelectorAll('input[name="_token"]').forEach(input => {
                        input.value = data.token;
                    });
                }
            })
            .catch(error => console.log('CSRF refresh failed:', error));
        }, 600000); // Refresh every 10 minutes
    </script>
</body>
</html>
