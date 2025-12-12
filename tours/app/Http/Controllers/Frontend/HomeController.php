<?php
// app/Http/Controllers/Frontend/HomeController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\Category;
use App\Models\Review;
use App\Models\Blog;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache homepage data for 1 hour
        $featuredTours = Cache::remember('home.featured_tours', 3600, function () {
            return Tour::with(['category', 'destination'])
                ->published()
                ->featured()
                ->take(6)
                ->get();
        });

        $popularTours = Cache::remember('home.popular_tours', 3600, function () {
            return Tour::with(['category', 'destination'])
                ->published()
                ->popular()
                ->take(6)
                ->get();
        });

        $featuredDestinations = Cache::remember('home.featured_destinations', 3600, function () {
            return Destination::active()
                ->featured()
                ->take(4)
                ->get();
        });

        $categories = Cache::remember('home.categories', 3600, function () {
            return Category::active()
                ->ordered()
                ->withCount('tours')
                ->get();
        });

        $testimonials = Cache::remember('home.testimonials', 3600, function () {
            return Review::with(['user', 'tour'])
                ->approved()
                ->where('rating', '>=', 4)
                ->latest()
                ->take(10)
                ->get();
        });

        $latestBlogs = Cache::remember('home.latest_blogs', 3600, function () {
            return Blog::with(['author', 'category'])
                ->published()
                ->latest('published_at')
                ->take(3)
                ->get();
        });

        // Statistics
        $stats = [
            'total_tours' => Tour::published()->count(),
            'happy_travelers' => Review::approved()->count(),
            'destinations' => Destination::active()->count(),
            'years_experience' => 15,
        ];

        return view('frontend.home.index', compact(
            'featuredTours',
            'popularTours',
            'featuredDestinations',
            'categories',
            'testimonials',
            'latestBlogs',
            'stats'
        ));
    }
}