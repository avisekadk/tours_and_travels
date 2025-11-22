<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    // Show all tours
    public function index(Request $request)
    {
        $query = Tour::with(['category', 'destination']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'LIKE', "%{$search}%");
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $tours = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.tours.index', compact('tours'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::where('status', true)->get();
        $destinations = Destination::where('status', true)->get();

        return view('admin.tours.create', compact('categories', 'destinations'));
    }

    // Store new tour
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,moderate,challenging,difficult',
            'max_people' => 'nullable|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'destination_id' => 'required|exists:destinations,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Create tour
        $tour = new Tour();
        $tour->title = $request->title;
        $tour->slug = Str::slug($request->title);
        $tour->description = $request->description;
        $tour->short_description = $request->short_description;
        $tour->price = $request->price;
        $tour->sale_price = $request->sale_price;
        $tour->duration = $request->duration;
        $tour->difficulty = $request->difficulty;
        $tour->max_people = $request->max_people;
        $tour->min_people = $request->min_people ?? 1;
        $tour->location = $request->location;
        $tour->category_id = $request->category_id;
        $tour->destination_id = $request->destination_id;
        $tour->status = $request->status;
        $tour->featured = $request->has('featured') ? true : false;

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('tours', 'public');
            $tour->featured_image = $imagePath;
        }

        // Handle JSON fields
        $tour->inclusions = $request->inclusions ? json_decode($request->inclusions) : null;
        $tour->exclusions = $request->exclusions ? json_decode($request->exclusions) : null;
        $tour->highlights = $request->highlights ? json_decode($request->highlights) : null;
        $tour->itinerary = $request->itinerary ? json_decode($request->itinerary) : null;

        $tour->save();

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour created successfully!');
    }

    // Show single tour
    public function show($id)
    {
        $tour = Tour::with(['category', 'destination', 'reviews'])->findOrFail($id);
        return view('admin.tours.show', compact('tour'));
    }

    // Show edit form
    public function edit($id)
    {
        $tour = Tour::findOrFail($id);
        $categories = Category::where('status', true)->get();
        $destinations = Destination::where('status', true)->get();

        return view('admin.tours.edit', compact('tour', 'categories', 'destinations'));
    }

    // Update tour
    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        // Validate
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,moderate,challenging,difficult',
            'category_id' => 'required|exists:categories,id',
            'destination_id' => 'required|exists:destinations,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Update tour
        $tour->title = $request->title;
        $tour->slug = Str::slug($request->title);
        $tour->description = $request->description;
        $tour->short_description = $request->short_description;
        $tour->price = $request->price;
        $tour->sale_price = $request->sale_price;
        $tour->duration = $request->duration;
        $tour->difficulty = $request->difficulty;
        $tour->max_people = $request->max_people;
        $tour->category_id = $request->category_id;
        $tour->destination_id = $request->destination_id;
        $tour->status = $request->status;
        $tour->featured = $request->has('featured') ? true : false;

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($tour->featured_image) {
                Storage::disk('public')->delete($tour->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('tours', 'public');
            $tour->featured_image = $imagePath;
        }

        $tour->save();

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour updated successfully!');
    }

    // Delete tour
    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);

        // Delete image
        if ($tour->featured_image) {
            Storage::disk('public')->delete($tour->featured_image);
        }

        $tour->delete();

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour deleted successfully!');
    }
}