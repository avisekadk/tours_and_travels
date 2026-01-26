@extends('admin.layouts.master')

@section('title', 'User Details')
@section('page-title', 'User Profile: ' . $user->name)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-24"></div>
                <div class="px-6 pb-6 text-center relative">
                    <div class="w-24 h-24 rounded-full border-4 border-white bg-white mx-auto -mt-12 overflow-hidden shadow-md flex items-center justify-center">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-3xl font-bold text-blue-600">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mt-3">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    
                    <div class="mt-4 flex justify-center gap-2">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $user->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-100 text-left space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Phone:</span>
                            <span class="text-gray-900 font-medium">{{ $user->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Member Since:</span>
                            <span class="text-gray-900 font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Loyalty Points:</span>
                            <span class="text-gray-900 font-medium">{{ $user->loyalty_points }}</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="block w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 text-center">
                    <span class="block text-2xl font-bold text-blue-600">{{ $user->bookings->count() }}</span>
                    <span class="text-xs text-gray-500 uppercase tracking-wider">Total Bookings</span>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 text-center">
                    <span class="block text-2xl font-bold text-green-600">{{ $user->bookings->where('payment_status', 'paid')->sum('total_amount') }}</span>
                    <span class="text-xs text-gray-500 uppercase tracking-wider">Total Spent ($)</span>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 text-center">
                    <span class="block text-2xl font-bold text-yellow-600">{{ $user->reviews->count() }}</span>
                    <span class="text-xs text-gray-500 uppercase tracking-wider">Reviews</span>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">Recent Bookings</h3>
                    @if($user->bookings->count() > 0)
                        <a href="{{ route('admin.bookings.index', ['search' => $user->email]) }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-6 py-3 font-medium">Booking #</th>
                                <th class="px-6 py-3 font-medium">Tour</th>
                                <th class="px-6 py-3 font-medium">Date</th>
                                <th class="px-6 py-3 font-medium">Amount</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($user->bookings->take(5) as $booking)
                                <tr>
                                    <td class="px-6 py-3 text-blue-600 font-medium">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}">#{{ $booking->booking_number }}</a>
                                    </td>
                                    <td class="px-6 py-3">{{ Str::limit($booking->tour->title, 25) }}</td>
                                    <td class="px-6 py-3">{{ $booking->travel_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-3">${{ number_format($booking->total_amount, 2) }}</td>
                                    <td class="px-6 py-3">
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            @if($booking->booking_status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection