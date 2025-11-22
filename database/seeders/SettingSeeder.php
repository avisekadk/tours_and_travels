<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'HimalayaVoyage', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_email', 'value' => 'info@himalayavoyage.com', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_phone', 'value' => '+977-1-4444444', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_address', 'value' => 'Thamel, Kathmandu, Nepal', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_description', 'value' => 'Premier Nepal tour operator specializing in trekking, cultural tours, and adventure packages.', 'group' => 'general', 'type' => 'textarea'],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/himalayavoyage', 'group' => 'social', 'type' => 'text'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/himalayavoyage', 'group' => 'social', 'type' => 'text'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/himalayavoyage', 'group' => 'social', 'type' => 'text'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/himalayavoyage', 'group' => 'social', 'type' => 'text'],
            ['key' => 'whatsapp_number', 'value' => '+977-9841234567', 'group' => 'social', 'type' => 'text'],
            
            // Payment Settings
            ['key' => 'esewa_merchant_code', 'value' => 'EPAYTEST', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'esewa_secret_key', 'value' => '8gBm/:&EnhH.1/q', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'khalti_public_key', 'value' => 'test_public_key', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'khalti_secret_key', 'value' => 'test_secret_key', 'group' => 'payment', 'type' => 'text'],
            
            // SEO Settings
            ['key' => 'meta_title', 'value' => 'HimalayaVoyage - Nepal Tours & Travel', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'meta_description', 'value' => 'Discover Nepal with expert guides. Book trekking, cultural tours, and adventure packages.', 'group' => 'seo', 'type' => 'textarea'],
            ['key' => 'meta_keywords', 'value' => 'Nepal tours, Everest trek, Nepal travel, Himalayan adventure', 'group' => 'seo', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}