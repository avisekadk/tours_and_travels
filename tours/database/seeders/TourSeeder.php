<?php
// database/seeders/TourSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Destination;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $trekkingCategory = Category::where('slug', 'trekking')->first();
        $culturalCategory = Category::where('slug', 'cultural-tours')->first();
        $wildlifeCategory = Category::where('slug', 'wildlife-safari')->first();
        
        $everest = Destination::where('slug', 'everest-region')->first();
        $annapurna = Destination::where('slug', 'annapurna-region')->first();
        $kathmandu = Destination::where('slug', 'kathmandu-valley')->first();
        $chitwan = Destination::where('slug', 'chitwan-national-park')->first();
        $pokhara = Destination::where('slug', 'pokhara')->first();

        $tours = [
            [
                'title' => 'Everest Base Camp Trek',
                'slug' => 'everest-base-camp-trek',
                'short_description' => 'Experience the ultimate Himalayan adventure with a trek to the base of the world\'s highest mountain. Witness stunning mountain views and Sherpa culture.',
                'description' => '<p>The Everest Base Camp trek is one of the most iconic trekking adventures in the world. This 14-day journey takes you through the heart of the Khumbu region, home to the legendary Sherpa people and the world\'s highest peaks.</p><p>Starting from Lukla, you\'ll trek through beautiful rhododendron forests, cross high suspension bridges over roaring rivers, and pass through traditional Sherpa villages including Namche Bazaar, the bustling mountain trading center.</p><p>The highlight of the trek is reaching Everest Base Camp at 5,364 meters, where you\'ll stand at the foot of the mighty Mount Everest. For an even more spectacular view, we\'ll climb Kala Patthar (5,545m) at sunrise to witness the golden light illuminating Everest, Lhotse, and Nuptse.</p><p>This trek requires good physical fitness but no technical climbing skills. Our experienced guides will ensure your safety and comfort throughout the journey.</p>',
                'price' => 1299.00,
                'sale_price' => 1199.00,
                'duration' => 14,
                'difficulty' => 'challenging',
                'max_people' => 12,
                'min_people' => 2,
                'location' => 'Everest Region, Nepal',
                'category_id' => $trekkingCategory->id,
                'destination_id' => $everest->id,
                'status' => 'published',
                'featured' => true,
                'itinerary' => [
                    ['day' => 1, 'title' => 'Arrival in Kathmandu', 'description' => 'Welcome to Nepal! Transfer to hotel, trip briefing, and equipment check.'],
                    ['day' => 2, 'title' => 'Fly to Lukla and Trek to Phakding', 'description' => 'Scenic mountain flight to Lukla (2,840m). Begin trek to Phakding (2,610m). 3-4 hours walking.'],
                    ['day' => 3, 'title' => 'Trek to Namche Bazaar', 'description' => 'Trek through beautiful forests and cross suspension bridges. Climb to Namche Bazaar (3,440m). 5-6 hours.'],
                    ['day' => 4, 'title' => 'Acclimatization Day in Namche', 'description' => 'Acclimatization hike to Everest View Hotel. Explore Namche market and museums.'],
                    ['day' => 5, 'title' => 'Trek to Tengboche', 'description' => 'Trek to Tengboche (3,860m) with stunning mountain views. Visit famous monastery. 5-6 hours.'],
                    ['day' => 6, 'title' => 'Trek to Dingboche', 'description' => 'Descend to Deboche, cross river, and climb to Dingboche (4,410m). 5-6 hours.'],
                    ['day' => 7, 'title' => 'Acclimatization in Dingboche', 'description' => 'Hike to Nangkartshang Peak (5,083m) for acclimatization and mountain views.'],
                    ['day' => 8, 'title' => 'Trek to Lobuche', 'description' => 'Trek through the Khumbu Glacier moraine to Lobuche (4,910m). 5-6 hours.'],
                    ['day' => 9, 'title' => 'Trek to Gorak Shep and EBC', 'description' => 'Trek to Gorak Shep, lunch, then continue to Everest Base Camp (5,364m). Return to Gorak Shep. 7-8 hours.'],
                    ['day' => 10, 'title' => 'Kala Patthar and Trek to Pheriche', 'description' => 'Early morning climb to Kala Patthar (5,545m) for sunrise view. Descend to Pheriche. 7-8 hours.'],
                    ['day' => 11, 'title' => 'Trek to Namche Bazaar', 'description' => 'Long descent back to Namche Bazaar. 6-7 hours.'],
                    ['day' => 12, 'title' => 'Trek to Lukla', 'description' => 'Final day of trekking back to Lukla. Celebration dinner. 6-7 hours.'],
                    ['day' => 13, 'title' => 'Fly Back to Kathmandu', 'description' => 'Morning flight to Kathmandu. Free afternoon for shopping and relaxation.'],
                    ['day' => 14, 'title' => 'Departure', 'description' => 'Transfer to airport for your onward journey.'],
                ],
                'inclusions' => [
                    'Airport transfers',
                    'Domestic flights (Kathmandu-Lukla-Kathmandu)',
                    'Accommodation in tea houses during trek',
                    '3 meals a day during trek',
                    'Experienced trekking guide and porter',
                    'All permits and fees',
                    'First aid kit and oxygen cylinder',
                    'Travel and rescue insurance for staff',
                ],
                'exclusions' => [
                    'International airfare',
                    'Nepal visa fee',
                    'Travel insurance',
                    'Personal expenses',
                    'Alcoholic beverages',
                    'Tips for guide and porter',
                    'Emergency evacuation',
                ],
                'highlights' => [
                    'Stand at Everest Base Camp (5,364m)',
                    'Sunrise view from Kala Patthar (5,545m)',
                    'Visit Tengboche Monastery',
                    'Experience Sherpa culture in Namche Bazaar',
                    'Spectacular mountain views including Everest, Lhotse, Ama Dablam',
                    'Fly into Lukla - world\'s most thrilling airport',
                ],
                'important_notes' => [
                    'Good physical fitness required',
                    'Risk of altitude sickness - proper acclimatization essential',
                    'Weather can be unpredictable - flights may be delayed',
                    'Basic accommodation in tea houses',
                    'Limited phone/internet connectivity',
                ],
                'meta_title' => 'Everest Base Camp Trek 14 Days | HimalayaVoyage',
                'meta_description' => 'Trek to Everest Base Camp in 14 days. Experience stunning Himalayan views, Sherpa culture, and the adventure of a lifetime.',
            ],
            [
                'title' => 'Annapurna Base Camp Trek',
                'slug' => 'annapurna-base-camp-trek',
                'short_description' => 'Journey to the heart of the Annapurna Sanctuary with spectacular views of the Annapurna range and diverse landscapes.',
                'description' => '<p>The Annapurna Base Camp trek offers an incredible journey through diverse landscapes, from lush subtropical forests to high alpine terrain. This trek takes you into the Annapurna Sanctuary, a glacial basin surrounded by towering peaks.</p><p>Walk through traditional Gurung villages, terraced rice fields, and beautiful rhododendron forests. Experience the hospitality of local communities and learn about their culture and traditions.</p><p>The highlight is reaching Annapurna Base Camp at 4,130 meters, where you\'ll be surrounded by a 360-degree amphitheater of snow-capped peaks including Annapurna I (8,091m), Hiunchuli, and Machhapuchhre (Fishtail).</p>',
                'price' => 899.00,
                'sale_price' => null,
                'duration' => 12,
                'difficulty' => 'moderate',
                'max_people' => 15,
                'min_people' => 2,
                'location' => 'Annapurna Region, Nepal',
                'category_id' => $trekkingCategory->id,
                'destination_id' => $annapurna->id,
                'status' => 'published',
                'featured' => true,
                'inclusions' => [
                    'Airport transfers',
                    'Private transportation to/from Pokhara',
                    'Accommodation in tea houses',
                    'All meals during trek',
                    'Experienced guide and porter',
                    'Permits and fees',
                    'First aid kit',
                ],
                'exclusions' => [
                    'International flights',
                    'Visa fees',
                    'Travel insurance',
                    'Personal expenses',
                    'Tips',
                ],
                'highlights' => [
                    'Reach Annapurna Base Camp at 4,130m',
                    'Natural hot springs at Jhinu Danda',
                    'Sunrise view from Poon Hill',
                    'Diverse landscapes from subtropical to alpine',
                    '360-degree mountain panorama',
                ],
                'meta_title' => 'Annapurna Base Camp Trek 12 Days | HimalayaVoyage',
                'meta_description' => 'Trek to Annapurna Base Camp through diverse landscapes. Experience mountain views and local culture.',
            ],
            [
                'title' => 'Kathmandu Valley Cultural Tour',
                'slug' => 'kathmandu-valley-cultural-tour',
                'short_description' => 'Explore UNESCO World Heritage Sites including ancient temples, palaces, and stupas in the cultural heart of Nepal.',
                'description' => '<p>Discover the rich cultural heritage of Kathmandu Valley with visits to seven UNESCO World Heritage Sites. This comprehensive tour takes you through centuries of history, art, and architecture.</p><p>Visit Swayambhunath (Monkey Temple) perched atop a hill with panoramic valley views. Explore the ancient city of Bhaktapur with its well-preserved medieval architecture. Marvel at Pashupatinath Temple, one of the holiest Hindu temples, and Boudhanath Stupa, one of the largest Buddhist stupas in the world.</p><p>Experience the vibrant street life of Kathmandu, taste authentic Nepali cuisine, and interact with locals to understand their way of life. This tour is perfect for those interested in culture, history, and spirituality.</p>',
                'price' => 299.00,
                'sale_price' => 249.00,
                'duration' => 4,
                'difficulty' => 'easy',
                'max_people' => 20,
                'min_people' => 1,
                'location' => 'Kathmandu Valley, Nepal',
                'category_id' => $culturalCategory->id,
                'destination_id' => $kathmandu->id,
                'status' => 'published',
                'featured' => true,
                'inclusions' => [
                    'Airport transfers',
                    'Hotel accommodation in Kathmandu',
                    'Private vehicle with driver',
                    'Professional tour guide',
                    'All entrance fees',
                    'Breakfast daily',
                ],
                'exclusions' => [
                    'International flights',
                    'Lunch and dinner',
                    'Personal expenses',
                    'Tips',
                ],
                'highlights' => [
                    'Visit 7 UNESCO World Heritage Sites',
                    'Swayambhunath Stupa (Monkey Temple)',
                    'Pashupatinath Temple',
                    'Boudhanath Stupa',
                    'Bhaktapur Durbar Square',
                    'Patan Durbar Square',
                    'Kathmandu Durbar Square',
                ],
                'meta_title' => 'Kathmandu Valley Cultural Tour 4 Days | HimalayaVoyage',
                'meta_description' => 'Explore Kathmandu Valley UNESCO heritage sites, ancient temples, and vibrant culture in 4 days.',
            ],
            [
                'title' => 'Chitwan Jungle Safari',
                'slug' => 'chitwan-jungle-safari',
                'short_description' => 'Experience Nepal\'s incredible wildlife including one-horned rhinos, Bengal tigers, and diverse bird species in Chitwan National Park.',
                'description' => '<p>Chitwan National Park, Nepal\'s first national park and a UNESCO World Heritage Site, offers an unforgettable wildlife experience. This jungle safari takes you deep into the tropical and subtropical forests where you can spot endangered species in their natural habitat.</p><p>Enjoy elephant-back safaris, jeep drives through the jungle, canoe rides on the Rapti River, and guided jungle walks. Visit the elephant breeding center and learn about conservation efforts. Experience the rich biodiversity including one-horned rhinoceros, Bengal tigers, leopards, sloth bears, and over 500 species of birds.</p><p>Stay in comfortable jungle lodges and enjoy cultural performances by the indigenous Tharu community. This tour combines wildlife adventure with cultural immersion in a beautiful natural setting.</p>',
                'price' => 449.00,
                'sale_price' => 399.00,
                'duration' => 3,
                'difficulty' => 'easy',
                'max_people' => 16,
                'min_people' => 2,
                'location' => 'Chitwan National Park, Nepal',
                'category_id' => $wildlifeCategory->id,
                'destination_id' => $chitwan->id,
                'status' => 'published',
                'featured' => true,
                'inclusions' => [
                    'Transportation from Kathmandu',
                    'Jungle lodge accommodation',
                    'All meals',
                    'All jungle activities',
                    'Professional naturalist guide',
                    'Park entrance fees',
                ],
                'exclusions' => [
                    'Alcoholic beverages',
                    'Personal expenses',
                    'Tips',
                ],
                'highlights' => [
                    'Elephant-back safari',
                    'Jeep safari in the jungle',
                    'Canoe ride on Rapti River',
                    'Bird watching',
                    'Tharu cultural dance',
                    'Spot one-horned rhinos and Bengal tigers',
                ],
                'meta_title' => 'Chitwan Jungle Safari 3 Days | HimalayaVoyage',
                'meta_description' => 'Experience wildlife safari in Chitwan National Park. See rhinos, tigers, and exotic birds in 3 days.',
            ],
            [
                'title' => 'Pokhara Adventure Package',
                'slug' => 'pokhara-adventure-package',
                'short_description' => 'Enjoy paragliding, zip-lining, boating, and hiking in Nepal\'s adventure capital with stunning mountain views.',
                'description' => '<p>Pokhara, Nepal\'s adventure capital, offers a perfect blend of natural beauty and adrenaline-pumping activities. This package lets you experience the best of Pokhara\'s adventures while enjoying the stunning backdrop of the Annapurna mountain range.</p><p>Start your day with a peaceful boat ride on Phewa Lake, then get your adrenaline pumping with paragliding from Sarangkot, offering bird\'s-eye views of the valley and mountains. Try zip-lining, one of the world\'s steepest and fastest, or go white-water rafting on the Seti River.</p><p>Take an early morning hike to Sarangkot for a spectacular sunrise view over the Himalayas, explore Davis Falls and Gupteshwor Cave, and visit the World Peace Pagoda. Evenings are perfect for strolling along Lakeside, enjoying the vibrant cafes and restaurants.</p>',
                'price' => 549.00,
                'sale_price' => null,
                'duration' => 4,
                'difficulty' => 'easy',
                'max_people' => 10,
                'min_people' => 1,
                'location' => 'Pokhara, Nepal',
                'category_id' => Category::where('slug', 'adventure-sports')->first()->id,
                'destination_id' => $pokhara->id,
                'status' => 'published',
                'featured' => false,
                'inclusions' => [
                    'Airport/bus station transfers',
                    'Hotel accommodation',
                    'Breakfast daily',
                    'Paragliding with photos/videos',
                    'Zip-lining',
                    'Boat ride on Phewa Lake',
                    'Guided city tour',
                ],
                'exclusions' => [
                    'Lunch and dinner',
                    'Other activities not mentioned',
                    'Personal expenses',
                    'Tips',
                ],
                'highlights' => [
                    'Paragliding with Annapurna views',
                    'World\'s steepest zip-line',
                    'Sunrise from Sarangkot',
                    'Boat ride on Phewa Lake',
                    'Visit World Peace Pagoda',
                    'Explore Davis Falls and caves',
                ],
                'meta_title' => 'Pokhara Adventure Package 4 Days | HimalayaVoyage',
                'meta_description' => 'Experience Pokhara adventures including paragliding, zip-lining, and mountain views in 4 days.',
            ],
        ];

        foreach ($tours as $tour) {
            Tour::create($tour);
        }
    }
}