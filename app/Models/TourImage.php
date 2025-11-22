<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'image_path',
        'thumbnail_path',
        'caption',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Belongs to tour
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    // Scope for featured image
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope for ordered images
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}