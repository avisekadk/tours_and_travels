<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\Category;
use App\Models\Review;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured tours (limit 6)
        $featuredTours = Tour::with(['category', 'destination'])
            ->where('featured', true)
            ->where('status', 'published')
            ->limit(6)
            ->get();

        // Get featured destinations (limit 4)
        $featuredDestinations = Destination::where('featured', true)
            ->where('status', true)
            ->limit(4)
            ->get();

        // Get all categories
        $categories = Category::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // Get recent blogs (limit 3)
        $recentBlogs = Blog::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get recent reviews (limit 6)
        $recentReviews = Review::with(['user', 'tour'])
            ->where('approved', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get statistics
        $totalTours = Tour::where('status', 'published')->count();
        $totalDestinations = Destination::where('status', true)->count();
        $totalReviews = Review::where('approved', true)->count();
        $happyTravelers = 5000; // You can calculate this from bookings

        return view('frontend.home.index', compact(
            'featuredTours',
            'featuredDestinations',
            'categories',
            'recentBlogs',
            'recentReviews',
            'totalTours',
            'totalDestinations',
            'totalReviews',
            'happyTravelers'
        ));
    }
}