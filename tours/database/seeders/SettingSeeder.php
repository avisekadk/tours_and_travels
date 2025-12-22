<?php
// database/seeders/SettingSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'HimalayaVoyage',
                'group' => 'general',
                'type' => 'text',
                'description' => 'Website name',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Your Gateway to Himalayan Adventures',
                'group' => 'general',
                'type' => 'text',
                'description' => 'Website tagline',
            ],
            [
                'key' => 'site_email',
                'value' => 'info@himalayavoyage.com',
                'group' => 'general',
                'type' => 'text',
                'description' => 'Contact email',
            ],
            [
                'key' => 'site_phone',
                'value' => '+977-1-4444444',
                'group' => 'general',
                'type' => 'text',
                'description' => 'Contact phone',
            ],
            [
                'key' => 'site_address',
                'value' => 'Thamel, Kathmandu, Nepal',
                'group' => 'general',
                'type' => 'text',
                'description' => 'Business address',
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '+977-9841234567',
                'group' => 'general',
                'type' => 'text',
                'description' => 'WhatsApp contact number',
            ],
            
            // Social Media
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/himalayavoyage',
                'group' => 'social',
                'type' => 'text',
                'description' => 'Facebook page URL',
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/himalayavoyage',
                'group' => 'social',
                'type' => 'text',
                'description' => 'Instagram profile URL',
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/himalayavoyage',
                'group' => 'social',
                'type' => 'text',
                'description' => 'Twitter profile URL',
            ],
            [
                'key' => 'youtube_url',
                'value' => 'https://youtube.com/@himalayavoyage',
                'group' => 'social',
                'type' => 'text',
                'description' => 'YouTube channel URL',
            ],
            
            // Payment Gateway Settings
            [
                'key' => 'esewa_merchant_code',
                'value' => 'EPAYTEST',
                'group' => 'payment',
                'type' => 'text',
                'description' => 'eSewa merchant code',
            ],
            [
                'key' => 'esewa_secret_key',
                'value' => '8gBm/:&EnhH.1/q',
                'group' => 'payment',
                'type' => 'text',
                'description' => 'eSewa secret key',
            ],
            [
                'key' => 'khalti_public_key',
                'value' => 'test_public_key_...',
                'group' => 'payment',
                'type' => 'text',
                'description' => 'Khalti public key',
            ],
            [
                'key' => 'khalti_secret_key',
                'value' => 'test_secret_key_...',
                'group' => 'payment',
                'type' => 'text',
                'description' => 'Khalti secret key',
            ],
            
            // SEO Settings
            [
                'key' => 'meta_description',
                'value' => 'Discover Nepal with HimalayaVoyage. Book trekking, cultural tours, and adventure packages with expert guides.',
                'group' => 'seo',
                'type' => 'textarea',
                'description' => 'Default meta description',
            ],
            [
                'key' => 'meta_keywords',
                'value' => 'Nepal tours, Everest trek, Nepal travel, Himalayan adventure, trekking Nepal',
                'group' => 'seo',
                'type' => 'text',
                'description' => 'Default meta keywords',
            ],
            
            // Email Settings
            [
                'key' => 'admin_email',
                'value' => 'admin@himalayavoyage.com',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Admin notification email',
            ],
            [
                'key' => 'booking_notification_email',
                'value' => 'bookings@himalayavoyage.com',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Booking notification email',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}