@extends('layouts.user')

@section('title', 'Dashboard - Haven')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="space-y-4 sm:space-y-6 lg:space-y-8">
    <!-- Premium Welcome Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 sm:gap-6 lg:gap-8">
                <div class="flex-1 space-y-1 sm:space-y-2">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-semibold text-white font-heading tracking-tight underline decoration-accent-500/30 decoration-4 sm:decoration-6 lg:decoration-8 underline-offset-2 sm:underline-offset-4">
                        Welcome back, {{ $profile->name ?? 'User' }}!
                    </h1>
                    <p class="text-sm sm:text-base lg:text-lg text-primary-100/80 font-normal">
                        Your property journey continues. {{ now()->format('l, F j, Y') }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <a href="{{ route('properties.index') }}" class="inline-flex items-center justify-center px-4 sm:px-6 py-3 sm:py-4 bg-accent-600 hover:bg-accent-500 text-white font-semibold rounded-xl sm:rounded-2xl transition-all duration-300 shadow-xl shadow-accent-600/30 hover:-translate-y-1 text-sm sm:text-base">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-2 sm:mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Properties
                    </a>
                    <a href="{{ route('user.profile.edit') }}" class="inline-flex items-center justify-center px-4 sm:px-6 py-3 sm:py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl sm:rounded-2xl transition-all duration-300 backdrop-blur-md border border-white/20 hover:-translate-y-1 text-sm sm:text-base">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 mr-2 sm:mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="hidden sm:inline">Edit Profile</span>
                        <span class="sm:hidden">Profile</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Premium Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
        <!-- Saved Properties Card -->
        <div class="group relative bg-white rounded-2xl sm:rounded-3xl shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-accent-600/10 transition-all duration-300 overflow-hidden transform hover:-translate-y-1 border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-accent-500/10 to-transparent rounded-full -mr-12 -mt-12 sm:-mr-16 sm:-mt-16 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative p-4 sm:p-6 lg:p-8">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-accent-50 rounded-xl sm:rounded-2xl text-accent-600 group-hover:bg-accent-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 lg:h-7 lg:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-accent-600 bg-accent-50 px-2 sm:px-3 py-1 rounded-full uppercase tracking-wider">Saved</span>
                </div>
                <h3 class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-widest">Saved Properties</h3>
                <p class="mt-1 sm:mt-2 text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-900 font-heading tracking-tight leading-none tabular-nums">{{ $stats['saved_properties_count'] }}</p>
                <div class="mt-4 sm:mt-6 lg:mt-8 border-t border-gray-50 pt-3 sm:pt-4 lg:pt-6">
                    <a href="{{ route('user.saved-properties') }}" class="text-xs sm:text-sm font-semibold text-accent-600 hover:text-accent-700 flex items-center group/link">
                        View all
                        <svg class="ml-1 sm:ml-2 h-3 w-3 sm:h-4 sm:w-4 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Payments Card -->
        <div class="group relative bg-white rounded-2xl sm:rounded-3xl shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-green-600/10 transition-all duration-300 overflow-hidden transform hover:-translate-y-1 border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-green-500/10 to-transparent rounded-full -mr-12 -mt-12 sm:-mr-16 sm:-mt-16 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative p-4 sm:p-6 lg:p-8">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-green-50 rounded-xl sm:rounded-2xl text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 lg:h-7 lg:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 sm:px-3 py-1 rounded-full uppercase tracking-wider">Total</span>
                </div>
                <h3 class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-widest">Total Payments</h3>
                <p class="mt-1 sm:mt-2 text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-900 font-heading tracking-tight leading-none tabular-nums">{{ $stats['payments_count'] }}</p>
                <div class="mt-4 sm:mt-6 lg:mt-8 border-t border-gray-50 pt-3 sm:pt-4 lg:pt-6">
                    <a href="{{ route('user.payment-history') }}" class="text-xs sm:text-sm font-semibold text-green-600 hover:text-green-700 flex items-center group/link">
                        View history
                        <svg class="ml-1 sm:ml-2 h-3 w-3 sm:h-4 sm:w-4 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Completed Payments Card -->
        <div class="group relative bg-white rounded-2xl sm:rounded-3xl shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-purple-600/10 transition-all duration-300 overflow-hidden transform hover:-translate-y-1 border border-gray-100">
            <div class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-purple-500/10 to-transparent rounded-full -mr-12 -mt-12 sm:-mr-16 sm:-mt-16 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative p-4 sm:p-6 lg:p-8">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-purple-50 rounded-xl sm:rounded-2xl text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 lg:h-7 lg:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 sm:px-3 py-1 rounded-full uppercase tracking-wider">Success</span>
                </div>
                <h3 class="text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-widest">Completed</h3>
                <p class="mt-1 sm:mt-2 text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-900 font-heading tracking-tight leading-none tabular-nums">{{ $stats['completed_payments'] }}</p>
                <div class="mt-4 sm:mt-6 lg:mt-8 border-t border-gray-50 pt-3 sm:pt-4 lg:pt-6">
                    <p class="text-xs sm:text-sm text-gray-500">Successful transactions</p>
                </div>
            </div>
        </div>

        <!-- Total Spent Card -->
        <div class="group relative bg-gradient-to-br from-primary-900 via-primary-900 to-primary-800 rounded-2xl sm:rounded-3xl shadow-2xl shadow-primary-900/20 hover:shadow-primary-900/40 transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-32 h-32 sm:w-48 sm:h-48 bg-white/5 rounded-full -mr-16 -mt-16 sm:-mr-24 sm:-mt-24 group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="relative p-4 sm:p-6 lg:p-8 flex flex-col h-full">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-white/10 rounded-xl sm:rounded-2xl backdrop-blur-md border border-white/20 text-white group-hover:bg-white/20 transition-all duration-300">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 lg:h-7 lg:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-white/50 border border-white/10 bg-white/5 px-2 sm:px-3 py-1 rounded-full uppercase tracking-wider">Investment</span>
                </div>
                <h3 class="text-xs sm:text-sm font-semibold text-primary-200/60 uppercase tracking-widest">Total Spent</h3>
                <p class="mt-1 sm:mt-2 text-2xl sm:text-3xl lg:text-4xl font-semibold text-white font-heading tracking-tight leading-none tabular-nums truncate">
                    <span class="text-accent-400">₦</span>{{ number_format($stats['total_spent']) }}
                </p>
                <div class="mt-auto pt-4 sm:pt-6 lg:pt-8">
                    <p class="text-xs font-semibold text-primary-300/50 uppercase tracking-widest">Lifetime Investment</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
        <!-- Recent Saved Properties -->
        <div class="bg-white shadow-xl shadow-gray-200/60 rounded-2xl sm:rounded-3xl overflow-hidden border border-gray-50 flex flex-col">
            <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 font-heading tracking-tight uppercase"><span class="text-accent-600">Saved</span> Properties</h3>
                <a href="{{ route('user.saved-properties') }}" class="text-xs font-semibold text-primary-900/40 hover:text-accent-600 uppercase tracking-widest flex items-center group/all transition-colors">
                    <span class="hidden sm:inline">View all favorites</span>
                    <span class="sm:hidden">View all</span>
                    <svg class="ml-1 sm:ml-2 h-3 w-3 sm:h-4 sm:w-4 group-hover/all:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            <div class="flex-1">
                @if(isset($recentSavedProperties) && count($recentSavedProperties) > 0)
                    <div class="divide-y divide-gray-50">
                        @foreach($recentSavedProperties as $property)
                        <div class="group px-4 sm:px-6 lg:px-8 py-4 sm:py-6 hover:bg-gray-50/50 transition-all duration-200 flex items-center gap-3 sm:gap-4 lg:gap-6">
                            <div class="relative shrink-0">
                                @if($property->primaryImage)
                                    <img class="h-12 w-12 sm:h-16 sm:w-16 lg:h-20 lg:w-20 rounded-xl sm:rounded-2xl object-cover ring-2 sm:ring-4 ring-gray-50 shadow-lg group-hover:ring-accent-500 group-hover:shadow-accent-500/10 transition-all" src="{{ asset('storage/' . $property->primaryImage->image_path) }}" alt="{{ $property->title }}">
                                @else
                                    <div class="h-12 w-12 sm:h-16 sm:w-16 lg:h-20 lg:w-20 rounded-xl sm:rounded-2xl bg-gray-100 flex items-center justify-center ring-2 sm:ring-4 ring-gray-50 text-gray-400 group-hover:bg-accent-50 group-hover:text-accent-500 transition-all">
                                        <svg class="h-5 w-5 sm:h-6 sm:w-6 lg:h-8 lg:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute -top-1 -right-1 sm:-top-2 sm:-right-2 px-1.5 sm:px-2 py-0.5 bg-accent-600 text-[9px] sm:text-[10px] font-semibold text-white rounded-md sm:rounded-lg shadow-lg uppercase tracking-tight">Saved</div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('properties.show', $property->slug) }}" class="block text-sm sm:text-base lg:text-lg font-semibold text-gray-900 group-hover:text-accent-600 transition-colors truncate">
                                    {{ $property->title }}
                                </a>
                                <div class="flex items-center gap-2 sm:gap-3 mt-1 text-xs sm:text-sm text-gray-500 font-medium">
                                    <span class="flex items-center truncate">
                                        <svg class="h-3 w-3 sm:h-4 sm:w-4 mr-1 sm:mr-1.5 text-accent-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        <span class="truncate">{{ $property->location }}</span>
                                    </span>
                                    <span class="text-gray-300 hidden sm:inline">•</span>
                                    <span class="font-semibold text-primary-900 shrink-0">{{ format_naira($property->price) }}</span>
                                </div>
                            </div>
                            <div class="hidden md:flex flex-col items-end gap-1 sm:gap-2 shrink-0">
                                <p class="text-[9px] sm:text-[10px] font-semibold text-gray-400 uppercase tracking-widest text-right">Type</p>
                                <span class="text-xs sm:text-sm font-medium text-gray-900 truncate max-w-20 sm:max-w-none">{{ ucfirst($property->type) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 sm:py-16 lg:py-20 text-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 sm:mb-6">
                            <svg class="h-8 w-8 sm:h-10 sm:w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-400 uppercase tracking-widest">No saved properties</h3>
                        <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-500">Start browsing to save your favorites.</p>
                        <div class="mt-4 sm:mt-6">
                            <a href="{{ route('properties.index') }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-accent-600 hover:bg-accent-500 text-white font-semibold rounded-xl transition-all shadow-lg text-sm sm:text-base">
                                Browse Properties
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="bg-white shadow-xl shadow-gray-200/60 rounded-2xl sm:rounded-3xl overflow-hidden border border-gray-50 flex flex-col">
            <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 font-heading tracking-tight uppercase"><span class="text-green-600">Recent</span> Payments</h3>
                <a href="{{ route('user.payment-history') }}" class="text-xs font-semibold text-primary-900/40 hover:text-green-600 uppercase tracking-widest flex items-center group/all transition-colors">
                    <span class="hidden sm:inline">View history</span>
                    <span class="sm:hidden">View all</span>
                    <svg class="ml-1 sm:ml-2 h-3 w-3 sm:h-4 sm:w-4 group-hover/all:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            <div class="flex-1">
                @if(isset($recentPayments) && count($recentPayments) > 0)
                    <div class="divide-y divide-gray-50">
                        @foreach($recentPayments as $payment)
                        <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 hover:bg-gray-50/50 transition-all duration-200 flex items-center justify-between">
                            <div class="flex-1 min-w-0 pr-3 sm:pr-4">
                                <p class="text-sm sm:text-base lg:text-lg font-semibold text-gray-900 truncate">
                                    {{ $payment->property->title }}
                                </p>
                                <div class="flex items-center gap-2 sm:gap-3 mt-1">
                                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">{{ $payment->created_at->format('M d, Y') }}</p>
                                    <span class="text-gray-300 hidden sm:inline">•</span>
                                    <p class="text-xs sm:text-sm text-gray-600 capitalize shrink-0">{{ $payment->type }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 sm:gap-3 shrink-0">
                                <p class="text-lg sm:text-xl font-semibold text-gray-900 font-heading leading-none tabular-nums">
                                    <span class="text-green-600">₦</span>{{ number_format($payment->amount) }}
                                </p>
                                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-md sm:rounded-lg text-[9px] sm:text-[10px] font-semibold uppercase tracking-widest
                                    {{ $payment->status === 'completed' ? 'bg-green-100 text-green-700 shadow-sm shadow-green-500/5' : 
                                       ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-700 shadow-sm shadow-yellow-500/5' : 'bg-red-100 text-red-700 shadow-sm shadow-red-500/5') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 sm:py-16 lg:py-20 text-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 sm:mb-6 text-gray-300">
                            <svg class="h-8 w-8 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-400 uppercase tracking-widest">No payments yet</h3>
                        <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-500">Your payment history will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- User Quick Actions Power-Grid -->
    <div class="bg-white shadow-2xl shadow-gray-200/60 rounded-2xl sm:rounded-3xl overflow-hidden border border-gray-100">
        <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 border-b border-gray-50 bg-gray-50/20">
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 font-heading tracking-tight uppercase">User <span class="text-accent-600">Quick</span> Actions</h3>
        </div>
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-5 lg:gap-8">
                <a href="{{ route('properties.index') }}" class="group relative p-4 sm:p-6 lg:p-8 bg-white rounded-2xl sm:rounded-3xl border-2 border-gray-50 hover:border-accent-600 hover:shadow-2xl hover:shadow-accent-600/10 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-accent-50 rounded-xl sm:rounded-2xl text-accent-600 group-hover:bg-accent-600 group-hover:text-white transition-all duration-300 mb-4 sm:mb-6 shadow-xl shadow-accent-600/5 group-hover:scale-110">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 font-heading tracking-tight uppercase">Browse Properties</h4>
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-bold text-gray-400">Discover new properties and opportunities.</p>
                </a>

                <a href="{{ route('user.saved-properties') }}" class="group relative p-4 sm:p-6 lg:p-8 bg-white rounded-2xl sm:rounded-3xl border-2 border-gray-50 hover:border-red-600 hover:shadow-2xl hover:shadow-red-600/10 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-red-50 rounded-xl sm:rounded-2xl text-red-600 group-hover:bg-red-600 group-hover:text-white transition-all duration-300 mb-4 sm:mb-6 shadow-xl shadow-red-600/5 group-hover:scale-110">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </div>
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 font-heading tracking-tight uppercase">Saved Properties</h4>
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-bold text-gray-400">View your favorite properties collection.</p>
                </a>

                <a href="{{ route('user.payment-history') }}" class="group relative p-4 sm:p-6 lg:p-8 bg-white rounded-2xl sm:rounded-3xl border-2 border-gray-50 hover:border-green-600 hover:shadow-2xl hover:shadow-green-600/10 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-green-50 rounded-xl sm:rounded-2xl text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all duration-300 mb-4 sm:mb-6 shadow-xl shadow-green-600/5 group-hover:scale-110">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 font-heading tracking-tight uppercase">Payment History</h4>
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-bold text-gray-400">Track your transactions and payments.</p>
                </a>

                <a href="{{ route('user.messages') }}" class="group relative p-4 sm:p-6 lg:p-8 bg-white rounded-2xl sm:rounded-3xl border-2 border-gray-50 hover:border-blue-600 hover:shadow-2xl hover:shadow-blue-600/10 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-blue-50 rounded-xl sm:rounded-2xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 mb-4 sm:mb-6 shadow-xl shadow-blue-600/5 group-hover:scale-110">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 font-heading tracking-tight uppercase">Messages</h4>
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-bold text-gray-400">Chat with Haven support team.</p>
                </a>

                <a href="{{ route('user.profile.edit') }}" class="group relative p-4 sm:p-6 lg:p-8 bg-white rounded-2xl sm:rounded-3xl border-2 border-gray-50 hover:border-purple-600 hover:shadow-2xl hover:shadow-purple-600/10 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-purple-50 rounded-xl sm:rounded-2xl text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 mb-4 sm:mb-6 shadow-xl shadow-purple-600/5 group-hover:scale-110">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 font-heading tracking-tight uppercase">Edit Profile</h4>
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-semibold text-gray-400">Update your account information.</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
