{{-- resources/views/frontend/bookings/create.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'Book ' . $tour->title . ' - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white mb-2">Complete Your Booking</h1>
        <p class="text-white/90">Just a few steps to confirm your adventure</p>
    </div>
</section>

<!-- Booking Form -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-3 gap-8">
                
                <!-- Booking Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold mb-6">Booking Details</h2>
                        
                        <form action="{{ route('bookings.store') }}" method="POST" id="booking-form">
                            @csrf
                            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                            
                            <!-- Step 1: Travel Details -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold mb-4 flex items-center">
                                    <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center mr-3 text-sm">1</span>
                                    Travel Details
                                </h3>
                                
                                <div class="space-y-4">
                                    <!-- Travel Date -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Travel Date *</label>
                                        <input type="date" 
                                               name="travel_date" 
                                               value="{{ old('travel_date') }}"
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('travel_date') border-red-500 @enderror"
                                               required>
                                        @error('travel_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Number of People -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Number of Travelers *</label>
                                        <div class="flex items-center gap-4">
                                            <button type="button" onclick="decrementPeople()" 
                                                    class="w-12 h-12 bg-gray-200 rounded-lg font-bold hover:bg-gray-300 transition">
                                                -
                                            </button>
                                            <input type="number" 
                                                   name="number_of_people" 
                                                   id="number_of_people"
                                                   value="{{ old('number_of_people', 2) }}"
                                                   min="{{ $tour->min_people }}"
                                                   max="{{ $tour->max_people ?? 50 }}"
                                                   class="w-24 text-center px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('number_of_people') border-red-500 @enderror"
                                                   required
                                                   onchange="updatePrice()">
                                            <button type="button" onclick="incrementPeople()" 
                                                    class="w-12 h-12 bg-gray-200 rounded-lg font-bold hover:bg-gray-300 transition">
                                                +
                                            </button>
                                            <span class="text-sm text-gray-500">
                                                (Min: {{ $tour->min_people }}, Max: {{ $tour->max_people ?? 50 }})
                                            </span>
                                        </div>
                                        @error('number_of_people')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 2: Special Requests -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold mb-4 flex items-center">
                                    <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center mr-3 text-sm">2</span>
                                    Special Requests (Optional)
                                </h3>
                                
                                <textarea name="special_requests" 
                                          rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                          placeholder="Any dietary requirements, allergies, or special requests...">{{ old('special_requests') }}</textarea>
                            </div>
                            
                            <!-- Step 3: Contact Information -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold mb-4 flex items-center">
                                    <span class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center mr-3 text-sm">3</span>
                                    Contact Information
                                </h3>
                                
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-2">Booking confirmation will be sent to:</p>
                                    <p class="font-semibold">{{ auth()->user()->name }}</p>
                                    <p class="text-gray-700">{{ auth()->user()->email }}</p>
                                    <p class="text-gray-700">{{ auth()->user()->phone }}</p>
                                    <a href="{{ route('profile.edit') }}" class="text-sm text-blue-600 hover:text-blue-700 mt-2 inline-block">
                                        Update contact information →
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Terms and Conditions -->
                            <div class="mb-6">
                                <label class="flex items-start">
                                    <input type="checkbox" name="terms" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1" required>
                                    <span class="ml-3 text-sm text-gray-700">
                                        I agree to the <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">Terms and Conditions</a> 
                                        and <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">Cancellation Policy</a>
                                    </span>
                                </label>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full px-6 py-4 bg-blue-600 text-white rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
                                Proceed to Payment
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Booking Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                        <h3 class="text-xl font-bold mb-4">Booking Summary</h3>
                        
                        <!-- Tour Image -->
                        <div class="mb-4 rounded-lg overflow-hidden">
                            @if($tour->featured_image)
                                <img src="{{ asset('storage/' . $tour->featured_image) }}" 
                                     alt="{{ $tour->title }}" 
                                     class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gradient-to-br from-blue-400 to-purple-500"></div>
                            @endif
                        </div>
                        
                        <!-- Tour Info -->
                        <h4 class="font-bold text-gray-800 mb-4">{{ $tour->title }}</h4>
                        
                        <div class="space-y-3 text-sm mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-semibold">{{ $tour->duration }} days</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Difficulty:</span>
                                <span class="font-semibold">{{ ucfirst($tour->difficulty) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Destination:</span>
                                <span class="font-semibold">{{ $tour->destination->name ?? 'Nepal' }}</span>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <!-- Price Breakdown -->
                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Price per person:</span>
                                <span class="font-semibold" id="price-per-person">${{ number_format($tour->display_price, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Number of people:</span>
                                <span class="font-semibold" id="display-people">2</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-semibold" id="subtotal">${{ number_format($tour->display_price * 2, 2) }}</span>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold">Total:</span>
                            <span class="text-2xl font-bold text-blue-600" id="total-price">${{ number_format($tour->display_price * 2, 2) }}</span>
                        </div>
                        
                        <!-- Trust Badges -->
                        <div class="mt-6 pt-6 border-t space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Secure booking
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Instant confirmation
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Free cancellation
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const tourPrice = {{ $tour->display_price }};
const minPeople = {{ $tour->min_people }};
const maxPeople = {{ $tour->max_people ?? 50 }};

function updatePrice() {
    const people = parseInt(document.getElementById('number_of_people').value);
    const subtotal = tourPrice * people;
    
    document.getElementById('display-people').textContent = people;
    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    document.getElementById('total-price').textContent = '$' + subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function incrementPeople() {
    const input = document.getElementById('number_of_people');
    let value = parseInt(input.value);
    if (value < maxPeople) {
        input.value = value + 1;
        updatePrice();
    }
}

function decrementPeople() {
    const input = document.getElementById('number_of_people');
    let value = parseInt(input.value);
    if (value > minPeople) {
        input.value = value - 1;
        updatePrice();
    }
}

// Update price on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePrice();
});
</script>
@endpush