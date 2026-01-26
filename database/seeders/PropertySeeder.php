<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        // Get admin user
        $admin = User::where('role', 'admin')->first();
        
        // Get categories
        $residential = Category::where('slug', 'residential')->first();
        $commercial = Category::where('slug', 'commercial')->first();
        $land = Category::where('slug', 'land')->first();
        
        // Sample properties
        $properties = [
            [
                'title' => 'Luxury Villa with Ocean View',
                'description' => 'Stunning luxury villa featuring panoramic ocean views, infinity pool, and modern architecture. Perfect for those seeking the ultimate coastal lifestyle.',
                'price' => 2500000,
                'location' => 'Malibu, California',
                'address' => '123 Ocean Drive, Malibu, CA 90265',
                'type' => 'sale',
                'status' => 'available',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'area' => 4500,
                'property_type' => 'villa',
                'category_id' => $residential->id,
                'user_id' => $admin->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Modern Downtown Apartment',
                'description' => 'Contemporary apartment in the heart of downtown. Features floor-to-ceiling windows, premium finishes, and access to building amenities.',
                'price' => 3500,
                'location' => 'New York, NY',
                'address' => '456 Park Avenue, New York, NY 10022',
                'type' => 'rent',
                'status' => 'available',
                'bedrooms' => 2,
                'bathrooms' => 2,
                'area' => 1200,
                'property_type' => 'apartment',
                'category_id' => $residential->id,
                'user_id' => $admin->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Prime Commercial Office Space',
                'description' => 'Premium office space in prestigious business district. Ideal for corporate headquarters or professional services.',
                'price' => 15000,
                'location' => 'San Francisco, CA',
                'address' => '789 Market Street, San Francisco, CA 94103',
                'type' => 'rent',
                'status' => 'available',
                'bedrooms' => 0,
                'bathrooms' => 4,
                'area' => 5000,
                'property_type' => 'office',
                'category_id' => $commercial->id,
                'user_id' => $admin->id,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Spacious Family Home',
                'description' => 'Beautiful family home in quiet neighborhood. Large backyard, updated kitchen, and excellent school district.',
                'price' => 850000,
                'location' => 'Austin, Texas',
                'address' => '321 Maple Street, Austin, TX 78701',
                'type' => 'sale',
                'status' => 'available',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 3200,
                'property_type' => 'house',
                'category_id' => $residential->id,
                'user_id' => $admin->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Development Land Opportunity',
                'description' => 'Prime development land with approved zoning for residential or commercial use. Excellent investment opportunity.',
                'price' => 500000,
                'location' => 'Phoenix, Arizona',
                'address' => '555 Desert Road, Phoenix, AZ 85001',
                'type' => 'sale',
                'status' => 'available',
                'bedrooms' => 0,
                'bathrooms' => 0,
                'area' => 10000,
                'property_type' => 'land',
                'category_id' => $land->id,
                'user_id' => $admin->id,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($properties as $propertyData) {
            $propertyData['slug'] = Str::slug($propertyData['title']);
            $propertyData['features'] = json_encode([
                'parking' => true,
                'garden' => true,
                'security' => true,
                'gym' => true,
            ]);
            
            $property = Property::create($propertyData);
            
            // Add a placeholder image if the actual images exist
            $imagePaths = [
                'properties/vSIIO21Tk6d7hFLCGsBvGb47r6kDeK9r1Ql3t4k9.jpg',
                'properties/6syAzXsdKkg7MPnyt0tE9cjbvJ8ZW6cPbgx5KdM7.jpg',
                'properties/BuEyo9htGOMsX1cl2KERhkDAtJx7CWEYj5Gkknv6.jpg',
                'properties/ZhFvp2E6nONEriEUjkDANkMJQHXRALKuukfi3yBi.jpg',
                'properties/kAccxWDwysAK3SRzkUSY3Lnk6Iye8V6Stg1WsgET.jpg',
            ];
            
            // Use existing images if available
            $randomImage = $imagePaths[array_rand($imagePaths)];
            
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $randomImage,
                'alt_text' => $property->title,
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }
    }
}
