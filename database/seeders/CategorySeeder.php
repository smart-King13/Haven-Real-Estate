<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Residential',
                'slug' => 'residential',
                'description' => 'Houses, apartments, and other residential properties',
            ],
            [
                'name' => 'Commercial',
                'slug' => 'commercial',
                'description' => 'Office buildings, retail spaces, and commercial properties',
            ],
            [
                'name' => 'Industrial',
                'slug' => 'industrial',
                'description' => 'Warehouses, factories, and industrial properties',
            ],
            [
                'name' => 'Land',
                'slug' => 'land',
                'description' => 'Vacant land and development opportunities',
            ],
            [
                'name' => 'Luxury',
                'slug' => 'luxury',
                'description' => 'High-end luxury properties and estates',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}