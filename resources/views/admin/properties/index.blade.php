@extends('layouts.admin')

@section('title', 'Manage Properties - Admin')
@section('page-title', 'Properties Management')

@section('content')
    <!-- Premium Header Banner -->
    <div class="relative bg-gradient-to-r from-primary-900 via-primary-800 to-primary-900 rounded-3xl overflow-hidden shadow-2xl mb-8">
        <div class="absolute inset-0 bg-texture-carbon opacity-10"></div>
        <div class="relative px-8 py-16">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1 space-y-2">
                    <h1 class="text-3xl font-semibold text-white font-heading tracking-tight underline decoration-accent-500/30 decoration-8 underline-offset-4">
                        Properties Inventory
                    </h1>
                    <p class="text-lg text-primary-100/80 font-normal">
                        Manage your global real estate portfolio and listing performance.
                    </p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admin.properties.create') }}" class="btn-primary inline-flex items-center px-6 py-4 rounded-2xl shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Property
                    </a>
                </div>
            </div>
        </div>
    </div>

<!-- Filters Section -->
<div class="bg-white shadow-xl shadow-gray-200/60 rounded-3xl p-8 border border-gray-50 mb-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-accent-50 rounded-xl flex items-center justify-center text-accent-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
            </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 font-heading tracking-tight uppercase">Smart <span class="text-accent-600">Filter</span> Hub</h2>
    </div>
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 relative z-10">
        <div>
            <label class="field-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="input-field" 
                   placeholder="Search properties...">
        </div>
        <div>
            <x-select 
                name="status" 
                label="Status" 
                height="h-10"
                :value="request('status')"
                :options="[
                    ['value' => '', 'label' => 'All Status'],
                    ['value' => 'available', 'label' => 'Available'],
                    ['value' => 'sold', 'label' => 'Sold'],
                    ['value' => 'rented', 'label' => 'Rented'],
                    ['value' => 'pending', 'label' => 'Pending']
                ]"
            />
        </div>
        <div>
            <x-select 
                name="type" 
                label="Type" 
                height="h-10"
                :value="request('type')"
                :options="[
                    ['value' => '', 'label' => 'All Types'],
                    ['value' => 'sale', 'label' => 'For Sale'],
                    ['value' => 'rent', 'label' => 'For Rent']
                ]"
            />
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-primary w-full">
                Apply Filters
            </button>
        </div>
    </form>
</div>

<!-- Properties Table Section -->
<div class="bg-white shadow-2xl shadow-gray-200/60 rounded-3xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Property Details</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Valuation</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Type</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-5 text-left text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Listed On</th>
                    <th class="px-8 py-5 text-right text-xs font-semibold text-primary-900/40 uppercase tracking-widest">Control</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($properties as $property)
                <tr class="group border-b border-gray-50 hover:bg-gray-50/50 transition-all duration-200">
                    <td class="px-8 py-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-14 w-14">
                                @if($property->primaryImage && file_exists(storage_path('app/public/' . $property->primaryImage->image_path)))
                                    <img class="h-14 w-14 rounded-md object-cover border border-gray-200" src="{{ asset('storage/' . $property->primaryImage->image_path) }}" alt="{{ $property->title }}">
                                @else
                                    <div class="h-16 w-16 rounded-2xl bg-gray-100 border-4 border-white shadow-md flex items-center justify-center text-gray-400">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 leading-relaxed">{{ $property->title }}</div>
                                <div class="text-sm text-gray-600 mt-1">{{ $property->location }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $property->category->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-6">
                        <div class="text-sm font-medium text-gray-900">${{ number_format($property->price) }}</div>
                    </td>
                    <td class="px-6 py-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                            {{ ucfirst($property->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium border
                            {{ $property->status === 'available' ? 'bg-green-50 text-green-700 border-green-200' : 
                               ($property->status === 'sold' ? 'bg-red-50 text-red-700 border-red-200' : 
                               ($property->status === 'rented' ? 'bg-teal-50 text-teal-700 border-teal-200' : 'bg-yellow-50 text-yellow-700 border-yellow-200')) }}">
                            {{ ucfirst($property->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-6 text-sm text-gray-600">
                        {{ $property->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('properties.show', $property->slug) }}" target="_blank" 
                               class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-400 hover:text-primary-900 hover:bg-gray-100 transition-all duration-200 border border-transparent hover:border-gray-100"
                               title="View Property">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.properties.edit', $property->id) }}" 
                               class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-400 hover:text-accent-600 hover:bg-accent-50 transition-all duration-200 border border-transparent hover:border-accent-100"
                               title="Edit Property">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.properties.destroy', $property->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this property?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200 border border-transparent hover:border-red-100"
                                        title="Delete Property">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-md flex items-center justify-center mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m2.25-18h15.75m-15.75 0v18m15.75-18v18m-2.25-18h.75a2.25 2.25 0 012.25 2.25v15a2.25 2.25 0 01-2.25 2.25H5.25a2.25 2.25 0 01-2.25-2.25V5.25A2.25 2.25 0 015.25 3h.75z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No properties found</h3>
                            <p class="text-gray-600 mb-6 max-w-sm">Get started by creating your first property listing to begin managing your real estate portfolio.</p>
                            <a href="{{ route('admin.properties.create') }}" class="btn-primary inline-flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Property
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($properties->hasPages())
    <div class="bg-gray-50/50 px-8 py-5 border-t border-gray-100">
        {{ $properties->links() }}
    </div>
    @endif
</div>
@endsection
