<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;

class DestinationController extends Controller
{
    // Show all destinations
    public function index()
    {
        $destinations = Destination::where('status', true)
            ->withCount('tours')
            ->orderBy('featured', 'desc')
            ->paginate(12);

        return view('frontend.destinations.index', compact('destinations'));
    }

    // Show single destination with its tours
    public function show($slug)
    {
        $destination = Destination::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Get tours in this destination
        $tours = $destination->tours()
            ->where('status', 'published')
            ->with('category')
            ->paginate(12);

        return view('frontend.destinations.show', compact('destination', 'tours'));
    }
}