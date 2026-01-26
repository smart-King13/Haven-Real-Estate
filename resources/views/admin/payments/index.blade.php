@extends('layouts.admin')

@section('title', 'Payment Management - Admin')
@section('page-title', 'Payment Management')

@section('content')
    <!-- Premium Header Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-8 py-16">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1 space-y-2">
                    <h1 class="text-3xl font-semibold text-white font-heading tracking-tight underline decoration-purple-500/30 decoration-8 underline-offset-4">
                        Financial Ledger
                    </h1>
                    <p class="text-lg text-primary-100/80 font-normal">
                        Audit revenue, monitor transactions, and manage platform cash flow.
                    </p>
                </div>
            </div>
        </div>
    </div>

<!-- Filters Section -->
<div class="bg-white shadow-xl shadow-gray-200/60 rounded-3xl p-8 border border-gray-50 mb-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 font-heading tracking-tight uppercase">Audit <span class="text-purple-600">Trail</span> Filters</h2>
    </div>
    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 relative z-10">
        <div>
            <x-select 
                name="status" 
                label="Status" 
                height="h-10"
                :value="request('status')"
                :options="[
                    ['value' => '', 'label' => 'All Status'],
                    ['value' => 'completed', 'label' => 'Completed'],
                    ['value' => 'pending', 'label' => 'Pending'],
                    ['value' => 'failed', 'label' => 'Failed'],
                    ['value' => 'cancelled', 'label' => 'Cancelled']
                ]"
            />
        </div>
        <div>
            <x-select 
                name="payment_method" 
                label="Payment Method" 
                height="h-10"
                :value="request('payment_method')"
                :options="[
                    ['value' => '', 'label' => 'All Methods'],
                    ['value' => 'stripe', 'label' => 'Stripe'],
                    ['value' => 'paystack', 'label' => 'Paystack'],
                    ['value' => 'paypal', 'label' => 'PayPal']
                ]"
            />
        </div>
        <div>
            <label class="field-label">From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" 
                   class="input-field">
        </div>
        <div>
            <label class="field-label">To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" 
                   class="input-field">
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-primary w-full">
                Apply Filters
            </button>
        </div>
    </form>
</div>

<!-- Premium Analytics Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
    <!-- Total Revenue -->
    <div class="group relative bg-gradient-to-br from-primary-900 to-primary-800 rounded-3xl p-8 shadow-xl shadow-primary-900/20 overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative flex flex-col h-full">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-white/10 rounded-xl backdrop-blur-md border border-white/20 text-white mb-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                </svg>
            </div>
            <h3 class="text-xs font-semibold text-primary-200/60 uppercase tracking-widest">Total Revenue</h3>
            <p class="mt-2 text-3xl font-semibold text-white font-heading tabular-nums">${{ number_format($payments->where('status', 'completed')->sum('amount')) }}</p>
        </div>
    </div>

    <!-- Total Transactions -->
    <div class="group relative bg-white rounded-3xl p-8 shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gray-50 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-50 rounded-xl text-gray-500 group-hover:bg-primary-900 group-hover:text-white transition-all duration-300 mb-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Total Payments</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-900 font-heading tabular-nums">{{ $payments->count() }}</p>
        </div>
    </div>

    <!-- Pending Queue -->
    <div class="group relative bg-white rounded-3xl p-8 shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
        <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-50 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-yellow-50 rounded-xl text-yellow-600 group-hover:bg-yellow-600 group-hover:text-white transition-all duration-300 mb-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Pending Verification</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-900 font-heading tabular-nums">{{ $payments->where('status', 'pending')->count() }}</p>
        </div>
    </div>

    <!-- Failed Audit -->
    <div class="group relative bg-white rounded-3xl p-8 shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
        <div class="absolute top-0 right-0 w-24 h-24 bg-red-50 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-red-50 rounded-xl text-red-600 group-hover:bg-red-600 group-hover:text-white transition-all duration-300 mb-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Failed Transactions</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-900 font-heading tabular-nums">{{ $payments->where('status', 'failed')->count() }}</p>
        </div>
    </div>
</div>

<!-- Payments Table Section -->
<div class="bg-white shadow-2xl shadow-gray-200/60 rounded-3xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Transaction Ref</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">User Details</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Linked Property</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Amount</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Method</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Timestamp</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($payments as $payment)
                <tr class="group border-b border-gray-50 hover:bg-gray-50/50 transition-all duration-200">
                    <td class="px-8 py-6">
                        <div class="text-sm font-medium text-gray-900">{{ $payment->transaction_id }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ ucfirst($payment->type) }}</div>
                    </td>
                    <td class="px-6 py-6">
                        <div class="text-sm font-medium text-gray-900">{{ $payment->user->name }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ $payment->user->email }}</div>
                    </td>
                    <td class="px-6 py-6">
                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($payment->property->title, 30) }}</div>
                        <div class="text-sm text-gray-600 mt-1">${{ number_format($payment->property->price) }}</div>
                    </td>
                    <td class="px-6 py-6">
                        <div class="text-sm font-medium text-gray-900">${{ number_format($payment->amount) }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ $payment->currency }}</div>
                    </td>
                    <td class="px-6 py-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                            {{ ucfirst($payment->payment_method) }}
                        </span>
                    </td>
                    <td class="px-6 py-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium border
                            {{ $payment->status === 'completed' ? 'bg-green-50 text-green-700 border-green-200' : 
                               ($payment->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : 
                               ($payment->status === 'failed' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-gray-100 text-gray-800 border-gray-200')) }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-6 text-sm text-gray-600">
                        <div class="font-medium">{{ $payment->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $payment->created_at->format('h:i A') }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No payments found</h3>
                            <p class="text-gray-600 max-w-sm">No payments match your current filters. Try adjusting your search criteria.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($payments->hasPages())
    <div class="bg-gray-50/50 px-8 py-5 border-t border-gray-100">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection
