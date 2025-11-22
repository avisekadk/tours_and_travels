<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'author_id',
        'category_id',
        'tags',
        'views',
        'published_at',
        'status',
        'reading_time',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'tags' => 'array',
        'views' => 'integer',
        'published_at' => 'datetime',
        'reading_time' => 'integer',
    ];

    // Automatically create slug from title
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            // Calculate reading time (average 200 words per minute)
            if (empty($blog->reading_time) && !empty($blog->content)) {
                $wordCount = str_word_count(strip_tags($blog->content));
                $blog->reading_time = ceil($wordCount / 200);
            }
        });
    }

    // Belongs to author (user)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Belongs to category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }
}   