{{-- resources/views/frontend/bookings/invoice.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'Invoice #' . $booking->booking_number . ' - HimalayaVoyage')

@section('content')

<!-- Invoice Container -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <!-- Print Button -->
            <div class="text-right mb-6 no-print">
                <button onclick="window.print()" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    🖨️ Print Invoice
                </button>
            </div>
            
            <!-- Invoice -->
            <div class="bg-white rounded-2xl shadow-lg p-12" id="invoice">
                
                <!-- Header -->
                <div class="flex items-start justify-between mb-8 pb-8 border-b-2 border-gray-200">
                    <div>
                        <h1 class="text-4xl font-bold text-blue-600 mb-2">INVOICE</h1>
                        <p class="text-gray-600">Invoice #{{ $booking->booking_number }}</p>
                        <p class="text-sm text-gray-500">Date: {{ $booking->created_at->format('F d, Y') }}</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">HimalayaVoyage</h2>
                        <p class="text-sm text-gray-600">Thamel, Kathmandu, Nepal</p>
                        <p class="text-sm text-gray-600">Phone: +977-1-4444444</p>
                        <p class="text-sm text-gray-600">Email: info@himalayavoyage.com</p>
                    </div>
                </div>
                
                <!-- Bill To -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Bill To:</h3>
                        <p class="font-semibold text-gray-800">{{ $booking->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->user->phone }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Booking Details:</h3>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-semibold">Status:</span> 
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @if($booking->booking_status === 'confirmed') bg-green-100 text-green-700
                                    @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-blue-100 text-blue-700 @endif">
                                    {{ ucfirst($booking->booking_status) }}
                                </span>
                            </p>
                            <p><span class="font-semibold">Payment Status:</span> 
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @if($booking->payment_status === 'paid') bg-green-100 text-green-700
                                    @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </p>
                            <p><span class="font-semibold">Booking Date:</span> {{ $booking->booking_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Tour Details Table -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tour Information:</h3>
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-left p-3 font-semibold text-gray-700">Description</th>
                                <th class="text-center p-3 font-semibold text-gray-700">Travel Date</th>
                                <th class="text-center p-3 font-semibold text-gray-700">Duration</th>
                                <th class="text-center p-3 font-semibold text-gray-700">Travelers</th>
                                <th class="text-right p-3 font-semibold text-gray-700">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="p-3">
                                    <p class="font-semibold text-gray-800">{{ $booking->tour->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->tour->destination->name ?? 'Nepal' }}</p>
                                    <p class="text-xs text-gray-500">Difficulty: {{ ucfirst($booking->tour->difficulty) }}</p>
                                </td>
                                <td class="text-center p-3 text-sm">
                                    {{ $booking->travel_date->format('M d, Y') }}
                                </td>
                                <td class="text-center p-3 text-sm">
                                    {{ $booking->tour->duration }} days
                                </td>
                                <td class="text-center p-3 text-sm">
                                    {{ $booking->number_of_people }}
                                </td>
                                <td class="text-right p-3 font-semibold">
                                    ${{ number_format($booking->tour_price, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pricing Breakdown -->
                <div class="flex justify-end mb-8">
                    <div class="w-full md:w-1/2">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-semibold">${{ number_format($booking->tour_price * $booking->number_of_people, 2) }}</span>
                            </div>
                            
                            @if($booking->discount_amount > 0)
                                <div class="flex justify-between text-sm text-green-600">
                                    <span>Discount:</span>
                                    <span class="font-semibold">-${{ number_format($booking->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax (0%):</span>
                                <span class="font-semibold">$0.00</span>
                            </div>
                            
                            <div class="flex justify-between pt-3 border-t-2 border-gray-300">
                                <span class="text-xl font-bold text-gray-800">Total:</span>
                                <span class="text-2xl font-bold text-blue-600">${{ number_format($booking->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Information -->
                @if($booking->payment)
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-green-800">Payment Received</p>
                                <p class="text-sm text-green-700">
                                    Method: {{ ucfirst($booking->payment->payment_method) }} • 
                                    Transaction ID: {{ $booking->payment->transaction_id }} • 
                                    Date: {{ $booking->payment->payment_date->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Terms & Notes -->
                <div class="border-t-2 border-gray-200 pt-8">
                    <h3 class="font-semibold text-gray-800 mb-3">Terms & Conditions:</h3>
                    <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside">
                        <li>Full payment must be received before the tour start date</li>
                        <li>Cancellations made 30+ days before departure: 90% refund</li>
                        <li>Cancellations made 15-29 days before departure: 50% refund</li>
                        <li>Cancellations made less than 15 days: No refund</li>
                        <li>Travel insurance is highly recommended</li>
                    </ul>
                </div>
                
                <!-- Footer -->
                <div class="text-center mt-8 pt-8 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-2">Thank you for choosing HimalayaVoyage!</p>
                    <p class="text-xs text-gray-500">For questions, contact us at info@himalayavoyage.com or +977-1-4444444</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #invoice, #invoice * {
        visibility: visible;
    }
    #invoice {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
    }
    .no-print {
        display: none !important;
    }
    header, footer {
        display: none !important;
    }
}
</style>
@endpush