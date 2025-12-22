{{-- resources/views/frontend/profile/dashboard.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'My Dashboard - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div class="text-white">
                <h1 class="text-4xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-white/90">Manage your bookings and explore new adventures</p>
            </div>
            <div class="hidden md:block">
                <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white text-4xl font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">📅</span>
                    </div>
                    <span class="text-3xl font-bold text-blue-600">{{ $stats['total_bookings'] }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Total Bookings</h3>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">✓</span>
                    </div>
                    <span class="text-3xl font-bold text-green-600">{{ $stats['completed_tours'] }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Completed Tours</h3>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">⏳</span>
                    </div>
                    <span class="text-3xl font-bold text-yellow-600">{{ $stats['pending_bookings'] }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Pending</h3>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">❤️</span>
                    </div>
                    <span class="text-3xl font-bold text-pink-600">{{ $stats['favorite_tours'] }}</span>
                </div>
                <h3 class="text-gray-600 font-semibold">Favorites</h3>
            </div>
        </div>
        
        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Recent Bookings -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Recent Bookings</h2>
                        <a href="{{ route('profile.bookings') }}" class="text-blue-600 font-semibold hover:text-blue-700">
                            View All →
                        </a>
                    </div>
                    
                    @if($recentBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentBookings as $booking)
                                <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-800 mb-1">{{ $booking->tour->title }}</h3>
                                            <p class="text-sm text-gray-500">Booking #{{ $booking->booking_number }}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($booking->booking_status === 'confirmed') bg-green-100 text-green-700
                                            @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-700
                                            @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-700
                                            @else bg-blue-100 text-blue-700 @endif">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="flex items-center gap-4 text-gray-600">
                                            <span>📅 {{ $booking->travel_date->format('M d, Y') }}</span>
                                            <span>👥 {{ $booking->number_of_people }} {{ Str::plural('person', $booking->number_of_people) }}</span>
                                            <span class="font-semibold text-gray-800">${{ number_format($booking->total_amount, 2) }}</span>
                                        </div>
                                        <a href="{{ route('profile.bookings.show', $booking) }}" 
                                           class="text-blue-600 font-semibold hover:text-blue-700">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📅</div>
                            <p class="text-gray-500 mb-4">No bookings yet</p>
                            <a href="{{ route('tours.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                Browse Tours
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Upcoming Tours -->
                @php
                    $upcomingBookings = auth()->user()->bookings()
                        ->where('travel_date', '>', now())
                        ->where('booking_status', 'confirmed')
                        ->orderBy('travel_date', 'asc')
                        ->take(3)
                        ->get();
                @endphp
                
                @if($upcomingBookings->count() > 0)
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-lg p-8 text-white">
                        <h2 class="text-2xl font-bold mb-6">Upcoming Tours</h2>
                        <div class="space-y-4">
                            @foreach($upcomingBookings as $booking)
                                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                                    <h3 class="font-bold mb-2">{{ $booking->tour->title }}</h3>
                                    <div class="flex items-center justify-between text-sm">
                                        <span>📅 Starts: {{ $booking->travel_date->format('M d, Y') }}</span>
                                        <span class="font-semibold">{{ $booking->travel_date->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Quick Links -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="{{ route('profile.bookings') }}" 
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                            <span class="flex items-center">
                                <span class="mr-3">📅</span>
                                My Bookings
                            </span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        
                        <a href="{{ route('profile.favorites') }}" 
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                            <span class="flex items-center">
                                <span class="mr-3">❤️</span>
                                Favorites
                            </span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                            <span class="flex items-center">
                                <span class="mr-3">⚙️</span>
                                Account Settings
                            </span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        
                        <a href="{{ route('tours.index') }}" 
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                            <span class="flex items-center">
                                <span class="mr-3">🔍</span>
                                Browse Tours
                            </span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Loyalty Points -->
                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl shadow-lg p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">Loyalty Points</h3>
                    <div class="text-4xl font-bold mb-2">{{ number_format(auth()->user()->loyalty_points) }}</div>
                    <p class="text-sm text-white/90">Use points on your next booking!</p>
                </div>
                
                <!-- Need Help -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Need Help?</h3>
                    <p class="text-gray-600 text-sm mb-4">Our team is here to assist you with any questions.</p>
                    <a href="{{ route('contact') }}" 
                       class="block w-full px-4 py-3 bg-blue-600 text-white text-center rounded-lg font-semibold hover:bg-blue-700 transition">
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection