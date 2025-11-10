<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Platform;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\PlatformTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get templates and platforms
        $facebookTemplate = PlatformTemplate::where('name', 'Facebook Post Creation')->first();
        $twitterTemplate = PlatformTemplate::where('name', 'Twitter Post Creation')->first();
        $instagramTemplate = PlatformTemplate::where('name', 'Instagram Post Creation')->first();
        $youtubeTemplate = PlatformTemplate::where('name', 'YouTube Video Watch')->first();
        $linkedinTemplate = PlatformTemplate::where('name', 'LinkedIn Post Creation')->first();
        $customWebsiteTemplate = PlatformTemplate::where('name', 'Website Registration')->first();
        
        // Get users for task creators
        $users = User::whereNotNull('email_verified_at')->get();
        
        // Create sample tasks
        $tasks = [
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'platform_id' => $facebookTemplate->platform_id,
                'platform_template_id' => $facebookTemplate->id,
                'title' => 'Create engaging Facebook post for tech startup',
                'description' => 'Need someone to create a professional Facebook post about our new SaaS product. The post should be engaging, include a call-to-action, and use relevant hashtags.',
                'average_completion_minutes' => 15,
                'requirements' => json_encode(['Active Facebook account', 'Previous posting experience', 'Understanding of tech industry']),
                'visibility' => 'public',
                'template_data' => json_encode([
                    'facebook_username' => 'john_doe',
                    'post_content' => 'Excited to launch our new productivity tool! 🚀 #Productivity #SaaS #TechStartup',
                    'target_audience' => 'Business professionals',
                    'post_hashtags' => '#Productivity #SaaS #TechStartup #BusinessTools'
                ]),
                'expected_budget' => '$3-5',
                'expiry_date' => now()->addDays(7),
                'allow_multiple_submissions' => false,
                'number_of_submissions' => 1,
                'budget_per_submission' => '4.00',
                'submission_review_type' => 'self_review',
                'is_active' => true,
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'platform_id' => $twitterTemplate->platform_id,
                'platform_template_id' => $twitterTemplate->id,
                'title' => 'Twitter engagement campaign for lifestyle brand',
                'description' => 'Looking for users to engage with our lifestyle brand tweets. This includes liking, retweeting, and commenting meaningfully on our content.',
                'average_completion_minutes' => 10,
                'requirements' => json_encode(['Active Twitter account', 'Minimum 100 followers', 'Good engagement history']),
                'visibility' => 'public',
                'template_data' => json_encode([
                    'twitter_handle' => '@userhandle',
                    'engagement_type' => 'like_comment_retweet',
                    'engagement_count' => 3
                ]),
                'expected_budget' => '$2-3',
                'expiry_date' => now()->addDays(3),
                'allow_multiple_submissions' => true,
                'number_of_submissions' => 5,
                'budget_per_submission' => '2.50',
                'submission_review_type' => 'self_review',
                'is_active' => true,
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'platform_id' => $instagramTemplate->platform_id,
                'platform_template_id' => $instagramTemplate->id,
                'title' => 'Instagram story engagement for fashion brand',
                'description' => 'Need users to engage with our fashion brand Instagram stories by viewing and interacting with them.',
                'average_completion_minutes' => 5,
                'requirements' => json_encode(['Active Instagram account', 'Fashion interest', 'Story viewing capability']),
                'visibility' => 'public',
                'template_data' => json_encode([
                    'instagram_username' => 'fashion_lover',
                    'story_interaction' => 'view_like_send_message'
                ]),
                'expected_budget' => '$1-2',
                'expiry_date' => now()->addDays(2),
                'allow_multiple_submissions' => true,
                'number_of_submissions' => 10,
                'budget_per_submission' => '1.50',
                'submission_review_type' => 'admin_review',
                'is_active' => true,
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'platform_id' => $youtubeTemplate->platform_id,
                'platform_template_id' => $youtubeTemplate->id,
                'title' => 'Educational video watch and engagement',
                'description' => 'Watch our educational YouTube video about digital marketing and provide engagement (like, subscribe, comment).',
                'average_completion_minutes' => 20,
                'requirements' => json_encode(['Active YouTube account', 'Interest in digital marketing', 'Minimum watch time 80%']),
                'visibility' => 'public',
                'template_data' => json_encode([
                    'watch_duration_minutes' => 20,
                    'engagement_type' => 'like_subscribe_comment'
                ]),
                'expected_budget' => '$2-4',
                'expiry_date' => now()->addDays(5),
                'allow_multiple_submissions' => false,
                'number_of_submissions' => 1,
                'budget_per_submission' => '3.00',
                'submission_review_type' => 'system_review',
                'is_active' => true,
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'platform_id' => $linkedinTemplate->platform_id,
                'platform_template_id' => $linkedinTemplate->id,
                'title' => 'Professional LinkedIn post for B2B service',
                'description' => 'Create a professional LinkedIn post highlighting our B2B consulting services. Professional tone and industry insights required.',
                'average_completion_minutes' => 25,
                'requirements' => json_encode(['Professional LinkedIn profile', 'B2B industry knowledge', 'Professional writing skills']),
                'visibility' => 'public',
                'template_data' => json_encode([
                    'linkedin_profile' => 'john-consultant',
                    'post_content' => 'B2B consulting services can transform your business operations...',
                    'professional_tags' => '#B2B #Consulting #BusinessGrowth #Strategy'
                ]),
                'expected_budget' => '$5-8',
                'expiry_date' => now()->addDays(10),
                'allow_multiple_submissions' => false,
                'number_of_submissions' => 1,
                'budget_per_submission' => '6.50',
                'submission_review_type' => 'admin_review',
                'is_active' => true,
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'platform_id' => $customWebsiteTemplate->platform_id,
                'platform_template_id' => $customWebsiteTemplate->id,
                'title' => 'Newsletter signup on productivity website',
                'description' => 'Sign up for our productivity newsletter on our website and confirm your email subscription.',
                'average_completion_minutes' => 3,
                'requirements' => json_encode(['Valid email address', 'Website navigation skills', 'Email confirmation capability']),
                'visibility' => 'public',
                'template_data' => json_encode([
                    'website_url' => 'https://productivity-tips.com',
                    'registration_steps' => '1. Go to homepage\n2. Find newsletter signup\n3. Enter email\n4. Confirm subscription',
                    'required_information' => 'Email address, Name (optional)'
                ]),
                'expected_budget' => '$1-2',
                'expiry_date' => now()->addDays(1),
                'allow_multiple_submissions' => true,
                'number_of_submissions' => 20,
                'budget_per_submission' => '1.25',
                'submission_review_type' => 'system_review',
                'is_active' => true,
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'platform_id' => $facebookTemplate->platform_id,
                'platform_template_id' => $facebookTemplate->id,
                'title' => 'Facebook page like and review for restaurant',
                'description' => 'Like our restaurant Facebook page and leave a positive review about your dining experience.',
                'average_completion_minutes' => 8,
                'requirements' => json_encode(['Active Facebook account', 'Location in service area', 'Dining experience preferred']),
                'visibility' => 'public',
                'template_data' => json_encode([
                    'facebook_username' => 'foodie_reviewer',
                    'page_name' => 'Bella Vista Restaurant',
                    'required_interaction' => 'like_review'
                ]),
                'expected_budget' => '$3-4',
                'expiry_date' => now()->addDays(4),
                'allow_multiple_submissions' => true,
                'number_of_submissions' => 3,
                'budget_per_submission' => '3.50',
                'submission_review_type' => 'admin_review',
                'is_active' => true,
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'platform_id' => $twitterTemplate->platform_id,
                'platform_template_id' => $twitterTemplate->id,
                'title' => 'Retweet and comment on tech news',
                'description' => 'Retweet our tech news tweet and add a thoughtful comment about the latest industry developments.',
                'average_completion_minutes' => 7,
                'requirements' => json_encode(['Active Twitter account', 'Tech industry interest', 'Ability to provide meaningful comments']),
                'visibility' => 'public',
                'template_data' => json_encode([
                    'target_tweet_url' => 'https://twitter.com/technews/status/123456',
                    'engagement_type' => 'retweet_comment',
                    'engagement_count' => 2
                ]),
                'expected_budget' => '$2-3',
                'expiry_date' => now()->addDays(2),
                'allow_multiple_submissions' => true,
                'number_of_submissions' => 4,
                'budget_per_submission' => '2.75',
                'submission_review_type' => 'self_review',
                'is_active' => true,
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'platform_id' => $instagramTemplate->platform_id,
                'platform_template_id' => $instagramTemplate->id,
                'title' => 'Instagram post with product mention',
                'description' => 'Create an Instagram post mentioning our eco-friendly product with appropriate hashtags.',
                'average_completion_minutes' => 12,
                'requirements' => json_encode(['Active Instagram account', 'Eco-friendly content creation', 'Hashtag usage skills']),
                'visibility' => 'public',
                'template_data' => json_encode([
                    'instagram_username' => 'eco_warrior',
                    'post_caption' => 'Love using sustainable products! 🌱 #EcoFriendly #SustainableLiving #GreenProducts',
                    'location_tag' => 'Home'
                ]),
                'expected_budget' => '$4-6',
                'expiry_date' => now()->addDays(6),
                'allow_multiple_submissions' => false,
                'number_of_submissions' => 1,
                'budget_per_submission' => '5.00',
                'submission_review_type' => 'admin_review',
                'is_active' => true,
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'platform_id' => $customWebsiteTemplate->platform_id,
                'platform_template_id' => $customWebsiteTemplate->id,
                'title' => 'App download and registration',
                'description' => 'Download our mobile app, create an account, and complete the onboarding process.',
                'average_completion_minutes' => 10,
                'requirements' => json_encode(['Smartphone with app store access', 'Valid email for registration', 'Time for onboarding']),
                'visibility' => 'public',
                'template_data' => json_encode([
                    'website_url' => 'https://app-store.com/our-app',
                    'registration_steps' => '1. Download app\n2. Open app\n3. Create account\n4. Complete profile\n5. Finish onboarding',
                    'required_information' => 'Email, Name, Phone (optional)'
                ]),
                'expected_budget' => '$3-5',
                'expiry_date' => now()->addDays(8),
                'allow_multiple_submissions' => true,
                'number_of_submissions' => 15,
                'budget_per_submission' => '4.25',
                'submission_review_type' => 'system_review',
                'is_active' => true,
            ],
        ];

        foreach ($tasks as $taskData) {
            Task::updateOrCreate(
                [
                    'user_id' => $taskData['user_id'],
                    'title' => $taskData['title']
                ],
                [
                    'platform_id' => $taskData['platform_id'],
                    'platform_template_id' => $taskData['platform_template_id'],
                    'description' => $taskData['description'],
                    'average_completion_minutes' => $taskData['average_completion_minutes'],
                    'requirements' => $taskData['requirements'],
                    'visibility' => $taskData['visibility'],
                    'template_data' => $taskData['template_data'],
                    'expected_budget' => $taskData['expected_budget'],
                    'expiry_date' => $taskData['expiry_date'],
                    'allow_multiple_submissions' => $taskData['allow_multiple_submissions'],
                    'number_of_submissions' => $taskData['number_of_submissions'],
                    'budget_per_submission' => $taskData['budget_per_submission'],
                    'submission_review_type' => $taskData['submission_review_type'],
                    'is_active' => $taskData['is_active'],
                ]
            );
        }

        $this->command->info('Tasks seeded successfully.');
    }
}
