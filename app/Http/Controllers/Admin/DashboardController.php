<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Booking;
use App\Models\User;
use App\Models\Review;
use App\Models\Inquiry;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalTours = Tour::count();
        $totalBookings = Booking::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_amount');

        // Get pending items
        $pendingBookings = Booking::where('booking_status', 'pending')->count();
        $pendingReviews = Review::where('approved', false)->count();
        $newInquiries = Inquiry::where('status', 'new')->count();

        // Get recent bookings
        $recentBookings = Booking::with(['user', 'tour'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent reviews
        $recentReviews = Review::with(['user', 'tour'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalTours',
            'totalBookings',
            'totalUsers',
            'totalRevenue',
            'pendingBookings',
            'pendingReviews',
            'newInquiries',
            'recentBookings',
            'recentReviews'
        ));
    }
}