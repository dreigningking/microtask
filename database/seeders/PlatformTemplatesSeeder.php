<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlatformTemplate;
use App\Models\Platform;

class PlatformTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get platform IDs
        $facebook = Platform::where('slug', 'facebook')->first();
        $twitter = Platform::where('slug', 'twitter')->first();
        $instagram = Platform::where('slug', 'instagram')->first();
        $youtube = Platform::where('slug', 'youtube')->first();
        $linkedin = Platform::where('slug', 'linkedin')->first();
        $tiktok = Platform::where('slug', 'tiktok')->first();
        $whatsapp = Platform::where('slug', 'whatsapp')->first();
        $customWebsite = Platform::where('slug', 'custom-website')->first();
        $mobileGames = Platform::where('slug', 'mobile-games')->first();
        $surveySites = Platform::where('slug', 'survey-sites')->first();
        $reviewPlatforms = Platform::where('slug', 'review-platforms')->first();
        $ecommerce = Platform::where('slug', 'e-commerce')->first();

        $templates = [
            // Facebook Templates
            [
                'platform_id' => $facebook->id,
                'name' => 'Facebook Post Creation',
                'description' => 'Create engaging Facebook posts with images and text',
                'task_fields' => json_encode([
                    'facebook_username' => 'text',
                    'post_content' => 'textarea',
                    'post_image' => 'file',
                    'target_audience' => 'select',
                    'post_hashtags' => 'text'
                ]),
                'submission_fields' => json_encode([
                    'post_url' => 'url',
                    'post_screenshot' => 'file',
                    'engagement_metrics' => 'number'
                ]),
                'is_active' => true,
            ],
            [
                'platform_id' => $facebook->id,
                'name' => 'Facebook Page Like',
                'description' => 'Like and follow Facebook pages',
                'task_fields' => json_encode([
                    'page_name' => 'text',
                    'page_url' => 'url',
                    'required_interaction' => 'select'
                ]),
                'submission_fields' => json_encode([
                    'screenshot' => 'file',
                    'profile_confirmation' => 'file'
                ]),
                'is_active' => true,
            ],
            [
                'platform_id' => $facebook->id,
                'name' => 'Facebook Comment Engagement',
                'description' => 'Engage with posts through meaningful comments',
                'task_fields' => json_encode([
                    'post_url' => 'url',
                    'comment_requirements' => 'textarea',
                    'comment_count' => 'number'
                ]),
                'submission_fields' => json_encode([
                    'comment_screenshot' => 'file',
                    'comment_text' => 'textarea'
                ]),
                'is_active' => true,
            ],

            // Twitter Templates
            [
                'platform_id' => $twitter->id,
                'name' => 'Twitter Post Creation',
                'description' => 'Create tweets with engaging content',
                'task_fields' => json_encode([
                    'twitter_handle' => 'text',
                    'tweet_content' => 'textarea',
                    'tweet_image' => 'file',
                    'hashtags' => 'text',
                    'mention_accounts' => 'text'
                ]),
                'submission_fields' => json_encode([
                    'tweet_url' => 'url',
                    'tweet_screenshot' => 'file',
                    'retweet_count' => 'number'
                ]),
                'is_active' => true,
            ],
            [
                'platform_id' => $twitter->id,
                'name' => 'Twitter Engagement',
                'description' => 'Like, retweet, and comment on tweets',
                'task_fields' => json_encode([
                    'target_tweet_url' => 'url',
                    'engagement_type' => 'select',
                    'engagement_count' => 'number'
                ]),
                'submission_fields' => json_encode([
                    'engagement_screenshot' => 'file',
                    'profile_link' => 'url'
                ]),
                'is_active' => true,
            ],

            // Instagram Templates
            [
                'platform_id' => $instagram->id,
                'name' => 'Instagram Post Creation',
                'description' => 'Create Instagram posts with photos and captions',
                'task_fields' => json_encode([
                    'instagram_username' => 'text',
                    'post_caption' => 'textarea',
                    'post_image' => 'file',
                    'hashtags' => 'text',
                    'location_tag' => 'text'
                ]),
                'submission_fields' => json_encode([
                    'post_url' => 'url',
                    'post_screenshot' => 'file',
                    'like_count' => 'number'
                ]),
                'is_active' => true,
            ],
            [
                'platform_id' => $instagram->id,
                'name' => 'Instagram Story Engagement',
                'description' => 'Engage with Instagram stories',
                'task_fields' => json_encode([
                    'story_url' => 'url',
                    'story_interaction' => 'select'
                ]),
                'submission_fields' => json_encode([
                    'story_screenshot' => 'file',
                    'profile_verification' => 'file'
                ]),
                'is_active' => true,
            ],

            // YouTube Templates
            [
                'platform_id' => $youtube->id,
                'name' => 'YouTube Video Watch',
                'description' => 'Watch YouTube videos and provide engagement',
                'task_fields' => json_encode([
                    'video_url' => 'url',
                    'watch_duration_minutes' => 'number',
                    'engagement_type' => 'select'
                ]),
                'submission_fields' => json_encode([
                    'watch_confirmation' => 'file',
                    'engagement_screenshot' => 'file'
                ]),
                'is_active' => true,
            ],
            [
                'platform_id' => $youtube->id,
                'name' => 'YouTube Channel Subscribe',
                'description' => 'Subscribe to YouTube channels',
                'task_fields' => json_encode([
                    'channel_url' => 'url',
                    'subscription_confirmation' => 'file'
                ]),
                'submission_fields' => json_encode([
                    'subscription_screenshot' => 'file',
                    'channel_verification' => 'file'
                ]),
                'is_active' => true,
            ],

            // LinkedIn Templates
            [
                'platform_id' => $linkedin->id,
                'name' => 'LinkedIn Post Creation',
                'description' => 'Create professional LinkedIn posts',
                'task_fields' => json_encode([
                    'linkedin_profile' => 'text',
                    'post_content' => 'textarea',
                    'post_image' => 'file',
                    'professional_tags' => 'text'
                ]),
                'submission_fields' => json_encode([
                    'post_url' => 'url',
                    'post_screenshot' => 'file'
                ]),
                'is_active' => true,
            ],

            // TikTok Templates
            [
                'platform_id' => $tiktok->id,
                'name' => 'TikTok Video Engagement',
                'description' => 'Engage with TikTok videos through likes and comments',
                'task_fields' => json_encode([
                    'video_url' => 'url',
                    'engagement_type' => 'select',
                    'engagement_count' => 'number'
                ]),
                'submission_fields' => json_encode([
                    'engagement_screenshot' => 'file',
                    'profile_verification' => 'file'
                ]),
                'is_active' => true,
            ],

            // WhatsApp Templates
            [
                'platform_id' => $whatsapp->id,
                'name' => 'WhatsApp Group Join',
                'description' => 'Join WhatsApp groups and engage with content',
                'task_fields' => json_encode([
                    'group_invite_link' => 'url',
                    'group_description' => 'textarea',
                    'participation_requirements' => 'textarea'
                ]),
                'submission_fields' => json_encode([
                    'group_screenshot' => 'file',
                    'profile_in_group' => 'file'
                ]),
                'is_active' => true,
            ],

            // Custom Website Templates
            [
                'platform_id' => $customWebsite->id,
                'name' => 'Website Registration',
                'description' => 'Register on custom websites and platforms',
                'task_fields' => json_encode([
                    'website_url' => 'url',
                    'registration_steps' => 'textarea',
                    'required_information' => 'textarea'
                ]),
                'submission_fields' => json_encode([
                    'registration_confirmation' => 'file',
                    'account_screenshot' => 'file'
                ]),
                'is_active' => true,
            ],
            [
                'platform_id' => $customWebsite->id,
                'name' => 'Website Content Engagement',
                'description' => 'Engage with website content through interactions',
                'task_fields' => json_encode([
                    'website_url' => 'url',
                    'content_type' => 'select',
                    'engagement_requirements' => 'textarea'
                ]),
                'submission_fields' => json_encode([
                    'engagement_screenshot' => 'file',
                    'interaction_proof' => 'file'
                ]),
                'is_active' => true,
            ],

            // Mobile Games Templates
            [
                'platform_id' => $mobileGames->id,
                'name' => 'Mobile Game Level Complete',
                'description' => 'Complete specific levels in mobile games',
                'task_fields' => json_encode([
                    'game_name' => 'text',
                    'level_number' => 'number',
                    'gameplay_requirements' => 'textarea'
                ]),
                'submission_fields' => json_encode([
                    'level_completion_screenshot' => 'file',
                    'score_screenshot' => 'file'
                ]),
                'is_active' => true,
            ],

            // Survey Sites Templates
            [
                'platform_id' => $surveySites->id,
                'name' => 'Survey Completion',
                'description' => 'Complete online surveys and provide feedback',
                'task_fields' => json_encode([
                    'survey_platform' => 'text',
                    'survey_topic' => 'text',
                    'survey_length' => 'number'
                ]),
                'submission_fields' => json_encode([
                    'survey_completion_certificate' => 'file',
                    'survey_screenshot' => 'file'
                ]),
                'is_active' => true,
            ],

            // Review Platforms Templates
            [
                'platform_id' => $reviewPlatforms->id,
                'name' => 'Business Review Creation',
                'description' => 'Write reviews for businesses on review platforms',
                'task_fields' => json_encode([
                    'business_name' => 'text',
                    'business_location' => 'text',
                    'review_platform' => 'select',
                    'review_requirements' => 'textarea'
                ]),
                'submission_fields' => json_encode([
                    'review_url' => 'url',
                    'review_screenshot' => 'file'
                ]),
                'is_active' => true,
            ],

            // E-commerce Templates
            [
                'platform_id' => $ecommerce->id,
                'name' => 'Product Review',
                'description' => 'Review products on e-commerce platforms',
                'task_fields' => json_encode([
                    'product_name' => 'text',
                    'ecommerce_platform' => 'select',
                    'product_category' => 'text',
                    'review_requirements' => 'textarea'
                ]),
                'submission_fields' => json_encode([
                    'review_url' => 'url',
                    'product_verification' => 'file'
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            PlatformTemplate::updateOrCreate(
                [
                    'platform_id' => $template['platform_id'],
                    'name' => $template['name']
                ],
                [
                    'description' => $template['description'],
                    'task_fields' => $template['task_fields'],
                    'submission_fields' => $template['submission_fields'],
                    'is_active' => $template['is_active'],
                ]
            );
        }

        $this->command->info('Platform templates seeded successfully.');
    }
}
