<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->index('slug');
        });
        
        // Generate slugs for existing properties
        $properties = \App\Models\Property::all();
        foreach ($properties as $property) {
            $slug = \Illuminate\Support\Str::slug($property->title);
            $originalSlug = $slug;
            $counter = 1;
            
            // Ensure unique slug
            while (\App\Models\Property::where('slug', $slug)->where('id', '!=', $property->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $property->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropColumn('slug');
        });
    }
};
