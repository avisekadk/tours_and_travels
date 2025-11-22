<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Create booking
    public function create($tourId)
    {
        $tour = Tour::findOrFail($tourId);
        return view('frontend.bookings.create', compact('tour'));
    }

    // Store booking
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'travel_date' => 'required|date|after:today',
            'number_of_people' => 'required|integer|min:1',
            'payment_method' => 'required|in:esewa,khalti,paypal,stripe',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $tour = Tour::findOrFail($request->tour_id);

        // Calculate total amount
        $tourPrice = $tour->sale_price ?? $tour->price;
        $totalAmount = $tourPrice * $request->number_of_people;

        // Create booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'tour_id' => $tour->id,
            'booking_date' => now(),
            'travel_date' => $request->travel_date,
            'number_of_people' => $request->number_of_people,
            'tour_price' => $tourPrice,
            'discount_amount' => 0,
            'total_amount' => $totalAmount,
            'payment_status' => 'pending',
            'booking_status' => 'pending',
            'special_requests' => $request->special_requests,
        ]);

        // Create payment record
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        // Redirect to payment or confirmation
        return redirect()->route('profile.bookings.confirmation', $booking->id)
            ->with('success', 'Booking created successfully!');
    }

    // Show booking confirmation
    public function confirmation($bookingId)
    {
        $booking = Booking::with(['tour', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($bookingId);

        return view('frontend.bookings.confirmation', compact('booking'));
    }
}