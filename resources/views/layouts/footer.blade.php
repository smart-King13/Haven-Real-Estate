<footer class="bg-primary-950 text-white relative overflow-hidden py-32">
    <!-- Sophisticated Watermark -->
    <div class="absolute bottom-0 right-0 opacity-[0.02] select-none pointer-events-none translate-y-1/4 translate-x-1/4">
        <span class="text-[400px] font-black leading-none tracking-tighter text-white">HAVEN</span>
    </div>

    <div class="max-w-[1600px] mx-auto px-6 lg:px-12 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-24 lg:gap-32">
            <!-- Column 1: Brand Architecture -->
            <div class="md:col-span-4 space-y-12">
                <a href="{{ route('home') }}" class="flex items-center gap-4 group">
                    <div class="w-12 h-12 flex items-center justify-center rounded-2xl group-hover:scale-110 transition-all duration-500 overflow-hidden">
                        @if(file_exists(public_path('images/haven-logo.png')))
                            <img src="{{ asset('images/haven-logo.png') }}" alt="Haven Logo" class="w-12 h-12 object-contain rounded-xl">
                        @else
                            <div class="w-12 h-12 bg-accent-600 rounded-2xl shadow-2xl flex items-center justify-center">
                                <span class="text-white font-black text-2xl">H</span>
                            </div>
                        @endif
                    </div>
                    <span class="text-xl font-black uppercase tracking-[0.5em] text-white">Haven</span>
                </a>
                <p class="text-gray-400 font-light leading-relaxed text-lg max-w-sm">
                    Redefining the standard of architectural excellence and luxury living through curated global portfolios.
                </p>
                <!-- Social Architecture -->
                <div class="flex items-center gap-6 pt-4">
                    <a href="{{ env('FACEBOOK_URL', 'https://facebook.com') }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-accent-500 transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="{{ env('TWITTER_URL', 'https://twitter.com') }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-accent-500 transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="{{ env('LINKEDIN_URL', 'https://linkedin.com') }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-accent-500 transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="{{ env('INSTAGRAM_URL', 'https://instagram.com') }}" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-accent-500 transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Column 2: Navigation (High-Spaced) -->
            <div class="md:col-span-2 space-y-10">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-accent-500">Navigation</h4>
                <ul class="space-y-6">
                    @foreach(['Home' => 'home', 'Portfolio' => 'properties.index', 'Journal' => null, 'About' => null] as $label => $route)
                        <li>
                            <a href="{{ $route ? route($route) : '#' }}" class="text-[11px] font-bold uppercase tracking-[0.3em] text-gray-400 hover:text-white transition-colors">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Column 3: Contact (Geometric) -->
            <div class="md:col-span-3 space-y-10">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-accent-500">Contact</h4>
                <ul class="space-y-8">
                    <li class="space-y-2">
                        <span class="block text-[9px] font-black uppercase tracking-[0.3em] text-gray-600">Headquarters</span>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 leading-relaxed">
                            ADEBOLA STREET, OFF ADENIRAN<br>OGUNSANYA ROAD, SURULERE<br>LAGOS STATE, NIGERIA
                        </p>
                    </li>
                    <li class="space-y-2">
                        <span class="block text-[9px] font-black uppercase tracking-[0.3em] text-gray-600">Inquiries</span>
                        <a href="mailto:{{ env('CONTACT_EMAIL', 'info@haven.com') }}" class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-accent-500 transition-colors">
                            {{ strtoupper(env('CONTACT_EMAIL', 'info@haven.com')) }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 4: Status / Legacy -->
            <div class="md:col-span-3 space-y-10">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-accent-500">Recognition</h4>
                <div class="space-y-8">
                    <div class="border-l border-white/10 pl-8 space-y-3">
                        <?php
                            $propertyCount = \Illuminate\Support\Facades\Cache::remember('property_count', 300, function() {
                                try {
                                    $supabase = app(\App\Services\SupabaseService::class);
                                    return $supabase->count('properties');
                                } catch (\Exception $e) {
                                    return 0;
                                }
                            });
                        ?>
                        <div class="text-2xl font-black text-white">{{ $propertyCount }}<span class="text-accent-500">+</span></div>
                        <div class="text-[9px] font-bold uppercase tracking-[0.3em] text-gray-500">Properties Listed</div>
                    </div>
                    <div class="border-l border-white/10 pl-8 space-y-3">
                        <div class="text-2xl font-black text-white">{{ date('Y') }}</div>
                        <div class="text-[9px] font-bold uppercase tracking-[0.3em] text-gray-500">Established</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom: Legal & Copyright (Minimalist) -->
        <div class="mt-40 pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-12 text-[9px] font-black uppercase tracking-[0.4em] text-gray-600">
            <div>© {{ date('Y') }} HAVEN ARCHITECTURE. ALL RIGHTS RESERVED.</div>
            <div class="flex items-center gap-12">
                <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacy</a>
                <a href="{{ route('terms') }}" class="hover:text-white transition-colors">Terms</a>
                <a href="#" class="hover:text-white transition-colors">Cookies</a>
            </div>
        </div>
    </div>
</footer>
