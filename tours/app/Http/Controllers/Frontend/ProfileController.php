<?php
// app/Http/Controllers/Frontend/ProfileController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Get user statistics
        $stats = [
            'total_bookings' => $user->bookings()->count(),
            'completed_tours' => $user->bookings()->where('booking_status', 'completed')->count(),
            'pending_bookings' => $user->bookings()->where('booking_status', 'pending')->count(),
            'total_reviews' => $user->reviews()->count(),
            'favorite_tours' => $user->favorites()->count(),
            'loyalty_points' => $user->loyalty_points,
        ];

        // Get recent bookings
        $recentBookings = $user->bookings()
            ->with('tour')
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.profile.dashboard', compact('stats', 'recentBookings'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('frontend.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}