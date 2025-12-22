{{-- resources/views/frontend/bookings/payment.blade.php --}}
@extends('frontend.layouts.master')

@section('title', 'Payment - HimalayaVoyage')

@section('content')

<!-- Page Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-12">
    <div class="container mx-auto px-4 text-center text-white">
        <h1 class="text-4xl font-bold mb-2">Select Payment Method</h1>
        <p class="text-white/90">Booking #{{ $booking->booking_number }}</p>
    </div>
</section>

<!-- Payment Options -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <!-- Booking Summary -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $booking->tour->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $booking->number_of_people }} travelers • {{ $booking->travel_date->format('M d, Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Total Amount</p>
                        <p class="text-3xl font-bold text-blue-600">${{ number_format($booking->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Payment Methods -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Choose Payment Method</h2>
                
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    
                    <!-- eSewa -->
                    <button onclick="selectPayment('esewa')" 
                            class="payment-option border-2 border-gray-200 rounded-xl p-6 hover:border-blue-500 hover:shadow-lg transition">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl">💳</div>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">eSewa</h3>
                        <p class="text-sm text-gray-600">Pay with eSewa digital wallet</p>
                    </button>
                    
                    <!-- Khalti -->
                    <button onclick="selectPayment('khalti')" 
                            class="payment-option border-2 border-gray-200 rounded-xl p-6 hover:border-blue-500 hover:shadow-lg transition">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl">💳</div>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Khalti</h3>
                        <p class="text-sm text-gray-600">Pay with Khalti digital wallet</p>
                    </button>
                    
                    <!-- PayPal -->
                    <button onclick="selectPayment('paypal')" 
                            class="payment-option border-2 border-gray-200 rounded-xl p-6 hover:border-blue-500 hover:shadow-lg transition">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl">💰</div>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">PayPal</h3>
                        <p class="text-sm text-gray-600">Pay with PayPal account or card</p>
                    </button>
                    
                    <!-- Stripe (Credit/Debit Card) -->
                    <button onclick="selectPayment('stripe')" 
                            class="payment-option border-2 border-gray-200 rounded-xl p-6 hover:border-blue-500 hover:shadow-lg transition">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl">💳</div>
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Credit/Debit Card</h3>
                        <p class="text-sm text-gray-600">Pay with Visa, Mastercard, Amex</p>
                    </button>
                </div>
                
                <!-- Hidden Forms for Payment Gateways -->
                
                <!-- eSewa Form (Hidden) -->
                <form id="esewa-form" action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST" class="hidden">
                    <input type="hidden" name="amount" value="{{ $booking->tour_price }}">
                    <input type="hidden" name="tax_amount" value="0">
                    <input type="hidden" name="total_amount" value="{{ $booking->total_amount }}">
                    <input type="hidden" name="transaction_uuid" value="{{ $booking->booking_number }}">
                    <input type="hidden" name="product_code" value="EPAYTEST">
                    <input type="hidden" name="product_service_charge" value="0">
                    <input type="hidden" name="product_delivery_charge" value="0">
                    <input type="hidden" name="success_url" value="{{ route('payment.esewa.success') }}">
                    <input type="hidden" name="failure_url" value="{{ route('payment.esewa.failure') }}">
                    <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
                    <input type="hidden" name="signature" value="">
                </form>
                
                <!-- Security Info -->
                <div class="mt-8 pt-6 border-t">
                    <div class="flex items-center justify-center gap-8 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Secure Payment
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            SSL Encrypted
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            100% Safe
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cancel Booking -->
            <div class="text-center mt-8">
                <a href="{{ route('profile.bookings') }}" class="text-gray-600 hover:text-gray-800">
                    ← Back to Bookings
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<!-- Khalti Checkout -->
<script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>

<script>
function selectPayment(method) {
    if (method === 'esewa') {
        document.getElementById('esewa-form').submit();
    } else if (method === 'khalti') {
        initiateKhalti();
    } else if (method === 'paypal') {
        alert('PayPal integration coming soon!');
    } else if (method === 'stripe') {
        alert('Credit/Debit Card payment coming soon!');
    }
}

// Khalti Configuration
var config = {
    "publicKey": "{{ config('services.khalti.public_key') }}",
    "productIdentity": "{{ $booking->booking_number }}",
    "productName": "{{ $booking->tour->title }}",
    "productUrl": "{{ route('tours.show', $booking->tour->slug) }}",
    "paymentPreference": ["KHALTI", "EBANKING", "MOBILE_BANKING", "CONNECT_IPS", "SCT"],
    "eventHandler": {
        onSuccess(payload) {
            console.log(payload);
            // Send payload to backend for verification
            fetch("{{ route('payment.khalti.verify') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    token: payload.token,
                    amount: payload.amount,
                    booking_number: "{{ $booking->booking_number }}"
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    alert('Payment verification failed. Please contact support.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        },
        onError(error) {
            console.log(error);
            alert('Payment failed. Please try again.');
        },
        onClose() {
            console.log('Widget is closing');
        }
    }
};

var checkout = new KhaltiCheckout(config);

function initiateKhalti() {
    checkout.show({ amount: {{ $booking->total_amount * 100 }} });
}
</script>
@endpush