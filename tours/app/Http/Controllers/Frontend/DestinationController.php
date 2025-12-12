<?php
// app/Http/Controllers/Frontend/DestinationController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::active()
            ->withCount('tours')
            ->orderBy('featured', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(12);

        return view('frontend.destinations.index', compact('destinations'));
    }

    public function show($slug)
    {
        $destination = Destination::with(['tours' => function ($query) {
            $query->published()->orderBy('featured', 'desc');
        }])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        return view('frontend.destinations.show', compact('destination'));
    }
}