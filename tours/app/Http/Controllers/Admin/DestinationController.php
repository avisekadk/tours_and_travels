<?php
// app/Http/Controllers/Admin/DestinationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::withCount('tours')->latest()->paginate(20);

        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'weather_city' => 'nullable|string|max:255',
            'best_season' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'status' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('destinations', 'public');
        }

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('destinations', 'public');
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['featured'] = $request->has('featured') ? true : false;
        $validated['status'] = $request->has('status') ? true : false;

        Destination::create($validated);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destination created successfully!');
    }

    public function show(Destination $destination)
    {
        $destination->load('tours');

        return view('admin.destinations.show', compact('destination'));
    }

    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'weather_city' => 'nullable|string|max:255',
            'best_season' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'status' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('image')) {
            if ($destination->image) {
                Storage::disk('public')->delete($destination->image);
            }
            $validated['image'] = $request->file('image')->store('destinations', 'public');
        }

        if ($request->hasFile('banner_image')) {
            if ($destination->banner_image) {
                Storage::disk('public')->delete($destination->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('destinations', 'public');
        }

        if ($validated['name'] !== $destination->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['featured'] = $request->has('featured') ? true : false;
        $validated['status'] = $request->has('status') ? true : false;

        $destination->update($validated);

        return back()->with('success', 'Destination updated successfully!');
    }

    public function destroy(Destination $destination)
    {
        if ($destination->tours()->count() > 0) {
            return back()->with('error', 'Cannot delete destination with tours!');
        }

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