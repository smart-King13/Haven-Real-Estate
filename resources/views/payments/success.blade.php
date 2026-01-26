@extends('layouts.app')

@section('title', 'Transaction Complete - Haven')

@section('content')
<div class="min-h-screen bg-gray-50/50 pt-24 lg:pt-32 pb-12 lg:pb-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-12">
        <!-- Success Header -->
        <div class="text-center mb-12 animate-reveal">
            <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl shadow-green-500/30 animate-bounce">
                <svg class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-4xl lg:text-5xl font-black font-heading text-primary-950 mb-4 tracking-tight">
                {{ $payment->type === 'purchase' ? 'Purchase Complete!' : 
                   ($payment->type === 'rent_payment' ? 'Rental Secured!' : 
                   ($payment->type === 'deposit' ? 'Deposit Received!' : 'Payment Successful!')) }}
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Your transaction has been processed securely. 
                {{ $payment->type === 'purchase' ? 'Congratulations on your new property!' : 
                   ($payment->type === 'rent_payment' ? 'Your rental is now confirmed.' : 
                   ($payment->type === 'deposit' ? 'Your property has been reserved.' : 'Thank you for your payment.')) }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Transaction Details -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 animate-reveal [animation-delay:0.1s]">
                <h2 class="text-xl font-bold font-heading text-primary-950 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-accent-600 text-white flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    Transaction Details
                </h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-50">
                        <span class="text-gray-600 font-medium">Transaction ID</span>
                        <span class="font-mono font-bold text-primary-950">{{ $payment->transaction_id }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-50">
                        <span class="text-gray-600 font-medium">Payment Method</span>
                        <span class="font-bold text-primary-950 capitalize">{{ str_replace('_', ' ', $payment->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-50">
                        <span class="text-gray-600 font-medium">Transaction Type</span>
                        <span class="font-bold text-primary-950 capitalize">{{ str_replace('_', ' ', $payment->type) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-50">
                        <span class="text-gray-600 font-medium">Date & Time</span>
                        <span class="font-bold text-primary-950">{{ $payment->paid_at->format('M d, Y \a\t g:i A') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-gray-600 font-medium">Amount Paid</span>
                        <div class="text-right">
                            @if($payment->payment_method === 'paystack' && isset($payment->gateway_response['currency_conversion']))
                                @php
                                    $conversion = $payment->gateway_response['currency_conversion'];
                                    $processedAmount = $payment->gateway_response['processed_amount_ngn'] ?? $conversion['converted_amount'];
                                @endphp
                                <div class="font-bold text-green-600 text-xl">₦{{ number_format($processedAmount, 2) }}</div>
                                <div class="text-sm text-gray-500">
                                    (${{{ number_format($conversion['original_amount'], 2) }} USD @ ₦{{ number_format($conversion['exchange_rate'], 2) }})
                                </div>
                                @if(isset($conversion['test_mode_amount']) && $conversion['test_mode_amount'])
                                    <div class="text-xs text-yellow-600 mt-1 font-medium">
                                        Test Mode: Limited to ₦2,500
                                    </div>
                                @endif
                            @else
                                <span class="font-bold text-green-600 text-xl">${{ number_format($payment->amount, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="mt-6 p-4 bg-green-50 rounded-xl border border-green-100">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-green-700 font-bold uppercase tracking-wider text-sm">Payment Confirmed</span>
                    </div>
                </div>
            </div>

            <!-- Property Information -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 animate-reveal [animation-delay:0.2s]">
                <h2 class="text-xl font-bold font-heading text-primary-950 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-accent-600 text-white flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    Property Information
                </h2>

                <div class="flex gap-4 mb-6 p-4 bg-gray-50 rounded-xl">
                    <div class="w-20 h-20 rounded-lg overflow-hidden shadow-sm flex-shrink-0 bg-gray-200">
                        @if($payment->property->primaryImage)
                            <img src="{{ asset('storage/' . $payment->property->primaryImage->image_path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="inline-flex px-2 py-1 rounded bg-accent-100 text-accent-700 text-xs font-bold uppercase tracking-wider mb-2">
                            {{ $payment->property->category->name }}
                        </div>
                        <h3 class="text-lg font-bold text-primary-950 leading-tight mb-1">{{ $payment->property->title }}</h3>
                        <p class="text-gray-600 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $payment->property->location }}
                        </p>
                    </div>
                </div>

                <!-- Property Status Update -->
                <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <h4 class="font-bold text-blue-900 mb-2">Property Status Updated</h4>
                    <p class="text-blue-700 text-sm">
                        @if($payment->type === 'purchase')
                            This property is now marked as <strong>SOLD</strong> and has been removed from active listings.
                        @elseif($payment->type === 'rent_payment')
                            This property is now marked as <strong>RENTED</strong> and is no longer available for new rentals.
                        @elseif($payment->type === 'deposit')
                            This property is now marked as <strong>PENDING</strong> with your deposit secured.
                        @else
                            Your inspection has been scheduled. You will receive confirmation details shortly.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="mt-12 bg-primary-950 rounded-2xl text-white p-8 lg:p-12 animate-reveal [animation-delay:0.3s]">
            <h2 class="text-2xl lg:text-3xl font-bold font-heading mb-6">What Happens Next?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="text-center">
                    <div class="w-12 h-12 bg-accent-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold">1</span>
                    </div>
                    <h3 class="font-bold mb-2">Confirmation Email</h3>
                    <p class="text-white/70 text-sm">You'll receive a detailed receipt and next steps via email within 5 minutes.</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-accent-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold">2</span>
                    </div>
                    <h3 class="font-bold mb-2">Agent Contact</h3>
                    <p class="text-white/70 text-sm">Our team will contact you within 24 hours to coordinate next steps.</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-accent-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-bold">3</span>
                    </div>
                    <h3 class="font-bold mb-2">Documentation</h3>
                    <p class="text-white/70 text-sm">All legal documents and contracts will be prepared and sent for your review.</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('user.dashboard') }}" class="px-8 py-4 bg-accent-600 text-white font-bold uppercase tracking-wider rounded-xl hover:bg-accent-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-center">
                    View Dashboard
                </a>
                <a href="{{ route('properties.index') }}" class="px-8 py-4 bg-white/10 text-white font-bold uppercase tracking-wider rounded-xl hover:bg-white/20 transition-all border border-white/20 text-center">
                    Browse More Properties
                </a>
                <a href="{{ route('home') }}" class="px-8 py-4 bg-transparent text-white font-bold uppercase tracking-wider rounded-xl hover:bg-white/10 transition-all border border-white/30 text-center">
                    Return Home
                </a>
            </div>
        </div>

        <!-- Support Section -->
        <div class="mt-8 text-center animate-reveal [animation-delay:0.4s]">
            <p class="text-gray-600 mb-4">Need help or have questions about your transaction?</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:support@haven.com" class="inline-flex items-center text-accent-600 hover:text-accent-700 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email Support
                </a>
                <a href="tel:+1-555-HAVEN" class="inline-flex items-center text-accent-600 hover:text-accent-700 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Call Support
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
