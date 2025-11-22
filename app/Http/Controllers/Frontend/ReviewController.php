<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Store review
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string',
        ]);

        // Check if user has booked this tour
        $hasBooked = Booking::where('user_id', Auth::id())
            ->where('tour_id', $request->tour_id)
            ->where('booking_status', 'completed')
            ->exists();

        if (!$hasBooked) {
            return back()->with('error', 'You can only review tours you have completed!');
        }

        // Check if already reviewed
        $hasReviewed = Review::where('user_id', Auth::id())
            ->where('tour_id', $request->tour_id)
            ->exists();

        if ($hasReviewed) {
            return back()->with('error', 'You have already reviewed this tour!');
        }

        // Create review
        Review::create([
            'user_id' => Auth::id(),
            'tour_id' => $request->tour_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'approved' => false, // Admin will approve
        ]);

        return back()->with('success', 'Thank you for your review! It will be published after approval.');
    }
}