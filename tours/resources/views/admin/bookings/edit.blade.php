@extends('admin.layouts.master')

@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking #' . $booking->booking_number)

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Update Status</h3>
                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-sm text-gray-600 hover:text-gray-900">
                    &larr; Back to Details
                </a>
            </div>
            
            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="col-span-2 bg-blue-50 p-4 rounded-lg border border-blue-100 mb-2">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Customer</p>
                                <p class="font-medium">{{ $booking->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Tour</p>
                                <p class="font-medium">{{ $booking->tour->title }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Total Amount</p>
                                <p class="font-medium">${{ number_format($booking->total_amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Travel Date</p>
                                <p class="font-medium">{{ $booking->travel_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="booking_status" class="block text-sm font-medium text-gray-700 mb-2">Booking Status</label>
                        <select name="booking_status" id="booking_status" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm @error('booking_status') border-red-500 @enderror">
                            <option value="pending" {{ old('booking_status', $booking->booking_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ old('booking_status', $booking->booking_status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ old('booking_status', $booking->booking_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('booking_status', $booking->booking_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('booking_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Changing to 'Cancelled' will trigger cancellation logic.</p>
                    </div>

                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm @error('payment_status') border-red-500 @enderror">
                            <option value="pending" {{ old('payment_status', $booking->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ old('payment_status', $booking->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ old('payment_status', $booking->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ old('payment_status', $booking->payment_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        @error('payment_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-4 border-t pt-6">
                    <a href="{{ route('admin.bookings.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                        Update Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection