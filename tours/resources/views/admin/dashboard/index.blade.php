@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-sm font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">
                    {{ $stats['published_tours'] }} Active
                </span>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['total_tours'] }}</h3>
            <p class="text-sm text-gray-500 font-medium">Total Tours</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                @if($stats['pending_bookings'] > 0)
                    <span class="text-sm font-semibold text-yellow-600 bg-yellow-50 px-2 py-1 rounded">
                        {{ $stats['pending_bookings'] }} Pending
                    </span>
                @endif
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['total_bookings'] }}</h3>
            <p class="text-sm text-gray-500 font-medium">Total Bookings</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['total_users'] }}</h3>
            <p class="text-sm text-gray-500 font-medium">Registered Travelers</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 transition hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                @if($stats['new_inquiries'] > 0)
                    <span class="text-sm font-semibold text-red-600 bg-red-50 px-2 py-1 rounded animate-pulse">
                        {{ $stats['new_inquiries'] }} New
                    </span>
                @endif
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['new_inquiries'] }}</h3>
            <p class="text-sm text-gray-500 font-medium">Inquiries</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Revenue Overview</h3>
                <span class="text-sm text-gray-500">Financial Performance</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-800">${{ number_format($revenue['total'], 2) }}</p>
                </div>
                <div class="p-4 bg-green-50 rounded-lg border border-green-100">
                    <p class="text-sm text-green-600 mb-1">This Month</p>
                    <p class="text-2xl font-bold text-green-700">${{ number_format($revenue['this_month'], 2) }}</p>
                </div>
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm text-blue-600 mb-1">This Year</p>
                    <p class="text-2xl font-bold text-blue-700">${{ number_format($revenue['this_year'], 2) }}</p>
                </div>
            </div>

            <div class="h-64 flex items-end justify-between gap-2 pt-4 border-t border-dashed border-gray-200">
                @foreach($monthlyBookings as $data)
                    <div class="w-full flex flex-col items-center gap-2 group">
                        <div class="w-full bg-blue-100 rounded-t-sm relative group-hover:bg-blue-200 transition-all" style="height: {{ min(($data->revenue / ($revenue['this_year'] ?: 1)) * 100 * 2, 100) }}%">
                            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                ${{ number_format($data->revenue) }}
                            </div>
                        </div>
                        <span class="text-xs text-gray-500 font-medium">{{ date('M', mktime(0, 0, 0, $data->month, 10)) }}</span>
                    </div>
                @endforeach
                @if($monthlyBookings->isEmpty())
                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                        No revenue data available for chart
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.tours.create') }}" class="flex items-center justify-center w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Add New Tour
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="flex items-center justify-center w-full px-4 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                        View All Bookings
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Popular Tours</h3>
                <div class="space-y-4">
                    @forelse($popularTours as $tour)
                        <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                            <div class="h-12 w-12 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                                @if($tour->featured_image)
                                    <img src="{{ asset('storage/' . $tour->featured_image) }}" class="h-full w-full object-cover" alt="Tour">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-800 truncate">{{ $tour->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $tour->views }} views</p>
                            </div>
                            <a href="{{ route('admin.tours.edit', $tour) }}" class="text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center">No tours yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Recent Bookings</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Booking ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Tour</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $booking->booking_number }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $booking->tour->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">${{ number_format($booking->total_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                @if($booking->booking_status === 'confirmed')
                                    <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Confirmed</span>
                                @elseif($booking->booking_status === 'pending')
                                    <span class="px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                                @elseif($booking->booking_status === 'cancelled')
                                    <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Cancelled</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">{{ ucfirst($booking->booking_status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">No bookings found recently.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection