{{-- resources/views/frontend/bookings/confirmation.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'Booking Confirmed - HimalayaVoyage')

@section('content')

<!-- Success Header -->
<section class="bg-gradient-to-r from-green-500 to-green-600 py-20">
    <div class="container mx-auto px-4 text-center text-white">
        <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <h1 class="text-5xl font-bold mb-4">Booking Confirmed!</h1>
        <p class="text-xl">Your Nepal adventure is confirmed. Get ready for an amazing journey!</p>
    </div>
</section>

<!-- Booking Details -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <!-- Success Message -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold mb-4">Thank You, {{ $booking->user->name }}!</h2>
                    <p class="text-gray-600 text-lg">
                        Your booking has been confirmed. A confirmation email has been sent to 
                        <span class="font-semibold text-blue-600">{{ $booking->user->email }}</span>
                    </p>
                </div>
                
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-8">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">What's Next?</h3>
                            <ul class="text-sm text-gray-700 space-y-1">
                                <li>• You'll receive detailed trip information 7 days before departure</li>
                                <li>• Our team will contact you within 24 hours to confirm final details</li>
                                <li>• Download your invoice below for your records</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Reference -->
                <div class="text-center mb-8">
                    <p class="text-sm text-gray-600 mb-2">Your Booking Reference</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $booking->booking_number }}</p>
                </div>
                
                <!-- Tour Details -->
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-4">Tour Details</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tour:</span>
                                <span class="font-semibold text-right">{{ $booking->tour->title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-semibold">{{ $booking->tour->duration }} days</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Difficulty:</span>
                                <span class="font-semibold">{{ ucfirst($booking->tour->difficulty) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Destination:</span>
                                <span class="font-semibold">{{ $booking->tour->destination->name ?? 'Nepal' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-4">Booking Information</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Travel Date:</span>
                                <span class="font-semibold">{{ $booking->travel_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Return Date:</span>
                                <span class="font-semibold">{{ $booking->return_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Travelers:</span>
                                <span class="font-semibold">{{ $booking->number_of_people }} {{ Str::plural('person', $booking->number_of_people) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Amount:</span>
                                <span class="font-semibold text-lg text-blue-600">${{ number_format($booking->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($booking->special_requests)
                    <div class="mb-8">
                        <h3 class="font-semibold text-gray-800 mb-3">Special Requests</h3>
                        <div class="bg-gray-50 p-4 rounded-lg text-sm text-gray-700">
                            {{ $booking->special_requests }}
                        </div>
                    </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('bookings.invoice', $booking) }}" 
                       class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition text-center">
                        Download Invoice
                    </a>
                    <a href="{{ route('profile.bookings') }}" 
                       class="px-8 py-3 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition text-center">
                        View All Bookings
                    </a>
                    <a href="{{ route('tours.index') }}" 
                       class="px-8 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition text-center">
                        Browse More Tours
                    </a>
                </div>
            </div>
            
            <!-- Contact Support -->
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <h3 class="text-xl font-bold mb-4">Need Help?</h3>
                <p class="text-gray-600 mb-6">Our team is here to assist you with any questions about your booking.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="tel:+97714444444" class="px-6 py-3 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition">
                        📞 Call Us: +977-1-4444444
                    </a>
                    <a href="mailto:info@himalayavoyage.com" class="px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition">
                        📧 Email Support
                    </a>
                    <a href="https://wa.me/9779841234567" target="_blank" class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                        💬 WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection