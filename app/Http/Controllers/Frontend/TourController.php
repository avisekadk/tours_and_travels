<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

class TourController extends Controller
{
    // Show all tours with filters
    public function index(Request $request)
    {
        $query = Tour::with(['category', 'destination'])
            ->where('status', 'published');

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by destination
        if ($request->has('destination') && $request->destination != '') {
            $query->where('destination_id', $request->destination);
        }

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty != '') {
            $query->where('difficulty', $request->difficulty);
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Search by keyword
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'featured');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('featured', 'desc')->orderBy('created_at', 'desc');
        }

        // Paginate results
        $tours = $query->paginate(12);

        // Get filter options
        $categories = Category::where('status', true)->get();
        $destinations = Destination::where('status', true)->get();

        return view('frontend.tours.index', compact('tours', 'categories', 'destinations'));
    }

    // Show single tour
    public function show($slug)
    {
        $tour = Tour::with(['category', 'destination', 'reviews.user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $tour->increment('views');

        // Get related tours (same category or destination)
        $relatedTours = Tour::where('status', 'published')
            ->where('id', '!=', $tour->id)
            ->where(function($query) use ($tour) {
                $query->where('category_id', $tour->category_id)
                      ->orWhere('destination_id', $tour->destination_id);
            })
            ->limit(4)
            ->get();

        // Get average rating
        $averageRating = $tour->reviews()->where('approved', true)->avg('rating') ?? 0;
        $totalReviews = $tour->reviews()->where('approved', true)->count();

        return view('frontend.tours.show', compact('tour', 'relatedTours', 'averageRating', 'totalReviews'));
    }
}