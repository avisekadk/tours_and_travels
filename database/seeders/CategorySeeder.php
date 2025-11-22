<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Trekking',
                'slug' => 'trekking',
                'description' => 'Experience the majestic Himalayan mountains through our trekking packages',
                'icon' => 'hiking',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'name' => 'Cultural Tours',
                'slug' => 'cultural-tours',
                'description' => 'Explore the rich cultural heritage of Nepal',
                'icon' => 'temple',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'name' => 'Adventure Sports',
                'slug' => 'adventure-sports',
                'description' => 'Thrilling adventure activities for adrenaline seekers',
                'icon' => 'parachute',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'name' => 'Wildlife Tours',
                'slug' => 'wildlife-tours',
                'description' => 'Discover Nepal\'s diverse wildlife and national parks',
                'icon' => 'paw',
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'name' => 'Pilgrimage Tours',
                'slug' => 'pilgrimage-tours',
                'description' => 'Visit sacred sites and spiritual destinations',
                'icon' => 'om',
                'sort_order' => 5,
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}