<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    // Initialize eSewa payment
    public function initiateEsewaPayment(Booking $booking)
    {
        $merchantCode = config('services.esewa.merchant_code', 'EPAYTEST');
        $secretKey = config('services.esewa.secret_key', '8gBm/:&EnhH.1/q');
        
        // Generate signature
        $message = "total_amount={$booking->total_amount},transaction_uuid={$booking->booking_number},product_code={$merchantCode}";
        $signature = base64_encode(hash_hmac('sha256', $message, $secretKey, true));
        
        return [
            'gateway_url' => config('services.esewa.url', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form'),
            'data' => [
                'amount' => $booking->tour_price,
                'tax_amount' => 0,
                'total_amount' => $booking->total_amount,
                'transaction_uuid' => $booking->booking_number,
                'product_code' => $merchantCode,
                'product_service_charge' => 0,
                'product_delivery_charge' => 0,
                'success_url' => route('payment.esewa.success'),
                'failure_url' => route('payment.esewa.failure'),
                'signed_field_names' => 'total_amount,transaction_uuid,product_code',
                'signature' => $signature,
            ],
        ];
    }

    // Verify eSewa payment
    public function verifyEsewaPayment($data)
    {
        try {
            $merchantCode = config('services.esewa.merchant_code', 'EPAYTEST');
            
            // Verify with eSewa API
            $response = Http::get(config('services.esewa.verification_url'), [
                'product_code' => $merchantCode,
                'total_amount' => $data['total_amount'],
                'transaction_uuid' => $data['transaction_uuid'],
            ]);
            
            if ($response->successful()) {
                $responseData = $response->json();
                
                if ($responseData['status'] === 'COMPLETE') {
                    // Find booking
                    $booking = Booking::where('booking_number', $data['transaction_uuid'])->first();
                    
                    if ($booking) {
                        // Update payment
                        $payment = Payment::where('booking_id', $booking->id)
                            ->where('payment_method', 'esewa')
                            ->latest()
                            ->first();
                        
                        if ($payment) {
                            $payment->update([
                                'transaction_id' => $responseData['transaction_code'] ?? null,
                                'payment_date' => now(),
                                'status' => 'success',
                                'gateway_response' => json_encode($responseData),
                            ]);
                        }
                        
                        // Update booking
                        $booking->update([
                            'payment_status' => 'paid',
                            'booking_status' => 'confirmed',
                            'confirmed_at' => now(),
                        ]);
                        
                        return true;
                    }
                }
            }
            
            return false;
            
        } catch (\Exception $e) {
            Log::error('eSewa payment verification failed: ' . $e->getMessage());
            return false;
        }
    }

    // Initialize Khalti payment
    public function initiateKhaltiPayment(Booking $booking)
    {
        return [
            'public_key' => config('services.khalti.public_key'),
            'amount' => $booking->total_amount * 100, // Khalti uses paisa (smallest unit)
            'product_identity' => $booking->booking_number,
            'product_name' => $booking->tour->title,
        ];
    }

    // Verify Khalti payment
    public function verifyKhaltiPayment($token, $amount, $bookingNumber)
    {
        try {
            $secretKey = config('services.khalti.secret_key');
            
            $response = Http::withHeaders([
                'Authorization' => 'Key ' . $secretKey,
            ])->post('https://khalti.com/api/v2/payment/verify/', [
                'token' => $token,
                'amount' => $amount,
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                $booking = Booking::where('booking_number', $bookingNumber)->first();
                
                if ($booking) {
                    // Update payment
                    $payment = Payment::where('booking_id', $booking->id)
                        ->where('payment_method', 'khalti')
                        ->latest()
                        ->first();
                    
                    if ($payment) {
                        $payment->update([
                            'transaction_id' => $data['idx'] ?? null,
                            'payment_date' => now(),
                            'status' => 'success',
                            'gateway_response' => json_encode($data),
                        ]);
                    }
                    
                    // Update booking
                    $booking->update([
                        'payment_status' => 'paid',
                        'booking_status' => 'confirmed',
                        'confirmed_at' => now(),
                    ]);
                    
                    return true;
                }
            }
            
            return false;
            
        } catch (\Exception $e) {
            Log::error('Khalti payment verification failed: ' . $e->getMessage());
            return false;
        }
    }
}