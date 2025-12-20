<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Booking;
use App\Models\User;
use App\Models\Review;
use App\Models\Inquiry;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_tours' => Tour::count(),
            'published_tours' => Tour::published()->count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::pending()->count(),
            'confirmed_bookings' => Booking::confirmed()->count(),
            'total_users' => User::where('role', 'user')->count(),
            'pending_reviews' => Review::pending()->count(),
            'new_inquiries' => Inquiry::new()->count(),
        ];

        // Revenue statistics
        $revenue = [
            'total' => Booking::paid()->sum('total_amount'),
            'this_month' => Booking::paid()
                ->whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'this_year' => Booking::paid()
                ->whereYear('created_at', now()->year)
                ->sum('total_amount'),
        ];

        // Recent bookings
        $recentBookings = Booking::with(['user', 'tour'])
            ->latest()
            ->take(10)
            ->get();

        // Popular tours
        $popularTours = Tour::published()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // Monthly bookings chart data (last 6 months)
        $monthlyBookings = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'revenue',
            'recentBookings',
            'popularTours',
            'monthlyBookings'
        ));
    }
}