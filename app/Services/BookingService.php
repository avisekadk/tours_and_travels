<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Support\Facades\DB;

class BookingService
{
    // Create a new booking
    public function createBooking($data)
    {
        try {
            DB::beginTransaction();

            $tour = Tour::findOrFail($data['tour_id']);
            
            // Calculate prices
            $tourPrice = $tour->sale_price ?? $tour->price;
            $totalAmount = $tourPrice * $data['number_of_people'];
            
            // Create booking
            $booking = Booking::create([
                'user_id' => $data['user_id'],
                'tour_id' => $tour->id,
                'booking_date' => now(),
                'travel_date' => $data['travel_date'],
                'number_of_people' => $data['number_of_people'],
                'tour_price' => $tourPrice,
                'discount_amount' => $data['discount_amount'] ?? 0,
                'total_amount' => $totalAmount - ($data['discount_amount'] ?? 0),
                'payment_status' => 'pending',
                'booking_status' => 'pending',
                'special_requests' => $data['special_requests'] ?? null,
            ]);

            DB::commit();
            return $booking;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Update booking status
    public function updateBookingStatus($bookingId, $status)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->booking_status = $status;
        
        if ($status === 'confirmed') {
            $booking->confirmed_at = now();
        } elseif ($status === 'completed') {
            $booking->completed_at = now();
        } elseif ($status === 'cancelled') {
            $booking->cancelled_at = now();
        }
        
        $booking->save();
        return $booking;
    }

    // Cancel booking
    public function cancelBooking($bookingId, $reason = null)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->booking_status = 'cancelled';
        $booking->cancelled_at = now();
        $booking->cancellation_reason = $reason;
        $booking->save();
        
        return $booking;
    }
}