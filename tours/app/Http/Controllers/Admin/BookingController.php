<?php
// app/Http/Controllers/Admin/BookingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'tour', 'payment']);

        // Filter by status
        if ($request->has('booking_status') && $request->booking_status) {
            $query->where('booking_status', $request->booking_status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by booking number or user
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $query->latest()->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'tour', 'payment']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'booking_status' => 'required|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $booking->update($validated);

        return back()->with('success', 'Booking updated successfully!');
    }

    public function confirm(Booking $booking)
    {
        $booking->update([
            'booking_status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Here you would send confirmation email to user

        return back()->with('success', 'Booking confirmed successfully!');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'booking_status' => 'cancelled',
            'cancellation_reason' => $validated['cancellation_reason'],
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Booking cancelled successfully!');
    }
}