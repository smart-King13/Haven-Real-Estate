@extends('layouts.user')

@section('title', 'Payment History - Haven')
@section('page-title', 'Payment History')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-primary-950 uppercase tracking-tighter">Payment History</h1>
                    <p class="text-gray-600 font-light mt-2">View all your transactions and payment records</p>
                </div>
                <a href="{{ route('user.dashboard') }}" class="px-6 py-3 bg-accent-600 text-white font-medium rounded-lg hover:bg-accent-500 transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m0 0l7 7-7 7z"/>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        @if(isset($payments) && count($payments) > 0)
            <!-- Payment History Table -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-black text-primary-950 uppercase tracking-wide">Transaction History</h2>
                    <p class="text-sm text-gray-600 mt-1">All your payment transactions with Haven</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Transaction</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Property</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-accent-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm text-primary-950">#{{ $payment->transaction_id ?? 'TXN-' . $payment->id }}</div>
                                            <div class="text-xs text-gray-500">{{ $payment->payment_method ?? 'Card Payment' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->property)
                                        <div>
                                            <div class="font-medium text-sm text-primary-950">{{ $payment->property->title }}</div>
                                            <div class="text-xs text-gray-500 capitalize">{{ $payment->property->type }}</div>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">Property not available</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full capitalize
                                        @if($payment->transaction_type === 'purchase') bg-blue-100 text-blue-800
                                        @elseif($payment->transaction_type === 'rent') bg-green-100 text-green-800
                                        @elseif($payment->transaction_type === 'deposit') bg-yellow-100 text-yellow-800
                                        @elseif($payment->transaction_type === 'inspection') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $payment->transaction_type ?? 'Payment' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-lg text-primary-950">₦{{ number_format($payment->amount) }}</div>
                                    @if(isset($payment->currency) && $payment->currency && $payment->currency !== 'NGN')
                                        <div class="text-xs text-gray-500">{{ $payment->currency }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($payment->status === 'completed') bg-green-100 text-green-800
                                        @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($payment->status === 'failed') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-primary-950">{{ date('M j, Y', strtotime($payment->created_at)) }}</div>
                                    <div class="text-xs text-gray-500">{{ date('g:i A', strtotime($payment->created_at)) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($payment->status === 'completed')
                                            <button onclick="downloadReceipt({{ $payment->id }})" 
                                                    class="text-accent-600 hover:text-accent-800 transition-colors" 
                                                    title="Download Receipt">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </button>
                                        @endif
                                        @if($payment->property)
                                            <a href="{{ route('properties.show', $payment->property->slug) }}" 
                                               class="text-primary-950 hover:text-accent-600 transition-colors" 
                                               title="View Property">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Spent</p>
                            <p class="text-3xl font-black text-primary-950">₦{{ number_format(collect($payments)->where('status', 'completed')->sum('amount')) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Transactions</p>
                            <p class="text-3xl font-black text-primary-950">{{ count($payments) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Success Rate</p>
                            <p class="text-3xl font-black text-primary-950">{{ count($payments) > 0 ? round((collect($payments)->where('status', 'completed')->count() / count($payments)) * 100) : 0 }}%</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-primary-950 mb-4">No Payment History</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    You haven't made any payments yet. Start exploring our premium properties to begin your real estate journey.
                </p>
                <a href="{{ route('properties.index') }}" class="px-8 py-4 bg-accent-600 text-white font-bold uppercase tracking-wide rounded-full hover:bg-accent-500 transition-colors">
                    Browse Properties
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function downloadReceipt(paymentId) {
    // In a real implementation, this would generate and download a PDF receipt
    alert('Receipt download functionality would be implemented here for payment ID: ' + paymentId);
}
</script>
@endsection
