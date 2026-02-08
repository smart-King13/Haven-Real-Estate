@extends('layouts.app')

@section('title', 'Finalize Your Haven - Checkout')

@section('content')
<!-- Hero Section with Dark Background -->
<div class="relative min-h-screen bg-primary-950 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-950 via-primary-900 to-primary-950"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-[0.02] select-none pointer-events-none">
            <span class="text-[200px] md:text-[300px] lg:text-[400px] font-black leading-none tracking-tighter text-white">HAVEN</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 pt-24 md:pt-32 pb-8 md:pb-20">
        <div class="max-w-[1600px] mx-auto px-4 md:px-6 lg:px-12">
            <!-- Back Navigation -->
            <div class="mb-8 md:mb-12 animate-reveal">
                <a href="{{ route('properties.show', $property->slug) }}" 
                   class="inline-flex items-center text-white/60 hover:text-accent-400 transition-all duration-300 group">
                    <svg class="w-4 h-4 mr-2 md:mr-3 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em]">Return to Property</span>
                </a>
            </div>

            <!-- Page Header -->
            <div class="mb-12 md:mb-20 animate-reveal [animation-delay:0.2s]">
                <div class="inline-flex items-center gap-3 md:gap-4 mb-6 md:mb-8">
                    <div class="w-8 md:w-12 h-[2px] bg-accent-500"></div>
                    <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[9px] md:text-[10px]">Secure Transaction</span>
                </div>
                <h1 class="text-4xl md:text-6xl lg:text-8xl font-black text-white leading-[0.9] tracking-tighter mb-4 md:mb-6">
                    <span class="text-accent-500">Finalize</span> <br>
                    Your Haven.
                </h1>
                <p class="text-base md:text-xl text-gray-300 font-light leading-relaxed max-w-2xl border-l-2 border-accent-500/50 pl-4 md:pl-8">
                    Complete your {{ $property->type === 'sale' ? 'property acquisition' : 'rental agreement' }} with our secure, encrypted payment system.
                </p>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16 items-start animate-reveal [animation-delay:0.4s]">
                <!-- Left Side: Payment Selection -->
                <div class="lg:col-span-7 space-y-8 lg:space-y-12">
                    <!-- Payment Form -->
                    <form action="{{ route('properties.pay.process', $property->slug) }}" method="POST" 
                          class="space-y-8 lg:space-y-12" x-data="checkoutForm()">
                        @csrf
                        
                        <!-- Step 1: Transaction Type -->
                        <div class="glass-premium-dark rounded-[20px] lg:rounded-[40px] p-6 lg:p-10 exceptional-shadow">
                            <h3 class="text-lg lg:text-2xl font-black font-heading text-white mb-6 lg:mb-10 flex items-center gap-3 lg:gap-4">
                                <span class="w-8 h-8 lg:w-12 lg:h-12 rounded-[10px] lg:rounded-[20px] bg-accent-600 text-white flex items-center justify-center text-xs lg:text-sm font-black">1</span>
                                <span class="text-[10px] lg:text-[11px] font-black uppercase tracking-[0.3em]">Select Transaction Type</span>
                            </h3>

                            <div class="space-y-4 lg:space-y-6">
                                @if($property->type === 'sale')
                                <!-- Purchase Options -->
                                <label class="block group cursor-pointer">
                                    <input type="radio" name="transaction_type" value="purchase" x-model="transactionType" class="peer sr-only" {{ $property->type === 'sale' ? 'checked' : '' }}>
                                    <div class="flex items-center p-4 lg:p-8 rounded-[15px] lg:rounded-[30px] border border-white/10 peer-checked:border-accent-500 peer-checked:bg-accent-500/10 transition-all hover:border-white/20 group-hover:bg-white/5">
                                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-[10px] lg:rounded-[20px] bg-green-500/20 flex items-center justify-center mr-4 lg:mr-6 shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="block text-base lg:text-xl font-black text-white mb-1 lg:mb-2">Full Purchase</span>
                                            <span class="block text-sm text-white/60 font-light">Complete ownership transfer - {{ format_naira($totalAmount) }}</span>
                                        </div>
                                        <div class="w-5 h-5 lg:w-6 lg:h-6 rounded-full border-2 border-white/20 flex items-center justify-center shrink-0 peer-checked:border-accent-500 peer-checked:bg-accent-500 transition-all">
                                            <svg class="w-2.5 h-2.5 lg:w-3 lg:h-3 text-white transition-opacity peer-checked:opacity-100 opacity-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>

                                <label class="block group cursor-pointer">
                                    <input type="radio" name="transaction_type" value="deposit" x-model="transactionType" class="peer sr-only">
                                    <div class="flex items-center p-4 lg:p-8 rounded-[15px] lg:rounded-[30px] border border-white/10 peer-checked:border-accent-500 peer-checked:bg-accent-500/10 transition-all hover:border-white/20 group-hover:bg-white/5">
                                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-[10px] lg:rounded-[20px] bg-blue-500/20 flex items-center justify-center mr-4 lg:mr-6 shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="block text-base lg:text-xl font-black text-white mb-1 lg:mb-2">Security Deposit (10%)</span>
                                            <span class="block text-sm text-white/60 font-light">Reserve property - {{ format_naira($property->price * 0.1) }}</span>
                                        </div>
                                        <div class="w-5 h-5 lg:w-6 lg:h-6 rounded-full border-2 border-white/20 peer-checked:border-accent-500 peer-checked:bg-accent-500 transition-all flex items-center justify-center shrink-0">
                                            <svg class="w-2.5 h-2.5 lg:w-3 lg:h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                                @else
                                <!-- Rental Options -->
                                <label class="block group cursor-pointer">
                                    <input type="radio" name="transaction_type" value="rent_payment" x-model="transactionType" class="peer sr-only" {{ $property->type === 'rent' ? 'checked' : '' }}>
                                    <div class="flex items-center p-4 lg:p-8 rounded-[15px] lg:rounded-[30px] border border-white/10 peer-checked:border-accent-500 peer-checked:bg-accent-500/10 transition-all hover:border-white/20 group-hover:bg-white/5">
                                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-[10px] lg:rounded-[20px] bg-purple-500/20 flex items-center justify-center mr-4 lg:mr-6 shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="block text-base lg:text-xl font-black text-white mb-1 lg:mb-2">Monthly Rent</span>
                                            <span class="block text-sm text-white/60 font-light">First month + fees - {{ format_naira($property->price + 250 + 150) }}</span>
                                        </div>
                                        <div class="w-5 h-5 lg:w-6 lg:h-6 rounded-full border-2 border-white/20 peer-checked:border-accent-500 peer-checked:bg-accent-500 transition-all flex items-center justify-center shrink-0">
                                            <svg class="w-2.5 h-2.5 lg:w-3 lg:h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                                @endif

                                <!-- Inspection Fee (Available for both) -->
                                <label class="block group cursor-pointer">
                                    <input type="radio" name="transaction_type" value="inspection_fee" x-model="transactionType" class="peer sr-only">
                                    <div class="flex items-center p-4 lg:p-8 rounded-[15px] lg:rounded-[30px] border border-white/10 peer-checked:border-accent-500 peer-checked:bg-accent-500/10 transition-all hover:border-white/20 group-hover:bg-white/5">
                                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-[10px] lg:rounded-[20px] bg-orange-500/20 flex items-center justify-center mr-4 lg:mr-6 shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="block text-base lg:text-xl font-black text-white mb-1 lg:mb-2">Property Inspection</span>
                                            <span class="block text-sm text-white/60 font-light">Professional inspection - ₦500</span>
                                        </div>
                                        <div class="w-5 h-5 lg:w-6 lg:h-6 rounded-full border-2 border-white/20 peer-checked:border-accent-500 peer-checked:bg-accent-500 transition-all flex items-center justify-center shrink-0">
                                            <svg class="w-2.5 h-2.5 lg:w-3 lg:h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Step 2: Payment Method -->
                        <div class="glass-premium-dark rounded-[20px] lg:rounded-[40px] p-6 lg:p-10 exceptional-shadow" x-show="transactionType" x-transition>
                            <h3 class="text-lg lg:text-2xl font-black font-heading text-white mb-6 lg:mb-10 flex items-center gap-3 lg:gap-4">
                                <span class="w-8 h-8 lg:w-12 lg:h-12 rounded-[10px] lg:rounded-[20px] bg-accent-600 text-white flex items-center justify-center text-xs lg:text-sm font-black">2</span>
                                <span class="text-[10px] lg:text-[11px] font-black uppercase tracking-[0.3em]">Select Payment Method</span>
                            </h3>

                            <div class="space-y-4 lg:space-y-6">
                                <label class="block group cursor-pointer">
                                    <input type="radio" name="payment_method" value="stripe" checked class="peer sr-only">
                                    <div class="flex items-center p-4 lg:p-8 rounded-[15px] lg:rounded-[30px] border border-white/10 peer-checked:border-accent-500 peer-checked:bg-accent-500/10 transition-all hover:border-white/20 group-hover:bg-white/5">
                                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-[10px] lg:rounded-[20px] bg-white/10 flex items-center justify-center mr-4 lg:mr-6 shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="block text-base lg:text-xl font-black text-white mb-1 lg:mb-2">Credit / Debit Card</span>
                                            <span class="block text-sm text-white/60 font-light">Instant processing via Stripe</span>
                                        </div>
                                        <div class="w-5 h-5 lg:w-6 lg:h-6 rounded-full border-2 border-white/20 peer-checked:border-accent-500 peer-checked:bg-accent-500 transition-all flex items-center justify-center shrink-0">
                                            <svg class="w-2.5 h-2.5 lg:w-3 lg:h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>

                                <label class="block group cursor-pointer">
                                    <input type="radio" name="payment_method" value="paystack" class="peer sr-only" x-model="paymentMethod">
                                    <div class="flex items-center p-4 lg:p-8 rounded-[15px] lg:rounded-[30px] border border-white/10 peer-checked:border-accent-500 peer-checked:bg-accent-500/10 transition-all hover:border-white/20 group-hover:bg-white/5">
                                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-[10px] lg:rounded-[20px] bg-white/10 flex items-center justify-center mr-4 lg:mr-6 shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <span class="block text-base lg:text-xl font-black text-white mb-1 lg:mb-2">Bank Transfer</span>
                                            <span class="block text-sm text-white/60 font-light">Secure bank processing via Paystack (NGN)</span>
                                        </div>
                                        <div class="w-5 h-5 lg:w-6 lg:h-6 rounded-full border-2 border-white/20 peer-checked:border-accent-500 peer-checked:bg-accent-500 transition-all flex items-center justify-center shrink-0">
                                            <svg class="w-2.5 h-2.5 lg:w-3 lg:h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Currency Conversion Notice for PayStack -->
                        <div x-show="isPaystackSelected()" x-transition class="bg-blue-500/10 border border-blue-500/20 rounded-[15px] lg:rounded-[20px] p-4 lg:p-6">
                            <div class="flex items-start gap-3 lg:gap-4">
                                <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-blue-500/20 flex items-center justify-center shrink-0 mt-1">
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm lg:text-base font-bold text-blue-400 mb-1 lg:mb-2">Currency Conversion & Test Mode Notice</h4>
                                    <p class="text-xs lg:text-sm text-white/70 leading-relaxed mb-2">
                                        PayStack processes payments in Nigerian Naira (₦). Your USD amount will be automatically converted to NGN at the current exchange rate during checkout.
                                    </p>
                                    <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-3 mt-2">
                                        <p class="text-xs text-blue-300 font-medium flex items-center gap-2">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                            </svg>
                                            <strong>Currency Conversion:</strong> The final amount in Nigerian Naira (₦) will be displayed on the PayStack payment page before you confirm.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div x-show="transactionType" x-transition class="text-center">
                            <button type="submit" 
                                    class="w-full lg:w-auto px-12 lg:px-16 py-5 lg:py-7 bg-accent-600 text-white font-black uppercase tracking-[0.3em] rounded-full hover:bg-white hover:text-primary-950 transition-all duration-500 shadow-2xl transform hover:-translate-y-1 text-sm group">
                                <span x-text="getButtonText()"></span>
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 ml-2 lg:ml-3 inline group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </button>
                            
                            <!-- Security Notice -->
                            <div class="flex items-center justify-center gap-2 lg:gap-3 text-white/40 font-light mt-6 lg:mt-8">
                                <svg class="w-3 h-3 lg:w-4 lg:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span class="text-[9px] lg:text-[10px] font-black uppercase tracking-[0.3em]">Secured by Haven Encryption Systems</span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right Side: Transaction Summary -->
                <div class="lg:col-span-5">
                    <div class="glass-premium rounded-[20px] lg:rounded-[40px] p-6 lg:p-10 exceptional-shadow sticky top-24 lg:top-32">
                        <!-- Invoice Header -->
                        <div class="flex items-center justify-between mb-8 lg:mb-10 pb-6 lg:pb-8 border-b border-white/10">
                            <div>
                                <span class="text-accent-400 font-bold uppercase tracking-[0.4em] text-[9px] lg:text-[10px] mb-2 block">Transaction Summary</span>
                                <div class="text-white/40 font-mono text-xs">ID: #TRX-{{ strtoupper($property->slug) }}-{{ now()->format('Ymd') }}</div>
                            </div>
                            <div class="p-2 lg:p-3 bg-white/5 rounded-[15px] lg:rounded-[20px] border border-white/5">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Property Asset -->
                        <div class="flex gap-4 lg:gap-6 mb-8 lg:mb-10 bg-white/5 p-4 lg:p-6 rounded-[15px] lg:rounded-[30px] border border-white/5">
                            <div class="w-16 h-16 lg:w-20 lg:h-20 rounded-[10px] lg:rounded-[20px] overflow-hidden shadow-lg flex-shrink-0 bg-primary-900">
                                @if($property->primaryImage)
                                    <img src="{{ asset('storage/' . $property->primaryImage->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 flex flex-col justify-center">
                                <div class="inline-flex self-start px-2 lg:px-3 py-1 rounded-full bg-accent-500/20 text-xs font-black uppercase tracking-wider mb-2 text-accent-400 border border-accent-500/30">
                                    {{ $property->category->name }}
                                </div>
                                <h4 class="text-base lg:text-lg font-black font-heading leading-tight text-white mb-2 line-clamp-2">{{ $property->title }}</h4>
                                <p class="text-sm text-white/60 flex items-center font-light">
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 mr-1 lg:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $property->location }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Dynamic Line Items -->
                        <div class="space-y-4 lg:space-y-6 mb-8 lg:mb-10 text-sm lg:text-base" id="line-items">
                            @if($property->type === 'sale')
                            <!-- Purchase Line Items -->
                            <div class="flex justify-between items-center text-white/60">
                                <span class="decoration-white/20 underline decoration-dashed underline-offset-4 font-light">Property Value</span>
                                <span class="text-white font-black font-mono">{{ format_naira($basePrice) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-white/60">
                                <span class="decoration-white/20 underline decoration-dashed underline-offset-4 font-light">Acquisition Fee</span>
                                <span class="text-white font-black font-mono">{{ format_naira($acquisitionFee) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-white/60">
                                <span class="decoration-white/20 underline decoration-dashed underline-offset-4 font-light">Legal & Escrow</span>
                                <span class="text-white font-black font-mono">{{ format_naira($legalFee) }}</span>
                            </div>
                            @else
                            <!-- Rental Line Items -->
                            <div class="flex justify-between items-center text-white/60">
                                <span class="decoration-white/20 underline decoration-dashed underline-offset-4 font-light">Monthly Rent</span>
                                <span class="text-white font-black font-mono">{{ format_naira($basePrice) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-white/60">
                                <span class="decoration-white/20 underline decoration-dashed underline-offset-4 font-light">Processing Fee</span>
                                <span class="text-white font-black font-mono">{{ format_naira($acquisitionFee) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-white/60">
                                <span class="decoration-white/20 underline decoration-dashed underline-offset-4 font-light">Admin Fee</span>
                                <span class="text-white font-black font-mono">{{ format_naira($legalFee) }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Total -->
                        <div class="pt-6 lg:pt-8 border-t-2 border-dashed border-white/20">
                            <div class="flex justify-between items-end">
                                <div>
                                    <div class="text-[9px] lg:text-[10px] font-black uppercase tracking-[0.3em] text-accent-400 mb-2 lg:mb-3 flex items-center gap-2 lg:gap-3">
                                        Total Due
                                        <span class="text-xs text-white/30">NGN</span>
                                    </div>
                                    <div class="text-2xl lg:text-4xl font-black font-heading text-white tracking-tight" id="total-amount">
                                        {{ format_naira($totalAmount) }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[9px] lg:text-[10px] text-green-400 bg-green-400/20 px-2 lg:px-3 py-1 lg:py-2 rounded-full font-black uppercase tracking-wide border border-green-400/30">Secure Encryption</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Trust Badge -->
                    <div class="mt-6 lg:mt-10 flex justify-center gap-4 lg:gap-6 text-white/20 grayscale opacity-30">
                        <div class="h-4 w-8 lg:h-6 lg:w-12 bg-current rounded-[8px] lg:rounded-[10px]"></div>
                        <div class="h-4 w-8 lg:h-6 lg:w-12 bg-current rounded-[8px] lg:rounded-[10px]"></div>
                        <div class="h-4 w-8 lg:h-6 lg:w-12 bg-current rounded-[8px] lg:rounded-[10px]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function checkoutForm() {
    return {
        transactionType: '',
        paymentMethod: '',
        
        init() {
            // Set default selection based on property type
            this.transactionType = '{{ $property->type === "sale" ? "purchase" : "rent_payment" }}';
        },
        
        getButtonText() {
            const texts = {
                'purchase': 'Complete Purchase',
                'rent_payment': 'Secure Rental',
                'deposit': 'Pay Deposit',
                'inspection_fee': 'Schedule Inspection'
            };
            return texts[this.transactionType] || 'Proceed to Payment';
        },
        
        isPaystackSelected() {
            return this.paymentMethod === 'paystack';
        }
    }
}
</script>
@endpush
@endsection
