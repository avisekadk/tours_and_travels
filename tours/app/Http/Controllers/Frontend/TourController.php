<?php
// app/Http/Controllers/Frontend/TourController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::with(['category', 'destination'])
            ->published();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by destination
        if ($request->has('destination') && $request->destination) {
            $query->whereHas('destination', function ($q) use ($request) {
                $q->where('slug', $request->destination);
            });
        }

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty) {
            $query->where('difficulty', $request->difficulty);
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by duration
        if ($request->has('min_duration') && $request->min_duration) {
            $query->where('duration', '>=', $request->min_duration);
        }
        if ($request->has('max_duration') && $request->max_duration) {
            $query->where('duration', '<=', $request->max_duration);
        }

        // Sorting
        $sortBy = $request->get('sort', 'featured');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'duration':
                $query->orderBy('duration', 'asc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'featured':
            default:
                $query->orderBy('featured', 'desc')->orderBy('created_at', 'desc');
                break;
        }

        $tours = $query->paginate(12);

        // Get filter data
        $categories = Category::active()->ordered()->get();
        $destinations = Destination::active()->get();

        return view('frontend.tours.index', compact('tours', 'categories', 'destinations'));
    }

    public function show($slug)
    {
        $tour = Tour::with(['category', 'destination', 'images', 'reviews' => function ($query) {
            $query->approved()->latest();
        }, 'reviews.user'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views
        $tour->increment('views');

        // Get related tours
        $relatedTours = Tour::with(['category', 'destination'])
            ->published()
            ->where('id', '!=', $tour->id)
            ->where(function ($query) use ($tour) {
                $query->where('category_id', $tour->category_id)
                    ->orWhere('destination_id', $tour->destination_id);
            })
            ->take(4)
            ->get();

        // Check if user has favorited this tour
        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = auth()->user()->favorites()->where('tour_id', $tour->id)->exists();
        }

        return view('frontend.tours.show', compact('tour', 'relatedTours', 'isFavorited'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q');

        $tours = Tour::with(['category', 'destination'])
            ->published()
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('location', 'like', "%{$keyword}%");
            })
            ->paginate(12);

        return view('frontend.tours.search', compact('tours', 'keyword'));
    }
}