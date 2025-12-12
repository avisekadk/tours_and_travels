<?php
// app/Http/Controllers/Frontend/ReviewController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if user has already reviewed this tour
        $existingReview = auth()->user()->reviews()->where('tour_id', $tour->id)->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this tour.');
        }

        // Create review
        Review::create([
            'user_id' => auth()->id(),
            'tour_id' => $tour->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
            'approved' => false, // Reviews need admin approval
        ]);

        return back()->with('success', 'Thank you for your review! It will be published after approval.');
    }

    public function update(Request $request, Review $review)
    {
        // Ensure review belongs to authenticated user
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully!');
    }

    public function destroy(Review $review)
    {
        // Ensure review belongs to authenticated user
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}