<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tour_id' => Tour::factory(),
            'rating' => fake()->numberBetween(3, 5),
            'title' => fake()->sentence(4),
            'comment' => fake()->paragraph(3),
            'approved' => fake()->boolean(80),
        ];
    }
}