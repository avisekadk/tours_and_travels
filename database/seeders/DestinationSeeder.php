<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Everest Region',
                'slug' => 'everest-region',
                'description' => 'Home to the world\'s highest peak, Mount Everest. Experience breathtaking views and rich Sherpa culture.',
                'latitude' => 27.9881,
                'longitude' => 86.9250,
                'featured' => true,
                'status' => true,
                'weather_city' => 'Namche Bazaar',
                'best_season' => 'October to December, March to May',
            ],
            [
                'name' => 'Annapurna Region',
                'slug' => 'annapurna-region',
                'description' => 'Famous for diverse landscapes, from subtropical valleys to alpine meadows.',
                'latitude' => 28.5967,
                'longitude' => 83.8206,
                'featured' => true,
                'status' => true,
                'weather_city' => 'Pokhara',
                'best_season' => 'October to November, March to April',
            ],
            [
                'name' => 'Kathmandu Valley',
                'slug' => 'kathmandu-valley',
                'description' => 'UNESCO World Heritage sites and ancient temples in Nepal\'s capital.',
                'latitude' => 27.7172,
                'longitude' => 85.3240,
                'featured' => true,
                'status' => true,
                'weather_city' => 'Kathmandu',
                'best_season' => 'September to November, February to April',
            ],
            [
                'name' => 'Pokhara',
                'slug' => 'pokhara',
                'description' => 'Gateway to Annapurna region with stunning lakes and mountain views.',
                'latitude' => 28.2096,
                'longitude' => 83.9856,
                'featured' => true,
                'status' => true,
                'weather_city' => 'Pokhara',
                'best_season' => 'October to April',
            ],
            [
                'name' => 'Chitwan National Park',
                'slug' => 'chitwan-national-park',
                'description' => 'Home to Bengal tigers, one-horned rhinos, and diverse wildlife.',
                'latitude' => 27.5291,
                'longitude' => 84.3542,
                'featured' => false,
                'status' => true,
                'weather_city' => 'Chitwan',
                'best_season' => 'October to March',
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}