<?php
// app/Http/Controllers/Frontend/BookingController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with('tour')
            ->latest()
            ->paginate(10);

        return view('frontend.profile.bookings', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Ensure booking belongs to authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['tour', 'payment']);

        return view('frontend.profile.bookings-show', compact('booking'));
    }

    public function create(Tour $tour)
    {
        if ($tour->status !== 'published') {
            abort(404);
        }

        return view('frontend.bookings.create', compact('tour'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'travel_date' => 'required|date|after:today',
            'number_of_people' => 'required|integer|min:1|max:50',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $tour = Tour::findOrFail($validated['tour_id']);

        // Calculate prices
        $tourPrice = $tour->sale_price ?? $tour->price;
        $totalAmount = $tourPrice * $validated['number_of_people'];

        // Calculate return date
        $travelDate = \Carbon\Carbon::parse($validated['travel_date']);
        $returnDate = $travelDate->copy()->addDays($tour->duration);

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'tour_id' => $tour->id,
            'booking_date' => now(),
            'travel_date' => $validated['travel_date'],
            'return_date' => $returnDate,
            'number_of_people' => $validated['number_of_people'],
            'tour_price' => $tourPrice,
            'discount_amount' => 0,
            'total_amount' => $totalAmount,
            'payment_status' => 'pending',
            'booking_status' => 'pending',
            'special_requests' => $validated['special_requests'],
        ]);

        return redirect()->route('payment.initiate', $booking)
            ->with('success', 'Booking created successfully! Please complete the payment.');
    }

    public function confirmation(Booking $booking)
    {
        // Ensure booking belongs to authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['tour', 'payment']);

        return view('frontend.bookings.confirmation', compact('booking'));
    }

    public function invoice(Booking $booking)
    {
        // Ensure booking belongs to authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['tour', 'payment', 'user']);

        return view('frontend.bookings.invoice', compact('booking'));
    }

    public function cancel(Request $request, Booking $booking)
    {
        // Ensure booking belongs to authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow cancellation of pending bookings
        if ($booking->booking_status !== 'pending') {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'booking_status' => 'cancelled',
            'cancellation_reason' => $validated['cancellation_reason'],
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function initiatePayment(Booking $booking)
    {
        // Ensure booking belongs to authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // For now, we'll show a simple payment selection page
        return view('frontend.bookings.payment', compact('booking'));
    }

    public function esewaSuccess(Request $request)
    {
        // This is a simplified version - you'll need to implement actual eSewa verification
        $bookingNumber = $request->transaction_uuid;
        $booking = Booking::where('booking_number', $bookingNumber)->firstOrFail();

        $booking->update([
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_amount,
            'payment_method' => 'esewa',
            'transaction_id' => $request->transaction_code ?? uniqid(),
            'payment_date' => now(),
            'status' => 'success',
        ]);

        return redirect()->route('bookings.confirmation', $booking)
            ->with('success', 'Payment successful! Your booking is confirmed.');
    }

    public function esewaFailure(Request $request)
    {
        return redirect()->route('profile.bookings')
            ->with('error', 'Payment failed or was cancelled.');
    }

    public function verifyKhaltiPayment(Request $request)
    {
        // Simplified Khalti verification
        $bookingNumber = $request->booking_number;
        $booking = Booking::where('booking_number', $bookingNumber)->firstOrFail();

        $booking->update([
            'payment_status' => 'paid',
            'booking_status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_amount,
            'payment_method' => 'khalti',
            'transaction_id' => $request->token ?? uniqid(),
            'payment_date' => now(),
            'status' => 'success',
        ]);

        return response()->json([
            'success' => true,
            'redirect_url' => route('bookings.confirmation', $booking),
        ]);
    }
}