@extends('layouts.app')

@section('title', 'Register - Haven')

@php
    $hideNavbar = true;
@endphp

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-primary-950 px-6 py-32">
    <!-- Midnight Architectural Background -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1770&q=80" 
             alt="Midnight Luxury Property" 
             class="w-full h-full object-cover opacity-50 transform scale-110 animate-slow-zoom">
        <div class="absolute inset-0 bg-gradient-to-b from-primary-950 via-primary-950/40 to-primary-950"></div>
    </div>

    <!-- Balanced Midnight Card -->
    <div class="relative z-10 w-full max-w-[580px] animate-reveal">
        <div class="bg-primary-950/80 backdrop-blur-3xl rounded-[40px] p-8 lg:p-10 shadow-[0_40px_100px_rgba(0,0,0,0.8)] border border-white/10">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-14 h-14 mb-6 rotate-3 overflow-hidden rounded-2xl">
                    @if(file_exists(public_path('images/haven-logo.png')))
                        <img src="{{ asset('images/haven-logo.png') }}" alt="Haven Logo" class="w-14 h-14 object-contain">
                    @else
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-2xl flex items-center justify-center">
                            <span class="text-primary-950 font-black text-2xl">H</span>
                        </div>
                    @endif
                </div>
                <h1 class="text-3xl font-black text-white tracking-tighter mb-2">Architectural Entry.</h1>
                <p class="text-white/40 text-xs font-semibold tracking-wide">Join the Exclusive Circle</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label for="name" class="text-[9px] font-black uppercase tracking-[0.2em] text-white ml-1">Full Name</label>
                        <input id="name" name="name" type="text" autocomplete="name" required 
                               class="block w-full px-6 h-14 bg-white border-transparent rounded-2xl text-primary-950 placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-300 text-sm shadow-xl font-bold" 
                               placeholder="Your Full Name" value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-[10px] text-red-400 font-bold ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="text-[9px] font-black uppercase tracking-[0.2em] text-white ml-1">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="block w-full px-6 h-14 bg-white border-transparent rounded-2xl text-primary-950 placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-300 text-sm shadow-xl font-bold" 
                               placeholder="your@email.com" value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-[10px] text-red-400 font-bold ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2" x-data="{ show: false }">
                        <label for="password" class="text-[9px] font-black uppercase tracking-[0.2em] text-white ml-1">Password</label>
                        <div class="relative group/toggle">
                            <input id="password" name="password" :type="show ? 'text' : 'password'" required 
                                   class="block w-full px-6 h-14 bg-white border-transparent rounded-2xl text-primary-950 placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-300 text-sm shadow-xl pr-14 font-bold" 
                                   placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 hover:text-primary-950 hover:bg-gray-100 transition-all">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-2" x-data="{ show: false }">
                        <label for="password_confirmation" class="text-[9px] font-black uppercase tracking-[0.2em] text-white ml-1">Confirm</label>
                        <div class="relative group/toggle">
                            <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" required 
                                   class="block w-full px-6 h-14 bg-white border-transparent rounded-2xl text-primary-950 placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-300 text-sm shadow-xl pr-14 font-bold" 
                                   placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 hover:text-primary-950 hover:bg-gray-100 transition-all">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @error('password')
                    <p class="mt-1 text-[10px] text-red-400 font-bold ml-1">{{ $message }}</p>
                @enderror

                <div class="text-center py-4">
                    <p class="text-[10px] text-white/70 font-medium leading-relaxed max-w-[280px] mx-auto">
                        By entering, you confirm the Haven 
                        <a href="{{ route('terms') }}" class="font-bold text-white hover:text-accent-400 transition-all underline underline-offset-4 decoration-white/20">Terms</a> 
                        and 
                        <a href="{{ route('privacy') }}" class="font-bold text-white hover:text-accent-400 transition-all underline underline-offset-4 decoration-white/20">Privacy Policy</a>
                    </p>
                </div>

                <button type="submit" class="w-full h-14 bg-accent-600 text-white font-black uppercase tracking-[0.3em] text-[10px] rounded-2xl hover:bg-accent-500 transition-all duration-500 shadow-xl transform hover:-translate-y-1">
                    Join The Haven
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-white/5 text-center">
                <p class="text-[11px] text-white/40 font-medium">
                    Already an Investor? 
                    <a href="{{ route('login') }}" class="font-bold text-white hover:text-accent-500 underline underline-offset-4 transition-all ml-1">
                        Sign In
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
@endsection
