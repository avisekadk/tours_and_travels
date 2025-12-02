<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'tour_id' => 'required|exists:tours,id',
            'travel_date' => 'required|date|after:today',
            'number_of_people' => 'required|integer|min:1|max:50',
            'payment_method' => 'required|in:esewa,khalti,paypal,stripe',
            'special_requests' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'tour_id.required' => 'Please select a tour',
            'travel_date.required' => 'Travel date is required',
            'travel_date.after' => 'Travel date must be in the future',
            'number_of_people.required' => 'Number of people is required',
            'number_of_people.max' => 'Maximum 50 people allowed per booking',
            'payment_method.required' => 'Please select a payment method',
        ];
    }
}