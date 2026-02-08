@extends('layouts.admin')

@section('title', 'Add Property - Admin')
@section('page-title', 'Add New Property')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 leading-tight">Add New Property</h1>
        <p class="text-gray-600 mt-2 leading-relaxed">Create a new property listing for your portfolio</p>
    </div>

    <div class="card">
        <div class="border-b border-gray-200 pb-6 mb-6">
            <h2 class="text-lg font-medium text-gray-900">Property Information</h2>
            <p class="text-sm text-gray-600 mt-1">Fill in the details for the new property listing</p>
        </div>
        
        <form method="POST" action="{{ route('admin.properties.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="title" class="field-label required">Property Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="input-field @error('title') error @enderror">
                    @error('title')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="price" class="field-label required">Price</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="0.01"
                           class="input-field @error('price') error @enderror">
                    @error('price')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="description" class="field-label required">Description</label>
                <textarea name="description" id="description" rows="4" required
                          class="textarea-field @error('description') error @enderror">{{ old('description') }}</textarea>
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
                        <input type="text" name="location" id="location" value="{{ old('location') }}" required
                               class="input-field @error('location') error @enderror">
                        @error('location')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="address" class="field-label">Full Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}"
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
                            :value="old('type')"
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
                            :value="old('status', 'available')"
                            :options="[
                                ['value' => 'available', 'label' => 'Available'],
                                ['value' => 'pending', 'label' => 'Pending'],
                                ['value' => 'sold', 'label' => 'Sold'],
                                ['value' => 'rented', 'label' => 'Rented']
                            ]"
                        />
                        @error('status')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <?php
                            $categoryOptions = [];
                            foreach ($categories as $category) {
                                $cat = is_array($category) ? (object)$category : $category;
                                $categoryOptions[] = [
                                    'value' => (string)($cat->id ?? ''),
                                    'label' => $cat->name ?? ''
                                ];
                            }
                        ?>
                        <x-select 
                            name="category_id" 
                            label="Category" 
                            placeholder="Select Category"
                            height="h-10"
                            :value="old('category_id')"
                            :options="$categoryOptions"
                        />
                        @error('category_id')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="property_type" class="field-label">Property Type</label>
                        <input type="text" name="property_type" id="property_type" value="{{ old('property_type') }}"
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
                        <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms') }}" min="0"
                               class="input-field @error('bedrooms') error @enderror">
                        @error('bedrooms')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="bathrooms" class="field-label">Bathrooms</label>
                        <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms') }}" min="0"
                               class="input-field @error('bathrooms') error @enderror">
                        @error('bathrooms')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="area" class="field-label">Area (sq ft)</label>
                        <input type="number" name="area" id="area" value="{{ old('area') }}" min="0" step="0.01"
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
                        $oldFeatures = old('features', []);
                    @endphp
                    @foreach($availableFeatures as $key => $label)
                    <div class="flex items-center">
                        <input type="checkbox" name="features[]" value="{{ $key }}" id="feature_{{ $key }}"
                               {{ in_array($key, $oldFeatures) ? 'checked' : '' }}
                               class="checkbox-field">
                        <label for="feature_{{ $key }}" class="ml-3 text-sm text-gray-900">{{ $label }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Images -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Property Images</h3>
                <div class="border-2 border-dashed border-gray-200 rounded-md p-8 text-center hover:border-gray-300 transition-colors">
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                           class="file-input">
                    <p class="mt-2 text-sm text-gray-600">Upload multiple images. The first image will be set as the primary image.</p>
                </div>
                @error('images')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Options -->
            <div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="checkbox-field">
                    <label for="is_featured" class="ml-3 text-sm text-gray-900">Mark as Featured Property</label>
                </div>
                <p class="mt-1 text-xs text-gray-600">Featured properties will be highlighted on the homepage</p>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.properties.index') }}" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    Create Property
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
