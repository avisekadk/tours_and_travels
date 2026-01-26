@extends('admin.layouts.master')

@section('title', 'Booking Details')
@section('page-title', 'Booking #' . $booking->booking_number)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Tour Information</h3>
                <div class="flex items-start gap-4">
                    @if($booking->tour->featured_image)
                        <img src="{{ asset('storage/' . $booking->tour->featured_image) }}" alt="Tour" class="w-24 h-24 object-cover rounded-lg">
                    @else
                        <div class="w-24 h-24 bg-gray-200 rounded-lg"></div>
                    @endif
                    <div>
                        <h4 class="text-xl font-bold text-blue-600 mb-1">
                            <a href="{{ route('admin.tours.show', $booking->tour->id) }}" class="hover:underline">
                                {{ $booking->tour->title }}
                            </a>
                        </h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Duration:</strong> {{ $booking->tour->duration }} Days</p>
                            <p><strong>Destination:</strong> {{ $booking->tour->destination->name ?? 'N/A' }}</p>
                            <p><strong>Category:</strong> {{ $booking->tour->category->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-6 pt-4 border-t border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Travel Date</p>
                        <p class="font-medium">{{ $booking->travel_date->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Return Date</p>
                        <p class="font-medium">{{ $booking->return_date->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Travelers</p>
                        <p class="font-medium">{{ $booking->number_of_people }} Person(s)</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase">Booking Date</p>
                        <p class="font-medium">{{ $booking->created_at->format('F d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Special Requests</h3>
                <p class="text-gray-700 italic">
                    {{ $booking->special_requests ?? 'No special requests made.' }}
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Payment Details</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Transaction ID</th>
                                <th class="px-4 py-2">Method</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($booking->payment)
                                <tr>
                                    <td class="px-4 py-3 font-mono">{{ $booking->payment->transaction_id ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 uppercase">{{ $booking->payment->payment_method }}</td>
                                    <td class="px-4 py-3">{{ $booking->payment->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">{{ ucfirst($booking->payment->status) }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold">${{ number_format($booking->payment->amount, 2) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">No payment record found.</td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="border-t">
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-right font-bold">Total Amount:</td>
                                <td class="px-4 py-3 text-right font-bold text-lg text-blue-600">${{ number_format($booking->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Customer</h3>
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl mr-3">
                        {{ substr($booking->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $booking->user->name }}</p>
                        <p class="text-sm text-gray-500">ID: #{{ $booking->user->id }}</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <a href="mailto:{{ $booking->user->email }}" class="hover:text-blue-600">{{ $booking->user->email }}</a>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        {{ $booking->user->phone ?? 'N/A' }}
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                    <a href="{{ route('admin.users.show', $booking->user->id) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View User Profile &rarr;</a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Status & Actions</h3>
                
                <div class="space-y-4 mb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase mb-1">Booking Status</p>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            @if($booking->booking_status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($booking->booking_status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase mb-1">Payment Status</p>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            @if($booking->payment_status === 'paid') bg-green-100 text-green-800
                            @elseif($booking->payment_status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->payment_status === 'failed') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($booking->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="block w-full py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition">
                        Edit Booking
                    </a>

                    @if($booking->booking_status === 'pending')
                        <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition" onclick="return confirm('Are you sure you want to confirm this booking?')">
                                Confirm Booking
                            </button>
                        </form>
                    @endif

                    @if($booking->booking_status !== 'cancelled')
                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="cancellation_reason" value="Cancelled by Admin">
                            <button type="submit" class="w-full py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition" onclick="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')">
                                Cancel Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection