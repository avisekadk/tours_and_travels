<?php
// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Trekking',
                'slug' => 'trekking',
                'description' => 'Experience the majestic Himalayas with our guided trekking adventures. From easy walks to challenging expeditions.',
                'icon' => 'hiking',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'name' => 'Cultural Tours',
                'slug' => 'cultural-tours',
                'description' => 'Discover Nepal\'s rich cultural heritage, ancient temples, and vibrant traditions.',
                'icon' => 'temple',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'name' => 'Wildlife Safari',
                'slug' => 'wildlife-safari',
                'description' => 'Explore Nepal\'s diverse wildlife in national parks and conservation areas.',
                'icon' => 'elephant',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'name' => 'Adventure Sports',
                'slug' => 'adventure-sports',
                'description' => 'Thrilling adventure activities including paragliding, rafting, bungee jumping, and more.',
                'icon' => 'parachute',
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'name' => 'Mountain Climbing',
                'slug' => 'mountain-climbing',
                'description' => 'Conquer the world\'s highest peaks with expert guides and comprehensive support.',
                'icon' => 'mountain',
                'sort_order' => 5,
                'status' => true,
            ],
            [
                'name' => 'Helicopter Tours',
                'slug' => 'helicopter-tours',
                'description' => 'Experience Nepal from above with breathtaking helicopter tours to remote locations.',
                'icon' => 'helicopter',
                'sort_order' => 6,
                'status' => true,
            ],
            [
                'name' => 'Pilgrimage Tours',
                'slug' => 'pilgrimage-tours',
                'description' => 'Visit sacred sites and spiritual destinations across Nepal.',
                'icon' => 'prayer',
                'sort_order' => 7,
                'status' => true,
            ],
            [
                'name' => 'Luxury Tours',
                'slug' => 'luxury-tours',
                'description' => 'Premium travel experiences with 5-star accommodations and exclusive services.',
                'icon' => 'luxury',
                'sort_order' => 8,
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}