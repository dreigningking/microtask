<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            [
                'name' => 'Facebook',
                'slug' => 'facebook',
                'description' => 'Create posts, engage with content, and complete social media tasks on Facebook',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Twitter',
                'slug' => 'twitter',
                'description' => 'Tweet, retweet, like, and engage with content on Twitter',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Instagram',
                'slug' => 'instagram',
                'description' => 'Share photos, stories, and engage with posts on Instagram',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'WhatsApp',
                'slug' => 'whatsapp',
                'description' => 'Complete messaging and communication tasks on WhatsApp',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'YouTube',
                'slug' => 'youtube',
                'description' => 'Watch videos, like, subscribe, and complete YouTube engagement tasks',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'LinkedIn',
                'slug' => 'linkedin',
                'description' => 'Professional networking, posts, and LinkedIn engagement tasks',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'TikTok',
                'slug' => 'tiktok',
                'description' => 'Watch, like, share, and engage with TikTok content',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Custom Website',
                'slug' => 'custom-website',
                'description' => 'Complete tasks on custom websites and landing pages',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Mobile Games',
                'slug' => 'mobile-games',
                'description' => 'Complete tasks in mobile games and gaming platforms',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Survey Sites',
                'slug' => 'survey-sites',
                'description' => 'Complete surveys and feedback tasks on various survey platforms',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Review Platforms',
                'slug' => 'review-platforms',
                'description' => 'Write reviews and provide feedback on review platforms',
                'image' => null,
                'is_active' => true,
            ],
            [
                'name' => 'E-commerce',
                'slug' => 'e-commerce',
                'description' => 'Complete shopping and e-commerce related tasks',
                'image' => null,
                'is_active' => true,
            ],
        ];

        foreach ($platforms as $platform) {
            Platform::updateOrCreate(
                ['slug' => $platform['slug']],
                $platform
            );
        }

        $this->command->info('Platforms seeded successfully.');
    }
}
