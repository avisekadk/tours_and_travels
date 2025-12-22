<?php
// database/seeders/DestinationSeeder.php

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
                'description' => 'Home to the world\'s highest peak, Mount Everest (8,848m), the Everest region offers spectacular mountain views, Sherpa culture, and world-class trekking routes including the famous Everest Base Camp trek.',
                'latitude' => 27.9881,
                'longitude' => 86.9250,
                'weather_city' => 'Namche Bazaar',
                'best_season' => 'March-May, September-November',
                'featured' => true,
                'status' => true,
                'meta_title' => 'Everest Region Tours & Treks | HimalayaVoyage',
                'meta_description' => 'Explore the Everest region with guided tours and treks. Experience Mount Everest, Sherpa culture, and breathtaking Himalayan views.',
            ],
            [
                'name' => 'Annapurna Region',
                'slug' => 'annapurna-region',
                'description' => 'The Annapurna region features diverse landscapes, from subtropical forests to alpine meadows. Popular treks include Annapurna Circuit and Annapurna Base Camp, offering stunning views of Annapurna, Dhaulagiri, and Machhapuchhre.',
                'latitude' => 28.5967,
                'longitude' => 83.8206,
                'weather_city' => 'Pokhara',
                'best_season' => 'March-May, September-November',
                'featured' => true,
                'status' => true,
                'meta_title' => 'Annapurna Region Tours | HimalayaVoyage',
                'meta_description' => 'Discover Annapurna region trekking and tours. Experience diverse landscapes and stunning mountain views.',
            ],
            [
                'name' => 'Kathmandu Valley',
                'slug' => 'kathmandu-valley',
                'description' => 'The cultural heart of Nepal, Kathmandu Valley is home to seven UNESCO World Heritage Sites including ancient temples, palaces, and stupas. Experience the vibrant mix of Hindu and Buddhist traditions in this historic valley.',
                'latitude' => 27.7172,
                'longitude' => 85.3240,
                'weather_city' => 'Kathmandu',
                'best_season' => 'October-March',
                'featured' => true,
                'status' => true,
                'meta_title' => 'Kathmandu Valley Cultural Tours | HimalayaVoyage',
                'meta_description' => 'Explore Kathmandu Valley UNESCO heritage sites, ancient temples, and vibrant culture.',
            ],
            [
                'name' => 'Pokhara',
                'slug' => 'pokhara',
                'description' => 'Nepal\'s adventure capital, Pokhara offers stunning views of the Annapurna range, serene Phewa Lake, and activities like paragliding, boating, and trekking. Gateway to many Annapurna region treks.',
                'latitude' => 28.2096,
                'longitude' => 83.9856,
                'weather_city' => 'Pokhara',
                'best_season' => 'September-May',
                'featured' => true,
                'status' => true,
                'meta_title' => 'Pokhara Tours & Adventures | HimalayaVoyage',
                'meta_description' => 'Experience Pokhara adventure activities, lake views, and mountain panoramas.',
            ],
            [
                'name' => 'Chitwan National Park',
                'slug' => 'chitwan-national-park',
                'description' => 'Nepal\'s first national park and UNESCO World Heritage Site, Chitwan is home to endangered one-horned rhinoceros, Bengal tigers, and diverse wildlife. Enjoy jungle safaris, canoe rides, and cultural experiences.',
                'latitude' => 27.5291,
                'longitude' => 84.3542,
                'weather_city' => 'Chitwan',
                'best_season' => 'October-March',
                'featured' => true,
                'status' => true,
                'meta_title' => 'Chitwan National Park Safari | HimalayaVoyage',
                'meta_description' => 'Experience wildlife safari in Chitwan National Park. See rhinos, tigers, and exotic birds.',
            ],
            [
                'name' => 'Langtang Region',
                'slug' => 'langtang-region',
                'description' => 'Close to Kathmandu, Langtang region offers beautiful trekking routes through rhododendron forests, traditional Tamang villages, and high mountain passes with views of Langtang Lirung and surrounding peaks.',
                'latitude' => 28.2096,
                'longitude' => 85.5500,
                'weather_city' => 'Langtang',
                'best_season' => 'March-May, September-November',
                'featured' => false,
                'status' => true,
                'meta_title' => 'Langtang Region Trekking | HimalayaVoyage',
                'meta_description' => 'Trek through Langtang region with stunning mountain views and Tamang culture.',
            ],
            [
                'name' => 'Lumbini',
                'slug' => 'lumbini',
                'description' => 'The birthplace of Lord Buddha and UNESCO World Heritage Site, Lumbini is a sacred pilgrimage destination. Visit the Maya Devi Temple, Ashoka Pillar, and numerous monasteries built by different countries.',
                'latitude' => 27.4833,
                'longitude' => 83.2833,
                'weather_city' => 'Lumbini',
                'best_season' => 'October-March',
                'featured' => false,
                'status' => true,
                'meta_title' => 'Lumbini Pilgrimage Tours | HimalayaVoyage',
                'meta_description' => 'Visit Lumbini, birthplace of Buddha. Pilgrimage tours to sacred Buddhist sites.',
            ],
            [
                'name' => 'Mustang',
                'slug' => 'mustang',
                'description' => 'The forbidden kingdom of Upper Mustang offers a unique Tibetan Buddhist culture, ancient cave dwellings, and dramatic desert-like landscapes. A restricted area requiring special permits.',
                'latitude' => 28.9833,
                'longitude' => 83.8833,
                'weather_city' => 'Jomsom',
                'best_season' => 'March-November',
                'featured' => false,
                'status' => true,
                'meta_title' => 'Mustang Tours | HimalayaVoyage',
                'meta_description' => 'Explore Upper Mustang forbidden kingdom with Tibetan culture and unique landscapes.',
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}