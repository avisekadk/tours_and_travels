<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // User dashboard
    public function dashboard()
    {
        $user = Auth::user();

        // Get user statistics
        $totalBookings = Booking::where('user_id', $user->id)->count();
        $pendingBookings = Booking::where('user_id', $user->id)
            ->where('booking_status', 'pending')
            ->count();
        $completedBookings = Booking::where('user_id', $user->id)
            ->where('booking_status', 'completed')
            ->count();
        $totalFavorites = Favorite::where('user_id', $user->id)->count();

        // Get recent bookings
        $recentBookings = Booking::with('tour')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.profile.dashboard', compact(
            'user',
            'totalBookings',
            'pendingBookings',
            'completedBookings',
            'totalFavorites',
            'recentBookings'
        ));
    }

    // Show all bookings
    public function bookings()
    {
        $bookings = Booking::with('tour')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.profile.bookings', compact('bookings'));
    }

    // Show single booking
    public function showBooking($id)
    {
        $booking = Booking::with(['tour', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('frontend.profile.booking-detail', compact('booking'));
    }

    // Show favorites
    public function favorites()
    {
        $favorites = Favorite::with('tour')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('frontend.profile.favorites', compact('favorites'));
    }

    // Add to favorites
    public function addFavorite($tourId)
    {
        // Check if already favorited
        $exists = Favorite::where('user_id', Auth::id())
            ->where('tour_id', $tourId)
            ->exists();

        if ($exists) {
            return back()->with('info', 'Tour is already in your favorites!');
        }

        // Create favorite
        Favorite::create([
            'user_id' => Auth::id(),
            'tour_id' => $tourId,
        ]);

        return back()->with('success', 'Tour added to favorites!');
    }

    // Remove from favorites
    public function removeFavorite($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->findOrFail($id);

        $favorite->delete();

        return back()->with('success', 'Tour removed from favorites!');
    }

    // Show edit profile form
    public function edit()
    {
        $user = Auth::user();
        return view('frontend.profile.edit', compact('user'));
    }

    // Update profile
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Upload new avatar
            $avatarPath = $request->file('avatar')->store('users', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    // Change password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }
}