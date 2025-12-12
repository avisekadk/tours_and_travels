<?php
// app/Http/Controllers/Frontend/FavoriteController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()
            ->with('tour')
            ->latest()
            ->paginate(12);

        return view('frontend.profile.favorites', compact('favorites'));
    }

    public function toggle(Tour $tour)
    {
        $user = auth()->user();

        $favorite = $user->favorites()->where('tour_id', $tour->id)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'success' => true,
                'message' => 'Removed from favorites',
                'favorited' => false,
            ]);
        } else {
            $user->favorites()->create([
                'tour_id' => $tour->id,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Added to favorites',
                'favorited' => true,
            ]);
        }
    }

    public function destroy(Favorite $favorite)
    {
        // Ensure favorite belongs to authenticated user
        if ($favorite->user_id !== auth()->id()) {
            abort(403);
        }

        $favorite->delete();

        return back()->with('success', 'Removed from favorites.');
    }
}