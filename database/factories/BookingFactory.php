<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        $tour = Tour::factory()->create();
        $numberOfPeople = fake()->numberBetween(1, 5);
        $totalAmount = $tour->price * $numberOfPeople;

        return [
            'booking_number' => 'BK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'user_id' => User::factory(),
            'tour_id' => $tour->id,
            'booking_date' => now(),
            'travel_date' => fake()->dateTimeBetween('now', '+3 months'),
            'number_of_people' => $numberOfPeople,
            'tour_price' => $tour->price,
            'discount_amount' => 0,
            'total_amount' => $totalAmount,
            'payment_status' => fake()->randomElement(['pending', 'paid']),
            'booking_status' => fake()->randomElement(['pending', 'confirmed', 'completed']),
        ];
    }
}