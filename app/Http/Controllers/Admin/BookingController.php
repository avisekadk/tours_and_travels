<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Show all bookings
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'tour']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('booking_status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('booking_number', 'LIKE', "%{$search}%");
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    // Show single booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'tour', 'payment'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    // Confirm booking
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->booking_status = 'confirmed';
        $booking->confirmed_at = now();
        $booking->save();

        return back()->with('success', 'Booking confirmed successfully!');
    }

    // Cancel booking
    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'cancellation_reason' => 'required|string',
        ]);

        $booking->booking_status = 'cancelled';
        $booking->cancelled_at = now();
        $booking->cancellation_reason = $request->cancellation_reason;
        $booking->save();

        return back()->with('success', 'Booking cancelled successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $booking = Booking::with(['user', 'tour'])->findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    // Update booking
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'booking_status' => 'required|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $booking->booking_status = $request->booking_status;
        $booking->payment_status = $request->payment_status;
        $booking->save();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    // Delete booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }
}