<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'description' => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 500, 5000),
            'duration' => fake()->numberBetween(3, 21),
            'difficulty' => fake()->randomElement(['easy', 'moderate', 'challenging', 'difficult']),
            'max_people' => fake()->numberBetween(5, 20),
            'min_people' => 1,
            'location' => fake()->city(),
            'category_id' => Category::factory(),
            'destination_id' => Destination::factory(),
            'status' => 'published',
            'featured' => fake()->boolean(30),
            'views' => fake()->numberBetween(0, 1000),
        ];
    }
}