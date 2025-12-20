<?php
// app/Http/Controllers/Admin/ReviewController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'tour']);

        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->approved();
            } elseif ($request->status === 'pending') {
                $query->pending();
            }
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load(['user', 'tour']);

        return view('admin.reviews.show', compact('review'));
    }

    public function approve(Review $review)
    {
        $review->update(['approved' => true]);

        return back()->with('success', 'Review approved successfully!');
    }

    public function reject(Review $review)
    {
        $review->update(['approved' => false]);

        return back()->with('success', 'Review rejected successfully!');
    }

    public function reply(Request $request, Review $review)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $review->update([
            'admin_reply' => $validated['admin_reply'],
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Reply posted successfully!');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }
}