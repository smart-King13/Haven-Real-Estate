@extends('layouts.app')

@section('title', 'Forgot Password - Haven')

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-primary-950 px-6 py-32">
    <!-- Midnight Architectural Background -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="Luxury Architecture at Dusk" 
             class="w-full h-full object-cover opacity-50 transform scale-110 animate-slow-zoom">
        <div class="absolute inset-0 bg-gradient-to-b from-primary-950 via-primary-950/40 to-primary-950"></div>
    </div>

    <!-- Balanced Midnight Card -->
    <div class="relative z-10 w-full max-w-[420px] animate-reveal">
        <div class="bg-primary-950/80 backdrop-blur-3xl rounded-[40px] p-8 lg:p-10 shadow-[0_40px_100px_rgba(0,0,0,0.8)] border border-white/10">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-white rounded-2xl mb-6 shadow-2xl rotate-3">
                    <span class="text-primary-950 font-black text-2xl">H</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tighter mb-2">Forgot Password?</h1>
                <p class="text-white/40 text-xs font-semibold tracking-wide">No worries, we'll send you reset instructions</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-green-400 text-sm font-medium">{{ session('success') }}</p>
                            <p class="text-green-400/60 text-xs mt-1">Check your email and follow the instructions</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div>
                            @foreach($errors->all() as $error)
                                <p class="text-red-400 text-sm font-medium">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="space-y-2">
                    <label for="email" class="text-[9px] font-black uppercase tracking-[0.2em] text-white ml-1">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="block w-full px-6 h-14 bg-white border-transparent rounded-2xl text-primary-950 placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-300 text-sm shadow-xl font-bold" 
                           placeholder="your@email.com" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-[10px] text-red-400 font-bold ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full h-14 bg-accent-600 text-white font-black uppercase tracking-[0.3em] text-[10px] rounded-2xl hover:bg-accent-500 transition-all duration-500 shadow-xl transform hover:-translate-y-1 mt-6">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-white/5 text-center">
                <p class="text-[11px] text-white/40 font-medium">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="font-bold text-white hover:text-accent-500 underline underline-offset-4 transition-all ml-1">
                        Back to Login
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
