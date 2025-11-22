<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    // Show all destinations
    public function index()
    {
        $destinations = Destination::withCount('tours')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.destinations.index', compact('destinations'));
    }

    // Show create form
    public function create()
    {
        return view('admin.destinations.create');
    }

    // Store new destination
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'featured' => 'nullable|boolean',
            'status' => 'required|boolean',
        ]);

        $destination = new Destination();
        $destination->name = $request->name;
        $destination->slug = Str::slug($request->name);
        $destination->description = $request->description;
        $destination->latitude = $request->latitude;
        $destination->longitude = $request->longitude;
        $destination->weather_city = $request->weather_city;
        $destination->best_season = $request->best_season;
        $destination->featured = $request->has('featured') ? true : false;
        $destination->status = $request->status;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('destinations', 'public');
            $destination->image = $imagePath;
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('destinations', 'public');
            $destination->banner_image = $bannerPath;
        }

        $destination->save();

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination created successfully!');
    }

    // Show single destination
    public function show($id)
    {
        $destination = Destination::with('tours')->findOrFail($id);
        return view('admin.destinations.show', compact('destination'));
    }

    // Show edit form
    public function edit($id)
    {
        $destination = Destination::findOrFail($id);
        return view('admin.destinations.edit', compact('destination'));
    }

    // Update destination
    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required|boolean',
        ]);

        $destination->name = $request->name;
        $destination->slug = Str::slug($request->name);
        $destination->description = $request->description;
        $destination->latitude = $request->latitude;
        $destination->longitude = $request->longitude;
        $destination->weather_city = $request->weather_city;
        $destination->best_season = $request->best_season;
        $destination->featured = $request->has('featured') ? true : false;
        $destination->status = $request->status;

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($destination->image) {
                Storage::disk('public')->delete($destination->image);
            }
            $imagePath = $request->file('image')->store('destinations', 'public');
            $destination->image = $imagePath;
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            if ($destination->banner_image) {
                Storage::disk('public')->delete($destination->banner_image);
            }
            $bannerPath = $request->file('banner_image')->store('destinations', 'public');
            $destination->banner_image = $bannerPath;
        }

        $destination->save();

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination updated successfully!');
    }

    // Delete destination
    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);

        // Delete images
        if ($destination->image) {
            Storage::disk('public')->delete($destination->image);
        }
        if ($destination->banner_image) {
            Storage::disk('public')->delete($destination->banner_image);
        }

        $destination->delete();

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination deleted successfully!');
    }
}