<?php
// app/Http/Controllers/Admin/TourController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::with(['category', 'destination']);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $tours = $query->latest()->paginate(20);

        $categories = Category::active()->get();

        return view('admin.tours.index', compact('tours', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $destinations = Destination::active()->get();

        return view('admin.tours.create', compact('categories', 'destinations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'duration' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,moderate,challenging,difficult',
            'max_people' => 'nullable|integer|min:1',
            'min_people' => 'nullable|integer|min:1',
            'location' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'status' => 'required|in:draft,published,archived',
            'featured' => 'boolean',
            'itinerary' => 'nullable|array',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
            'highlights' => 'nullable|array',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('tours', 'public');
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);
        $validated['featured'] = $request->has('featured') ? true : false;

        // Create tour
        $tour = Tour::create($validated);

        return redirect()->route('admin.tours.edit', $tour)
            ->with('success', 'Tour created successfully!');
    }

    public function show(Tour $tour)
    {
        $tour->load(['category', 'destination', 'bookings', 'reviews']);

        return view('admin.tours.show', compact('tour'));
    }

    public function edit(Tour $tour)
    {
        $categories = Category::active()->ordered()->get();
        $destinations = Destination::active()->get();

        return view('admin.tours.edit', compact('tour', 'categories', 'destinations'));
    }

    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'duration' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,moderate,challenging,difficult',
            'max_people' => 'nullable|integer|min:1',
            'min_people' => 'nullable|integer|min:1',
            'location' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'status' => 'required|in:draft,published,archived',
            'featured' => 'boolean',
            'itinerary' => 'nullable|array',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
            'highlights' => 'nullable|array',
            'video_url' => 'nullable|url',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($tour->featured_image) {
                Storage::disk('public')->delete($tour->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('tours', 'public');
        }

        // Update slug if title changed
        if ($validated['title'] !== $tour->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['featured'] = $request->has('featured') ? true : false;

        // Update tour
        $tour->update($validated);

        return back()->with('success', 'Tour updated successfully!');
    }

    public function destroy(Tour $tour)
    {
        // Delete featured image
        if ($tour->featured_image) {
            Storage::disk('public')->delete($tour->featured_image);
        }

        // Soft delete tour
        $tour->delete();

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour deleted successfully!');
    }
}