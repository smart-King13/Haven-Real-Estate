<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SupabaseService;
use Illuminate\Support\Facades\Storage;

class CleanupProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:cleanup {--all : Delete all properties} {--api-only : Delete only API-added properties}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up properties from the database';

    protected $supabase;

    /**
     * Create a new command instance.
     */
    public function __construct(SupabaseService $supabase)
    {
        parent::__construct();
        $this->supabase = $supabase;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('all') && !$this->option('api-only')) {
            $this->error('Please specify either --all or --api-only option');
            $this->info('Usage:');
            $this->info('  php artisan properties:cleanup --all          (Delete ALL properties)');
            $this->info('  php artisan properties:cleanup --api-only     (Delete only API-added properties)');
            return 1;
        }

        if ($this->option('all')) {
            if (!$this->confirm('Are you sure you want to delete ALL properties? This cannot be undone!')) {
                $this->info('Operation cancelled.');
                return 0;
            }
            return $this->deleteAllProperties();
        }

        if ($this->option('api-only')) {
            $this->info('This will attempt to delete properties that might have been added via API.');
            $this->info('Note: There is no definitive way to identify API-added properties.');
            
            if (!$this->confirm('Do you want to continue?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
            return $this->deleteApiProperties();
        }

        return 0;
    }

    /**
     * Delete all properties
     */
    protected function deleteAllProperties()
    {
        $this->info('Fetching all properties...');
        
        try {
            $propertiesResponse = $this->supabase->select('properties', '*');
            $properties = $propertiesResponse->data ?? [];
            
            if (empty($properties)) {
                $this->info('No properties found.');
                return 0;
            }

            $count = count($properties);
            $this->info("Found {$count} properties to delete.");

            $bar = $this->output->createProgressBar($count);
            $bar->start();

            $deleted = 0;
            $failed = 0;

            foreach ($properties as $property) {
                $prop = is_array($property) ? (object)$property : $property;
                
                try {
                    $this->deletePropertyAndRelated($prop->id);
                    $deleted++;
                } catch (\Exception $e) {
                    $this->error("\nFailed to delete property {$prop->id}: " . $e->getMessage());
                    $failed++;
                }
                
                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);
            $this->info("Deleted: {$deleted} properties");
            if ($failed > 0) {
                $this->warn("Failed: {$failed} properties");
            }
            $this->info('Cleanup completed!');

            return 0;

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Delete API-added properties (heuristic approach)
     */
    protected function deleteApiProperties()
    {
        $this->info('Fetching properties...');
        
        try {
            $propertiesResponse = $this->supabase->select('properties', '*');
            $properties = $propertiesResponse->data ?? [];
            
            if (empty($properties)) {
                $this->info('No properties found.');
                return 0;
            }

            // Show all properties and let user select which ones to delete
            $this->info('Available properties:');
            $this->table(
                ['ID', 'Title', 'Location', 'Price', 'Created At'],
                collect($properties)->map(function($property) {
                    $prop = is_array($property) ? (object)$property : $property;
                    return [
                        $prop->id ?? 'N/A',
                        substr($prop->title ?? 'N/A', 0, 40),
                        $prop->location ?? 'N/A',
                        '₦' . number_format($prop->price ?? 0),
                        isset($prop->created_at) ? date('Y-m-d H:i', strtotime($prop->created_at)) : 'N/A'
                    ];
                })->toArray()
            );

            $this->newLine();
            $this->warn('Review the properties above.');
            
            if ($this->confirm('Do you want to delete ALL properties shown above?')) {
                return $this->deleteAllProperties();
            }

            $this->info('Operation cancelled. Use --all flag to delete all properties.');
            return 0;

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Delete a property and all its related data
     */
    protected function deletePropertyAndRelated($propertyId)
    {
        // Delete saved properties (use service key to bypass RLS)
        try {
            $this->supabase->delete('saved_properties', ['property_id' => $propertyId], true);
        } catch (\Exception $e) {
            // Ignore if no saved properties
        }

        // Delete payments (use service key to bypass RLS)
        try {
            $this->supabase->delete('payments', ['property_id' => $propertyId], true);
        } catch (\Exception $e) {
            // Ignore if no payments
        }

        // Delete property images
        $imagesResponse = $this->supabase->select('property_images', '*', [
            'property_id' => $propertyId
        ]);
        $images = $imagesResponse->data ?? [];

        foreach ($images as $image) {
            $img = is_array($image) ? (object)$image : $image;
            if (isset($img->image_path) && Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        // Delete image records (use service key to bypass RLS)
        try {
            $this->supabase->delete('property_images', ['property_id' => $propertyId], true);
        } catch (\Exception $e) {
            // Ignore if no images
        }

        // Delete the property (use service key to bypass RLS)
        $this->supabase->delete('properties', ['id' => $propertyId], true);
    }
}
