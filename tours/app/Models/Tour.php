<?php
// app/Models/Tour.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tour extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'price_type',
        'duration',
        'duration_type',
        'difficulty',
        'max_people',
        'min_people',
        'location',
        'featured_image',
        'gallery_images',
        'itinerary',
        'inclusions',
        'exclusions',
        'highlights',
        'important_notes',
        'category_id',
        'destination_id',
        'status',
        'views',
        'featured',
        'sort_order',
        'video_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'duration' => 'integer',
        'max_people' => 'integer',
        'min_people' => 'integer',
        'views' => 'integer',
        'featured' => 'boolean',
        'sort_order' => 'integer',
        'gallery_images' => 'array',
        'itinerary' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'highlights' => 'array',
        'important_notes' => 'array',
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tour) {
            if (empty($tour->slug)) {
                $tour->slug = Str::slug($tour->title);
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    // Helper methods
    public function getDisplayPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function hasDiscount()
    {
        return !is_null($this->sale_price) && $this->sale_price < $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->hasDiscount()) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function averageRating()
    {
        return $this->reviews()->where('approved', true)->avg('rating');
    }

    public function reviewCount()
    {
        return $this->reviews()->where('approved', true)->count();
    }
}