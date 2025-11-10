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
                'task_fields' => [
                    ["slug" => "facebook_username", "title" => "Facebook Username", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "post_content", "title" => "Post Content", "type" => "textarea", "options" => [], "required" => true],
                    ["slug" => "post_image", "title" => "Post Image", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "target_audience", "title" => "Target Audience", "type" => "select", "options" => ["General Public", "Business Professionals", "Young Adults", "Families"], "required" => true],
                    ["slug" => "post_hashtags", "title" => "Post Hashtags", "type" => "text", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "post_url", "title" => "Post URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "post_screenshot", "title" => "Post Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "engagement_metrics", "title" => "Engagement Metrics", "type" => "number", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],
            [
                'platform_id' => $facebook->id,
                'name' => 'Facebook Page Like',
                'description' => 'Like and follow Facebook pages',
                'task_fields' => [
                    ["slug" => "page_name", "title" => "Page Name", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "page_url", "title" => "Page URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "required_interaction", "title" => "Required Interaction", "type" => "select", "options" => ["Like", "Follow", "Like and Follow"], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "screenshot", "title" => "Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "profile_confirmation", "title" => "Profile Confirmation", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],
            [
                'platform_id' => $facebook->id,
                'name' => 'Facebook Comment Engagement',
                'description' => 'Engage with posts through meaningful comments',
                'task_fields' => [
                    ["slug" => "post_url", "title" => "Post URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "comment_requirements", "title" => "Comment Requirements", "type" => "textarea", "options" => [], "required" => true],
                    ["slug" => "comment_count", "title" => "Comment Count", "type" => "number", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "comment_screenshot", "title" => "Comment Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "comment_text", "title" => "Comment Text", "type" => "textarea", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // Twitter Templates
            [
                'platform_id' => $twitter->id,
                'name' => 'Twitter Post Creation',
                'description' => 'Create tweets with engaging content',
                'task_fields' => [
                    ["slug" => "twitter_handle", "title" => "Twitter Handle", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "tweet_content", "title" => "Tweet Content", "type" => "textarea", "options" => [], "required" => true],
                    ["slug" => "tweet_image", "title" => "Tweet Image", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "hashtags", "title" => "Hashtags", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "mention_accounts", "title" => "Mention Accounts", "type" => "text", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "tweet_url", "title" => "Tweet URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "tweet_screenshot", "title" => "Tweet Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "retweet_count", "title" => "Retweet Count", "type" => "number", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],
            [
                'platform_id' => $twitter->id,
                'name' => 'Twitter Engagement',
                'description' => 'Like, retweet, and comment on tweets',
                'task_fields' => [
                    ["slug" => "target_tweet_url", "title" => "Target Tweet URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "engagement_type", "title" => "Engagement Type", "type" => "select", "options" => ["Like", "Retweet", "Comment"], "required" => true],
                    ["slug" => "engagement_count", "title" => "Engagement Count", "type" => "number", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "engagement_screenshot", "title" => "Engagement Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "profile_link", "title" => "Profile Link", "type" => "url", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // Instagram Templates
            [
                'platform_id' => $instagram->id,
                'name' => 'Instagram Post Creation',
                'description' => 'Create Instagram posts with photos and captions',
                'task_fields' => [
                    ["slug" => "instagram_username", "title" => "Instagram Username", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "post_caption", "title" => "Post Caption", "type" => "textarea", "options" => [], "required" => true],
                    ["slug" => "post_image", "title" => "Post Image", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "hashtags", "title" => "Hashtags", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "location_tag", "title" => "Location Tag", "type" => "text", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "post_url", "title" => "Post URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "post_screenshot", "title" => "Post Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "like_count", "title" => "Like Count", "type" => "number", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],
            [
                'platform_id' => $instagram->id,
                'name' => 'Instagram Story Engagement',
                'description' => 'Engage with Instagram stories',
                'task_fields' => [
                    ["slug" => "story_url", "title" => "Story URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "story_interaction", "title" => "Story Interaction", "type" => "select", "options" => ["View", "Reply", "React"], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "story_screenshot", "title" => "Story Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "profile_verification", "title" => "Profile Verification", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // YouTube Templates
            [
                'platform_id' => $youtube->id,
                'name' => 'YouTube Video Watch',
                'description' => 'Watch YouTube videos and provide engagement',
                'task_fields' => [
                    ["slug" => "video_url", "title" => "Video URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "watch_duration_minutes", "title" => "Watch Duration Minutes", "type" => "number", "options" => [], "required" => true],
                    ["slug" => "engagement_type", "title" => "Engagement Type", "type" => "select", "options" => ["Like", "Comment", "Subscribe"], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "watch_confirmation", "title" => "Watch Confirmation", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "engagement_screenshot", "title" => "Engagement Screenshot", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],
            [
                'platform_id' => $youtube->id,
                'name' => 'YouTube Channel Subscribe',
                'description' => 'Subscribe to YouTube channels',
                'task_fields' => [
                    ["slug" => "channel_url", "title" => "Channel URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "subscription_confirmation", "title" => "Subscription Confirmation", "type" => "file", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "subscription_screenshot", "title" => "Subscription Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "channel_verification", "title" => "Channel Verification", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // LinkedIn Templates
            [
                'platform_id' => $linkedin->id,
                'name' => 'LinkedIn Post Creation',
                'description' => 'Create professional LinkedIn posts',
                'task_fields' => [
                    ["slug" => "linkedin_profile", "title" => "LinkedIn Profile", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "post_content", "title" => "Post Content", "type" => "textarea", "options" => [], "required" => true],
                    ["slug" => "post_image", "title" => "Post Image", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "professional_tags", "title" => "Professional Tags", "type" => "text", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "post_url", "title" => "Post URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "post_screenshot", "title" => "Post Screenshot", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // TikTok Templates
            [
                'platform_id' => $tiktok->id,
                'name' => 'TikTok Video Engagement',
                'description' => 'Engage with TikTok videos through likes and comments',
                'task_fields' => [
                    ["slug" => "video_url", "title" => "Video URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "engagement_type", "title" => "Engagement Type", "type" => "select", "options" => ["Like", "Comment", "Share"], "required" => true],
                    ["slug" => "engagement_count", "title" => "Engagement Count", "type" => "number", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "engagement_screenshot", "title" => "Engagement Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "profile_verification", "title" => "Profile Verification", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // WhatsApp Templates
            [
                'platform_id' => $whatsapp->id,
                'name' => 'WhatsApp Group Join',
                'description' => 'Join WhatsApp groups and engage with content',
                'task_fields' => [
                    ["slug" => "group_invite_link", "title" => "Group Invite Link", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "group_description", "title" => "Group Description", "type" => "textarea", "options" => [], "required" => true],
                    ["slug" => "participation_requirements", "title" => "Participation Requirements", "type" => "textarea", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "group_screenshot", "title" => "Group Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "profile_in_group", "title" => "Profile in Group", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // Custom Website Templates
            [
                'platform_id' => $customWebsite->id,
                'name' => 'Website Registration',
                'description' => 'Register on custom websites and platforms',
                'task_fields' => [
                    ["slug" => "website_url", "title" => "Website URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "registration_steps", "title" => "Registration Steps", "type" => "textarea", "options" => [], "required" => true],
                    ["slug" => "required_information", "title" => "Required Information", "type" => "textarea", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "registration_confirmation", "title" => "Registration Confirmation", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "account_screenshot", "title" => "Account Screenshot", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],
            [
                'platform_id' => $customWebsite->id,
                'name' => 'Website Content Engagement',
                'description' => 'Engage with website content through interactions',
                'task_fields' => [
                    ["slug" => "website_url", "title" => "Website URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "content_type", "title" => "Content Type", "type" => "select", "options" => ["Article", "Video", "Image", "Forum Post"], "required" => true],
                    ["slug" => "engagement_requirements", "title" => "Engagement Requirements", "type" => "textarea", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "engagement_screenshot", "title" => "Engagement Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "interaction_proof", "title" => "Interaction Proof", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // Mobile Games Templates
            [
                'platform_id' => $mobileGames->id,
                'name' => 'Mobile Game Level Complete',
                'description' => 'Complete specific levels in mobile games',
                'task_fields' => [
                    ["slug" => "game_name", "title" => "Game Name", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "level_number", "title" => "Level Number", "type" => "number", "options" => [], "required" => true],
                    ["slug" => "gameplay_requirements", "title" => "Gameplay Requirements", "type" => "textarea", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "level_completion_screenshot", "title" => "Level Completion Screenshot", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "score_screenshot", "title" => "Score Screenshot", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // Survey Sites Templates
            [
                'platform_id' => $surveySites->id,
                'name' => 'Survey Completion',
                'description' => 'Complete online surveys and provide feedback',
                'task_fields' => [
                    ["slug" => "survey_platform", "title" => "Survey Platform", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "survey_topic", "title" => "Survey Topic", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "survey_length", "title" => "Survey Length", "type" => "number", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "survey_completion_certificate", "title" => "Survey Completion Certificate", "type" => "file", "options" => [], "required" => true],
                    ["slug" => "survey_screenshot", "title" => "Survey Screenshot", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // Review Platforms Templates
            [
                'platform_id' => $reviewPlatforms->id,
                'name' => 'Business Review Creation',
                'description' => 'Write reviews for businesses on review platforms',
                'task_fields' => [
                    ["slug" => "business_name", "title" => "Business Name", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "business_location", "title" => "Business Location", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "review_platform", "title" => "Review Platform", "type" => "select", "options" => ["Google Reviews", "Yelp", "TripAdvisor"], "required" => true],
                    ["slug" => "review_requirements", "title" => "Review Requirements", "type" => "textarea", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "review_url", "title" => "Review URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "review_screenshot", "title" => "Review Screenshot", "type" => "file", "options" => [], "required" => true],
                ],
                'is_active' => true,
            ],

            // E-commerce Templates
            [
                'platform_id' => $ecommerce->id,
                'name' => 'Product Review',
                'description' => 'Review products on e-commerce platforms',
                'task_fields' => [
                    ["slug" => "product_name", "title" => "Product Name", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "ecommerce_platform", "title" => "E-commerce Platform", "type" => "select", "options" => ["Amazon", "eBay", "Walmart"], "required" => true],
                    ["slug" => "product_category", "title" => "Product Category", "type" => "text", "options" => [], "required" => true],
                    ["slug" => "review_requirements", "title" => "Review Requirements", "type" => "textarea", "options" => [], "required" => true],
                ],
                'submission_fields' => [
                    ["slug" => "review_url", "title" => "Review URL", "type" => "url", "options" => [], "required" => true],
                    ["slug" => "product_verification", "title" => "Product Verification", "type" => "file", "options" => [], "required" => true],
                ],
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
