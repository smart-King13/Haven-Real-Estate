@extends('layouts.admin')

@section('title', 'Edit Property - Admin')
@section('page-title', 'Edit Property')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 leading-tight">Edit Property</h1>
            <p class="text-gray-600 mt-2 leading-relaxed">Update listing details for {{ $property->title }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('properties.show', $property->slug) }}" target="_blank" class="btn-secondary flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Public
            </a>
        </div>
    </div>

    <div class="card">     
        <form method="POST" action="{{ route('admin.properties.update', $property->id) }}" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="title" class="field-label required">Property Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $property->title) }}" required
                           class="input-field @error('title') error @enderror">
                    @error('title')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="price" class="field-label required">Price</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $property->price) }}" required min="0" step="0.01"
                           class="input-field @error('price') error @enderror">
                    @error('price')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="description" class="field-label required">Description</label>
                <textarea name="description" id="description" rows="4" required
                          class="textarea-field @error('description') error @enderror">{{ old('description', $property->description) }}</textarea>
                @error('description')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Location Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Location Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="location" class="field-label required">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $property->location) }}" required
                               class="input-field @error('location') error @enderror">
                        @error('location')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="address" class="field-label">Full Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $property->address) }}"
                               class="input-field @error('address') error @enderror">
                        @error('address')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Property Details -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Property Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <x-select 
                            name="type" 
                            label="Type" 
                            placeholder="Select Type"
                            height="h-10"
                            :value="old('type', $property->type)"
                            :options="[
                                ['value' => 'sale', 'label' => 'For Sale'],
                                ['value' => 'rent', 'label' => 'For Rent']
                            ]"
                        />
                        @error('type')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <x-select 
                            name="status" 
                            label="Status" 
                            height="h-10"
                            :value="old('status', $property->status)"
                            :options="[
                                ['value' => 'draft', 'label' => 'Draft'],
                                ['value' => 'published', 'label' => 'Published'],
                                ['value' => 'available', 'label' => 'Available'],
                                ['value' => 'reserved', 'label' => 'Reserved'],
                                ['value' => 'sold', 'label' => 'Sold'],
                                ['value' => 'rented', 'label' => 'Rented'],
                                ['value' => 'archived', 'label' => 'Archived'],
                                ['value' => 'pending', 'label' => 'Pending']
                            ]"
                        />
                        @error('status')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <x-select 
                            name="category_id" 
                            label="Category" 
                            placeholder="Select Category"
                            height="h-10"
                            :value="old('category_id', $property->category_id)"
                            :options="$categories->map(fn($c) => ['value' => (string)$c->id, 'label' => $c->name])->toArray()"
                        />
                        @error('category_id')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="property_type" class="field-label">Property Type</label>
                        <input type="text" name="property_type" id="property_type" value="{{ old('property_type', $property->property_type) }}"
                               class="input-field @error('property_type') error @enderror"
                               placeholder="e.g., House, Apartment, Condo">
                        @error('property_type')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Property Specifications -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Specifications</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="bedrooms" class="field-label">Bedrooms</label>
                        <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0"
                               class="input-field @error('bedrooms') error @enderror">
                        @error('bedrooms')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="bathrooms" class="field-label">Bathrooms</label>
                        <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0"
                               class="input-field @error('bathrooms') error @enderror">
                        @error('bathrooms')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="area" class="field-label">Area (sq ft)</label>
                        <input type="number" name="area" id="area" value="{{ old('area', $property->area) }}" min="0" step="0.01"
                               class="input-field @error('area') error @enderror">
                        @error('area')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Features -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Property Features</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @php
                        $availableFeatures = [
                            'parking' => 'Parking',
                            'garage' => 'Garage',
                            'garden' => 'Garden',
                            'pool' => 'Swimming Pool',
                            'gym' => 'Gym/Fitness Center',
                            'balcony' => 'Balcony',
                            'terrace' => 'Terrace',
                            'security' => '24/7 Security',
                            'elevator' => 'Elevator',
                            'ac' => 'Air Conditioning',
                            'heating' => 'Central Heating',
                            'wifi' => 'WiFi',
                            'furnished' => 'Furnished',
                            'pet_friendly' => 'Pet Friendly',
                            'wheelchair' => 'Wheelchair Accessible',
                            'laundry' => 'Laundry Room',
                            'dishwasher' => 'Dishwasher',
                            'fireplace' => 'Fireplace',
                            'storage' => 'Storage Room',
                            'concierge' => 'Concierge Service',
                            'doorman' => 'Doorman',
                            'rooftop' => 'Rooftop Access',
                            'playground' => 'Playground',
                            'bbq' => 'BBQ Area',
                            'sauna' => 'Sauna',
                            'spa' => 'Spa',
                            'tennis' => 'Tennis Court',
                            'basketball' => 'Basketball Court',
                            'cinema' => 'Home Theater',
                            'smart_home' => 'Smart Home',
                            'solar' => 'Solar Panels',
                            'ev_charging' => 'EV Charging Station',
                        ];
                        $currentFeatures = old('features', $property->features ?? []);
                    @endphp
                    @foreach($availableFeatures as $key => $label)
                    <div class="flex items-center">
                        <input type="checkbox" name="features[]" value="{{ $key }}" id="feature_{{ $key }}"
                               {{ in_array($key, $currentFeatures) ? 'checked' : '' }}
                               class="checkbox-field">
                        <label for="feature_{{ $key }}" class="ml-3 text-sm text-gray-900">{{ $label }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Options -->
            <div>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $property->is_featured) ? 'checked' : '' }}
                               class="checkbox-field">
                        <label for="is_featured" class="ml-3 text-sm text-gray-900">Mark as Featured</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $property->is_active) ? 'checked' : '' }}
                               class="checkbox-field">
                        <label for="is_active" class="ml-3 text-sm text-gray-900">Is Active</label>
                    </div>
                </div>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.properties.index') }}" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    Update Property
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
