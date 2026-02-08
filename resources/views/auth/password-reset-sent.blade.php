@extends('layouts.app')

@section('title', 'Check Your Email - Haven')

@php
    $hideNavbar = true;
@endphp

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-primary-950 px-6 py-32">
    <!-- Midnight Architectural Background -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="Luxury Architecture at Dusk" 
             class="w-full h-full object-cover opacity-50 transform scale-110 animate-slow-zoom">
        <div class="absolute inset-0 bg-gradient-to-b from-primary-950 via-primary-950/40 to-primary-950"></div>
    </div>

    <!-- Success Card -->
    <div class="relative z-10 w-full max-w-[500px] animate-reveal">
        <div class="bg-primary-950/80 backdrop-blur-3xl rounded-[40px] p-8 lg:p-12 shadow-[0_40px_100px_rgba(0,0,0,0.8)] border border-white/10">
            
            <!-- Success Icon -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-500 rounded-full mb-6 shadow-2xl animate-pulse">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-black text-white tracking-tighter mb-3">
                    @if(session('resent'))
                        Email Sent Again!
                    @else
                        Check Your Email
                    @endif
                </h1>
                <p class="text-white/60 text-sm font-medium">
                    @if(session('resent'))
                        We've sent another password reset email
                    @else
                        We've sent password reset instructions
                    @endif
                </p>
            </div>

            <!-- Email Info -->
            <div class="bg-white/5 rounded-2xl p-6 border border-white/10 mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-accent-600 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-white font-bold text-lg mb-2">Email Sent Successfully</h3>
                        <p class="text-white/70 text-sm leading-relaxed mb-3">
                            We've sent a password reset link to:
                        </p>
                        <div class="bg-primary-950/50 rounded-lg px-4 py-3 border border-white/5">
                            <p class="text-accent-400 font-mono text-sm break-all">{{ session('email', 'your email address') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="space-y-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-accent-600/20 rounded-full flex items-center justify-center shrink-0 mt-1">
                        <span class="text-accent-400 font-black text-sm">1</span>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-1">Check your inbox</h4>
                        <p class="text-white/60 text-sm">Look for an email from Haven Real Estate with the subject "Reset Your Haven Password"</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-accent-600/20 rounded-full flex items-center justify-center shrink-0 mt-1">
                        <span class="text-accent-400 font-black text-sm">2</span>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-1">Click the reset link</h4>
                        <p class="text-white/60 text-sm">Click the "Reset Password" button in the email to create your new password</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-accent-600/20 rounded-full flex items-center justify-center shrink-0 mt-1">
                        <span class="text-accent-400 font-black text-sm">3</span>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-1">Create new password</h4>
                        <p class="text-white/60 text-sm">Choose a strong password and you'll be automatically signed in</p>
                    </div>
                </div>
            </div>

            <!-- Important Notes -->
            <div class="bg-gray-800/40 border border-gray-600/50 rounded-2xl p-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-gray-300 font-bold text-base mb-3">Important Information</h4>
                        <div class="space-y-2">
                            <div class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 bg-gray-400 rounded-full mt-2 shrink-0"></div>
                                <p class="text-gray-400 text-sm font-medium">The reset link expires in <span class="font-bold text-gray-200">60 minutes</span> for security</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 bg-gray-400 rounded-full mt-2 shrink-0"></div>
                                <p class="text-gray-400 text-sm font-medium">Check your <span class="font-bold text-gray-200">spam/junk folder</span> if you don't see the email</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 bg-gray-400 rounded-full mt-2 shrink-0"></div>
                                <p class="text-gray-400 text-sm font-medium">The link can only be used <span class="font-bold text-gray-200">once</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <form method="POST" action="{{ route('password.email') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}">
                        <button type="submit" class="w-full h-12 bg-accent-600 text-white font-bold uppercase tracking-[0.2em] text-xs rounded-2xl hover:bg-accent-500 transition-all duration-300 shadow-xl">
                            Resend Email
                        </button>
                    </form>
                    <a href="{{ route('login') }}" class="flex-1 h-12 bg-white/10 text-white font-bold uppercase tracking-[0.2em] text-xs rounded-2xl hover:bg-white/20 transition-all duration-300 border border-white/20 flex items-center justify-center">
                        Back to Login
                    </a>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 pt-8 border-t border-white/10 text-center">
                <p class="text-white/40 text-xs mb-4">Still having trouble?</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}" class="text-accent-400 hover:text-accent-300 text-xs font-semibold uppercase tracking-wider transition-colors">
                        Contact Support
                    </a>
                    <span class="hidden sm:block text-white/20">•</span>
                    <a href="{{ route('home') }}" class="text-accent-400 hover:text-accent-300 text-xs font-semibold uppercase tracking-wider transition-colors">
                        Return Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-refresh functionality for resend button
let resendCount = 0;
const maxResends = 3;

function resendEmail() {
    if (resendCount >= maxResends) {
        alert('Maximum resend attempts reached. Please contact support if you continue to have issues.');
        return;
    }
    
    resendCount++;
    const button = event.target;
    const originalText = button.textContent;
    
    button.textContent = 'Sending...';
    button.disabled = true;
    
    // Simulate resend (you can make an actual AJAX call here)
    setTimeout(() => {
        button.textContent = 'Email Sent!';
        setTimeout(() => {
            button.textContent = originalText;
            button.disabled = false;
        }, 2000);
    }, 1500);
}
</script>
@endsection
