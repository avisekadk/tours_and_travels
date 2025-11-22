<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'banner_image',
        'latitude',
        'longitude',
        'featured',
        'status',
        'weather_city',
        'best_season',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'status' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Automatically create slug from name
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($destination) {
            if (empty($destination->slug)) {
                $destination->slug = Str::slug($destination->name);
            }
        });
    }

    // Get all tours in this destination
    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    // Get only active destinations
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Get only featured destinations
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}