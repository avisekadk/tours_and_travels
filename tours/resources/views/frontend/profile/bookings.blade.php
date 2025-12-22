{{-- resources/views/frontend/profile/bookings.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'My Bookings - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white mb-2">My Bookings</h1>
        <p class="text-white/90">View and manage all your tour bookings</p>
    </div>
</section>

<!-- Bookings Content -->
<section class="py-12">
    <div class="container mx-auto px-4">
        
        <!-- Filter Tabs -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('profile.bookings') }}" 
                   class="px-6 py-2 rounded-lg font-semibold transition {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All Bookings
                </a>
                <a href="{{ route('profile.bookings', ['status' => 'pending']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold transition {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Pending
                </a>
                <a href="{{ route('profile.bookings', ['status' => 'confirmed']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold transition {{ request('status') === 'confirmed' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Confirmed
                </a>
                <a href="{{ route('profile.bookings', ['status' => 'completed']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold transition {{ request('status') === 'completed' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Completed
                </a>
                <a href="{{ route('profile.bookings', ['status' => 'cancelled']) }}" 
                   class="px-6 py-2 rounded-lg font-semibold transition {{ request('status') === 'cancelled' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Cancelled
                </a>
            </div>
        </div>
        
        @if($bookings->count() > 0)
            <!-- Bookings List -->
            <div class="space-y-6">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="md:flex">
                            <!-- Tour Image -->
                            <div class="md:w-1/3">
                                @if($booking->tour->featured_image)
                                    <img src="{{ asset('storage/' . $booking->tour->featured_image) }}" 
                                         alt="{{ $booking->tour->title }}" 
                                         class="w-full h-64 md:h-full object-cover">
                                @else
                                    <div class="w-full h-64 md:h-full bg-gradient-to-br from-blue-400 to-purple-500"></div>
                                @endif
                            </div>
                            
                            <!-- Booking Details -->
                            <div class="md:w-2/3 p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $booking->tour->title }}</h2>
                                        <p class="text-gray-500">Booking #{{ $booking->booking_number }}</p>
                                    </div>
                                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                                        @if($booking->booking_status === 'confirmed') bg-green-100 text-green-700
                                        @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-700
                                        @else bg-blue-100 text-blue-700 @endif">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </div>
                                
                                <!-- Booking Info Grid -->
                                <div class="grid md:grid-cols-2 gap-4 mb-6">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Travel Date</p>
                                        <p class="font-semibold">{{ $booking->travel_date->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Duration</p>
                                        <p class="font-semibold">{{ $booking->tour->duration }} days</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Travelers</p>
                                        <p class="font-semibold">{{ $booking->number_of_people }} {{ Str::plural('person', $booking->number_of_people) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Total Amount</p>
                                        <p class="font-semibold text-blue-600 text-lg">${{ number_format($booking->total_amount, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Payment Status</p>
                                        <p class="font-semibold
                                            @if($booking->payment_status === 'paid') text-green-600
                                            @elseif($booking->payment_status === 'pending') text-yellow-600
                                            @else text-red-600 @endif">
                                            {{ ucfirst($booking->payment_status) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Booking Date</p>
                                        <p class="font-semibold">{{ $booking->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('profile.bookings.show', $booking) }}" 
                                       class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                        View Details
                                    </a>
                                    
                                    @if($booking->booking_status === 'confirmed' && $booking->payment_status === 'paid')
                                        <a href="{{ route('bookings.invoice', $booking) }}" 
                                           class="px-6 py-2 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition">
                                            Download Invoice
                                        </a>
                                    @endif
                                    
                                    @if($booking->booking_status === 'pending')
                                        <button onclick="if(confirm('Are you sure you want to cancel this booking?')) document.getElementById('cancel-form-{{ $booking->id }}').submit();" 
                                                class="px-6 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                                            Cancel Booking
                                        </button>
                                        <form id="cancel-form-{{ $booking->id }}" action="{{ route('bookings.cancel', $booking) }}" method="POST" class="hidden">
                                            @csrf
                                            <input type="hidden" name="cancellation_reason" value="Cancelled by user">
                                        </form>
                                    @endif
                                    
                                    @if($booking->booking_status === 'completed' && !$booking->tour->reviews()->where('user_id', auth()->id())->exists())
                                        <a href="{{ route('tours.show', $booking->tour->slug) }}#reviews" 
                                           class="px-6 py-2 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition">
                                            Write Review
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">📅</div>
                <h3 class="text-2xl font-bold mb-2">No bookings found</h3>
                <p class="text-gray-600 mb-6">Start planning your Nepal adventure today!</p>
                <a href="{{ route('tours.index') }}" 
                   class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Browse Tours
                </a>
            </div>
        @endif
    </div>
</section>

@endsection