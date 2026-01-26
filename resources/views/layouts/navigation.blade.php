<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 50)"
     x-init="$watch('open', value => document.body.style.overflow = value ? 'hidden' : '')"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-700" id="navbar">
    
    <div :class="{ 'bg-white shadow-[0_20px_50px_rgba(0,0,0,0.1)] border-gray-100 rounded-b-[30px]': scrolled, 'bg-transparent border-transparent': !scrolled }"
         class="max-w-[1600px] mx-auto flex items-center justify-between px-6 lg:px-10 py-4 transition-all duration-700">
        
        <!-- Logo: Brand Architecture -->
        <div class="flex items-center shrink-0">
            <a href="{{ route('home') }}" class="flex items-center gap-4 group">
                <div class="w-10 h-10 flex items-center justify-center rounded-xl group-hover:scale-110 transition-all duration-500 overflow-hidden">
                    @if(file_exists(public_path('images/haven-logo.png')))
                        <img src="{{ asset('images/haven-logo.png') }}" alt="Haven Logo" class="w-full h-full object-contain rounded-xl">
                    @else
                        <div :class="{ 'bg-primary-950': scrolled, 'bg-white': !scrolled }" class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors">
                            <span :class="{ 'text-white': scrolled, 'text-primary-950': !scrolled }" class="text-2xl font-black">H</span>
                        </div>
                    @endif
                </div>
                <span :class="{ 'text-primary-950': scrolled, 'text-white': !scrolled }"
                      class="text-sm font-black uppercase tracking-[0.5em] transition-colors group-hover:text-accent-500">
                    Haven
                </span>
            </a>
        </div>

        <!-- Desktop Navigation: Premium Spacing -->
        <div class="hidden lg:flex items-center gap-12">
            @php
                $navLinks = [
                    ['route' => 'home', 'label' => 'Home'],
                    ['route' => 'properties.index', 'label' => 'Portfolio'],
                    ['route' => 'about', 'label' => 'About'],
                    ['route' => 'contact', 'label' => 'Contact'],
                    ['route' => 'journal', 'label' => 'Journal']
                ];
            @endphp

            @foreach($navLinks as $link)
                <a href="{{ isset($link['route']) ? route($link['route']) : '#' }}" 
                   :class="{ 'text-primary-950': scrolled, 'text-white/80': !scrolled }"
                   class="text-[10px] font-black uppercase tracking-[0.3em] hover:text-accent-500 transition-all relative group">
                    {{ $link['label'] }}
                    <span class="absolute -bottom-2 left-0 w-0 h-[2px] bg-accent-500 group-hover:w-full transition-all duration-500"></span>
                </a>
            @endforeach
        </div>

        <!-- Right Side: Action & Auth -->
        <div class="hidden lg:flex items-center gap-8">
            @auth
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" 
                            :class="{ 'text-primary-950': scrolled, 'text-white': !scrolled }"
                            class="flex items-center gap-3 py-2 px-4 rounded-full bg-primary-950/5 hover:bg-primary-950/10 transition-all border border-transparent hover:border-accent-500/20">
                        <div class="h-8 w-8 rounded-full bg-accent-600 flex items-center justify-center text-[10px] font-black text-white overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest">{{ Auth::user()->name }}</span>
                    </button>
                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl py-2 z-50 border border-gray-100 overflow-hidden transform origin-top-right text-left"
                         style="display: none;">
                        <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Signed in as</p>
                            <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <div class="py-1">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-5 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-accent-600 transition-colors">
                                    <svg class="h-4 w-4 mr-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                    {{ __('Superadmin Panel') }}
                                </a>
                            @else
                                <a href="{{ route('user.dashboard') }}" class="flex items-center px-5 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-accent-600 transition-colors">
                                    <svg class="h-4 w-4 mr-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                    {{ __('My Dashboard') }}
                                </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-5 py-3 text-sm text-gray-600 hover:bg-gray-50 hover:text-accent-600 transition-colors">
                                <svg class="h-4 w-4 mr-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                {{ __('Account Settings') }}
                            </a>
                        </div>

                        <div class="py-1 border-t border-gray-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-5 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="h-4 w-4 mr-3 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4-4H3" /></svg>
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" 
                   :class="{ 'text-primary-950': scrolled, 'text-white/70': !scrolled }"
                   class="text-[10px] font-black uppercase tracking-[0.3em] hover:text-accent-500 transition-all">Log in</a>
                
                <a href="{{ route('register') }}" 
                   class="px-8 py-3 bg-accent-600 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-full hover:bg-accent-500 transition-all duration-500 shadow-xl">
                    Get Started
                </a>
            @endauth
        </div>

        <!-- Hamburger (Mobile) -->
        <div class="flex items-center lg:hidden">
            <button @click="open = true" 
                    :class="{ 'text-primary-950': scrolled, 'text-white': !scrolled }"
                    class="hover:text-accent-600 transition-colors">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer Overlay -->
    <div x-show="open" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-primary-950/95 z-[60] lg:hidden"
         style="display: none;"></div>

     <!-- Mobile Drawer -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition transform ease-out duration-500"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition transform ease-in duration-400"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed top-0 right-0 h-full w-[85%] max-w-xs bg-primary-950 shadow-[-20px_0_60px_rgba(0,0,0,0.8)] z-[70] lg:hidden flex flex-col border-l border-white/5"
         style="display: none;">
        
        <!-- Drawer Header -->
        <div class="flex items-center justify-between p-8 border-b border-white/5">
            <div class="flex items-center gap-4">
                <div class="w-8 h-8 bg-accent-600 flex items-center justify-center rounded-lg shadow-lg shadow-accent-600/20">
                    <span class="text-white font-black text-sm">H</span>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-white">The Menu</span>
            </div>
            <button @click="open = false" class="group p-2 text-white/40 hover:text-white transition-all">
                <svg class="h-6 w-6 transform group-hover:rotate-90 transition-transform duration-300" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Drawer Links -->
        <div class="flex-1 overflow-y-auto p-8 space-y-12">
            <!-- Navigation -->
            <div class="space-y-6">
                <div class="text-[9px] font-black uppercase tracking-[0.5em] text-accent-500/60 pb-3 border-b border-white/5">Navigation</div>
                <div class="flex flex-col gap-5">
                    @foreach($navLinks as $link)
                        <a href="{{ isset($link['route']) ? route($link['route']) : '#' }}" 
                           class="group flex items-center justify-between text-[11px] font-black uppercase tracking-[0.3em] text-white hover:text-accent-500 transition-all">
                            <span>{{ $link['label'] }}</span>
                            <svg class="w-3 h-3 opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Account -->
            <div class="space-y-6 pt-6 border-t border-white/5">
                <div class="text-[9px] font-black uppercase tracking-[0.5em] text-accent-500/60 pb-3 border-b border-white/5">Account</div>
                @auth
                    <div class="space-y-4">
                        <a href="{{ route('profile.edit') }}" class="block text-xs font-black uppercase tracking-wider text-white hover:text-accent-500 transition-colors">
                            {{ Auth::user()->name }}
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block text-[10px] font-bold text-white/50 uppercase tracking-widest hover:text-accent-500 transition-colors">Superadmin Panel</a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="block text-[10px] font-bold text-white/50 uppercase tracking-widest hover:text-accent-500 transition-colors">My Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block text-[10px] font-bold text-red-500/80 uppercase tracking-widest hover:text-red-400 transition-colors">
                                Log Out
                            </button>
                        </form>
                    </div>
                @else
                    <div class="grid gap-4">
                        <a href="{{ route('login') }}" class="px-5 py-3 bg-white/10 border border-white/20 text-white font-black uppercase tracking-widest text-center rounded-2xl hover:bg-white/20 transition-all text-[10px]">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-3 bg-accent-600 text-white font-black uppercase tracking-widest text-center rounded-2xl hover:bg-accent-700 transition-all shadow-xl shadow-accent-600/20 text-[10px]">Sign Up</a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>

        <!-- Drawer Footer -->
        <div class="p-8 border-t border-white/5 bg-black/20">
            <p class="text-[10px] font-medium text-white/30 tracking-widest uppercase">© {{ date('Y') }} HAVEN ARCHITECTURE</p>
        </div>
    </div>
</nav>
