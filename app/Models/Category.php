<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Automatically create slug from name
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Get all tours in this category
    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    // Get all blogs in this category
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    // Get only active categories
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Order by sort_order
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}