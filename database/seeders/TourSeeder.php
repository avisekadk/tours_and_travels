<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $tours = [
            [
                'title' => 'Everest Base Camp Trek',
                'slug' => 'everest-base-camp-trek',
                'description' => 'Experience the ultimate Himalayan adventure with our Everest Base Camp trek. Walk in the footsteps of legendary mountaineers as you journey to the base of the world\'s highest peak.',
                'short_description' => 'Trek to the base of Mount Everest and experience breathtaking mountain views',
                'price' => 1299.00,
                'duration' => 14,
                'difficulty' => 'challenging',
                'max_people' => 12,
                'min_people' => 2,
                'location' => 'Everest Region',
                'category_id' => 1, // Trekking
                'destination_id' => 1, // Everest Region
                'status' => 'published',
                'featured' => true,
                'inclusions' => json_encode([
                    'Airport transfers',
                    'Accommodation in Kathmandu',
                    'Trekking permits',
                    'Experienced guide',
                    'Porter service',
                    'Meals during trek',
                ]),
                'exclusions' => json_encode([
                    'International flights',
                    'Travel insurance',
                    'Personal expenses',
                    'Tips for guides',
                ]),
                'highlights' => json_encode([
                    'Reach Everest Base Camp at 5,364m',
                    'Visit Namche Bazaar',
                    'Experience Sherpa culture',
                    'Stunning mountain views',
                ]),
            ],
            [
                'title' => 'Annapurna Circuit Trek',
                'slug' => 'annapurna-circuit-trek',
                'description' => 'The Annapurna Circuit is one of the world\'s great treks, offering an incredible diversity of landscapes and cultures.',
                'short_description' => 'Complete the classic Annapurna Circuit through diverse landscapes',
                'price' => 1199.00,
                'duration' => 17,
                'difficulty' => 'moderate',
                'max_people' => 15,
                'min_people' => 2,
                'location' => 'Annapurna Region',
                'category_id' => 1, // Trekking
                'destination_id' => 2, // Annapurna Region
                'status' => 'published',
                'featured' => true,
            ],
            [
                'title' => 'Kathmandu Cultural Tour',
                'slug' => 'kathmandu-cultural-tour',
                'description' => 'Explore the ancient temples, palaces, and UNESCO World Heritage sites of Kathmandu Valley.',
                'short_description' => 'Discover the rich cultural heritage of Kathmandu',
                'price' => 299.00,
                'duration' => 3,
                'difficulty' => 'easy',
                'max_people' => 20,
                'min_people' => 1,
                'location' => 'Kathmandu',
                'category_id' => 2, // Cultural Tours
                'destination_id' => 3, // Kathmandu Valley
                'status' => 'published',
                'featured' => true,
            ],
        ];

        foreach ($tours as $tour) {
            Tour::create($tour);
        }
    }
}