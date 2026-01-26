<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Property;
use Illuminate\Support\Str;

class PopulatePropertySlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:populate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate slug field for existing properties';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $properties = Property::whereNull('slug')->get();
        
        if ($properties->isEmpty()) {
            $this->info('All properties already have slugs.');
            return;
        }
        
        $this->info("Populating slugs for {$properties->count()} properties...");
        
        foreach ($properties as $property) {
            $slug = Str::slug($property->title);
            $originalSlug = $slug;
            $counter = 1;
            
            // Ensure unique slug
            while (Property::where('slug', $slug)->where('id', '!=', $property->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $property->update(['slug' => $slug]);
            $this->line("Updated: {$property->title} -> {$slug}");
        }
        
        $this->info('Slug population completed!');
    }
}
