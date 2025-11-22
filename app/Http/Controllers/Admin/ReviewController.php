<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Show all reviews
    public function index(Request $request)
    {
        $query = Review::with(['user', 'tour']);

        // Filter by approval status
        if ($request->has('approved') && $request->approved != '') {
            $query->where('approved', $request->approved);
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    // Show single review
    public function show($id)
    {
        $review = Review::with(['user', 'tour'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    // Approve review
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->approved = true;
        $review->save();

        return back()->with('success', 'Review approved successfully!');
    }

    // Reject review
    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->approved = false;
        $review->save();

        return back()->with('success', 'Review rejected successfully!');
    }

    // Reply to review
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $review = Review::findOrFail($id);
        $review->admin_reply = $request->admin_reply;
        $review->replied_at = now();
        $review->save();

        return back()->with('success', 'Reply added successfully!');
    }

    // Delete review
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }
}