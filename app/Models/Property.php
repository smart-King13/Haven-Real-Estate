<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    // Status Constants
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_AVAILABLE = 'available';
    const STATUS_RESERVED = 'reserved';
    const STATUS_SOLD = 'sold';
    const STATUS_RENTED = 'rented';
    const STATUS_ARCHIVED = 'archived';
    const STATUS_PENDING = 'pending';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'location',
        'address',
        'latitude',
        'longitude',
        'type',
        'status',
        'bedrooms',
        'bathrooms',
        'area',
        'property_type',
        'features',
        'category_id',
        'user_id',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'area' => 'decimal:2',
            'features' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Generate a unique slug for the property
     */
    public function generateSlug()
    {
        $slug = Str::slug($this->title);
        $originalSlug = $slug;
        $counter = 1;
        
        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($property) {
            if (empty($property->slug)) {
                $property->slug = $property->generateSlug();
            }
        });
        
        static::updating(function ($property) {
            if ($property->isDirty('title') && empty($property->slug)) {
                $property->slug = $property->generateSlug();
            }
        });
    }

    /**
     * Property belongs to a category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Property belongs to a user (owner/admin)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Property has many images
     */
    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    /**
     * Primary image
     */
    public function primaryImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_primary', true);
    }

    /**
     * Property has many payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Users who saved this property
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_properties');
    }

    /**
     * Check if property is saved by a specific user
     */
    public function isSavedByUser($userId)
    {
        if (!$userId) {
            return false;
        }
        
        // If the relationship is already loaded, use it to avoid additional queries
        if ($this->relationLoaded('savedByUsers')) {
            return $this->savedByUsers->contains('id', $userId);
        }
        
        // Otherwise, query the database
        return $this->savedByUsers()->where('user_id', $userId)->exists();
    }

    /**
     * Scope for published and available properties (Public View)
     */
    public function scopePublishedAndAvailable($query)
    {
        return $query->where(function ($q) {
            $q->where('status', self::STATUS_PUBLISHED)
              ->orWhere('status', self::STATUS_AVAILABLE);
        });
    }

    /**
     * Scope for active properties
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->whereNotIn('status', [self::STATUS_DRAFT, self::STATUS_ARCHIVED]);
    }

    /**
     * Scope for available properties
     */
    public function scopeAvailable($query)
    {
        return $query->where(function ($q) {
            $q->where('status', self::STATUS_AVAILABLE)
              ->orWhere('status', self::STATUS_PUBLISHED);
        });
    }

    /**
     * Scope for featured properties
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for property type (rent/sale)
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for price range
     */
    public function scopePriceRange($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('price', '>=', $min);
        }
        if ($max) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    /**
     * Scope for location search
     */
    public function scopeLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%")
                    ->orWhere('address', 'like', "%{$location}%");
    }

    /**
     * Scope for keyword search
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('location', 'like', "%{$keyword}%")
              ->orWhere('property_type', 'like', "%{$keyword}%");
        });
    }
}