<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $categories = [
            [
                'name' => 'Help',
                'slug' => 'help',
                'is_help' => true,
            ],
            [
                'name' => 'Getting Started',
                'slug' => 'getting-started',
                'is_help' => false,
            ],
            [
                'name' => 'Platform Guide',
                'slug' => 'platform-guide',
                'is_help' => false,
            ],
            [
                'name' => 'Earning Tips',
                'slug' => 'earning-tips',
                'is_help' => false,
            ],
            [
                'name' => 'Task Management',
                'slug' => 'task-management',
                'is_help' => false,
            ],
            [
                'name' => 'Payment & Withdrawal',
                'slug' => 'payment-withdrawal',
                'is_help' => false,
            ],
            [
                'name' => 'Account Security',
                'slug' => 'account-security',
                'is_help' => false,
            ],
            [
                'name' => 'Best Practices',
                'slug' => 'best-practices',
                'is_help' => false,
            ],
            [
                'name' => 'News & Updates',
                'slug' => 'news-updates',
                'is_help' => false,
            ],
        ];

        $categoryIds = [];
        foreach ($categories as $categoryData) {
            $category = Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'name' => $categoryData['name'],
                    'is_help' => $categoryData['is_help'],
                ]
            );
            $categoryIds[$categoryData['slug']] = $category->id;
        }

        // Create Tags
        $tags = [
            'freelancing', 'earning', 'tips', 'guide', 'beginner', 'advanced', 
            'facebook', 'twitter', 'instagram', 'youtube', 'social media',
            'payment', 'withdrawal', 'security', 'verification', 'mobile',
            'tasks', 'gigs', 'remote work', 'online income', 'work from home',
            'tutorial', 'how to', 'best practices', 'productivity', 'success'
        ];

        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::updateOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => ucfirst($tagName)]
            );
            $tagIds[$tagName] = $tag->id;
        }

        // Get some users to use as post authors
        $users = User::take(5)->get();
        
        // If no users exist, create a system user for posts
        if ($users->isEmpty()) {
            $systemUser = User::updateOrCreate(
                ['email' => 'system@wonegig.com'],
                [
                    'name' => 'System User',
                    'username' => 'system-user',
                    'email' => 'system@wonegig.com',
                    'password' => bcrypt('system123'),
                    'country_id' => '161',
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]
            );
            $users = collect([$systemUser]);
        }

        // Create Posts
        $posts = [
            [
                'category_id' => $categoryIds['help'],
                'title' => 'How to Get Started with Task Platform',
                'excerpt' => 'Complete guide for new users to start earning money by completing tasks',
                'content' => 'Welcome to our task platform! This comprehensive guide will help you get started with earning money by completing various tasks on different platforms like Facebook, Twitter, Instagram, and more.

## Getting Started

1. **Create Your Account**: Sign up with your email and verify your account
2. **Complete Profile**: Add your personal information and verification documents
3. **Set Preferences**: Choose your preferred platforms and locations
4. **Browse Tasks**: Start browsing available tasks that match your skills

## Types of Tasks Available

- Social media engagement (likes, comments, shares)
- Content creation (posts, reviews)
- Survey completion
- Website registrations
- Mobile game completion

## Tips for Success

- Always provide accurate information
- Complete verification process
- Start with simple tasks
- Build your reputation gradually

Need help? Contact our support team!',
                'tags' => ['getting started', 'guide', 'beginner', 'tutorial'],
                'is_active' => true,
                'featured' => true,
                'views_count' => 1250,
                'reading_time' => 5,
            ],
            [
                'category_id' => $categoryIds['earning-tips'],
                'title' => '10 Proven Tips to Increase Your Daily Earnings',
                'excerpt' => 'Discover effective strategies to maximize your earning potential on the platform',
                'content' => 'Want to earn more money daily? Here are 10 proven strategies that top earners use:

## 1. Complete Your Profile 100%
Ensure all profile information is filled out and verified. This builds trust and increases task availability.

## 2. Choose Your Best Platforms
Focus on platforms you\'re most comfortable with - whether it\'s Facebook, Twitter, Instagram, or others.

## 3. Work During Peak Hours
Many platforms are most active during evening hours, leading to more available tasks.

## 4. Maintain High Quality
Quality submissions lead to better ratings and access to higher-paying tasks.

## 5. Use Multiple Devices
Having both mobile and desktop access increases your task opportunities.

## 6. Enable Notifications
Stay updated on new tasks by enabling push notifications.

## 7. Build Your Network
Refer friends and build connections for better task recommendations.

## 8. Complete Booster Subscriptions
Upgrade your account with boosters for increased limits and benefits.

## 9. Stay Consistent
Regular daily activity improves your platform ranking and task access.

## 10. Learn from Others
Join our community discussions and learn from successful users.

Start implementing these tips today and watch your earnings grow!',
                'tags' => ['earning', 'tips', 'success', 'productivity'],
                'is_active' => true,
                'featured' => false,
                'views_count' => 890,
                'reading_time' => 8,
            ],
            [
                'category_id' => $categoryIds['platform-guide'],
                'title' => 'Complete Facebook Tasks Guide',
                'excerpt' => 'Everything you need to know about completing Facebook-related tasks successfully',
                'content' => 'Facebook tasks are among the most popular on our platform. Here\'s your complete guide:

## Common Facebook Task Types

### Post Creation Tasks
- Create engaging posts with images
- Follow specific content guidelines
- Use required hashtags and mentions
- Maintain authentic engagement

### Engagement Tasks
- Like and comment on posts
- Share content to your timeline
- Join Facebook groups
- Follow business pages

### Page Management Tasks
- Follow pages and profiles
- Provide testimonials and reviews
- Complete business page surveys

## Best Practices for Facebook Tasks

1. **Authentic Profiles**: Use real, active Facebook profiles
2. **Genuine Engagement**: Real interactions only - no fake accounts
3. **Follow Guidelines**: Carefully read task requirements
4. **Provide Proof**: Always include screenshots when required
5. **Stay Updated**: Keep up with Facebook\'s policy changes

## Common Requirements

- Active Facebook account (minimum 6 months old)
- Privacy settings that allow verification
- Previous engagement history
- Profile completeness

## Quality Tips

- Interact naturally with content
- Write meaningful comments
- Share relevant content only
- Maintain professional behavior

Master these Facebook tasks and start earning consistently!',
                'tags' => ['facebook', 'guide', 'social media', 'tutorial'],
                'is_active' => true,
                'featured' => false,
                'views_count' => 567,
                'reading_time' => 6,
            ],
            [
                'category_id' => $categoryIds['payment-withdrawal'],
                'title' => 'Payment Methods and Withdrawal Process Explained',
                'excerpt' => 'Complete guide to receiving payments and withdrawing your earnings',
                'content' => 'Understanding our payment system is crucial for maximizing your earning experience:

## Available Payment Methods

### Bank Transfer
- Direct deposit to your bank account
- Available in supported countries
- Processing time: 2-5 business days
- Minimum withdrawal: varies by country

### Mobile Money
- Popular in African countries (M-Pesa, etc.)
- Instant or same-day processing
- Lower fees compared to bank transfers

### Digital Wallets
- PayPal, Skrill, and other e-wallets
- Quick processing (24-48 hours)
- International availability

### Crypto Currency
- Bitcoin, Ethereum support
- 24/7 processing
- Lower fees for larger amounts

## Withdrawal Process

1. **Verify Your Account**: Complete identity verification
2. **Add Payment Method**: Add your preferred withdrawal method
3. **Request Withdrawal**: Submit withdrawal request
4. **Processing Time**: Wait for processing (varies by method)
5. **Receive Funds**: Funds arrive in your account

## Important Notes

- Minimum withdrawal amounts apply
- First withdrawal may take longer for verification
- Keep payment information updated
- Report any issues immediately

## Tips for Faster Payments

- Complete verification early
- Use consistent payment methods
- Maintain clean account standing
- Contact support for delays

Need help with payments? Our support team is available 24/7!',
                'tags' => ['payment', 'withdrawal', 'guide', 'money'],
                'is_active' => true,
                'featured' => false,
                'views_count' => 734,
                'reading_time' => 7,
            ],
            [
                'category_id' => $categoryIds['account-security'],
                'title' => 'Protecting Your Account: Security Best Practices',
                'excerpt' => 'Essential security measures to keep your account and earnings safe',
                'content' => 'Account security is paramount. Follow these best practices to protect your earnings:

## Password Security

### Strong Passwords
- Use at least 12 characters
- Include uppercase, lowercase, numbers, and symbols
- Avoid personal information
- Use a unique password for this platform

### Password Management
- Use a password manager
- Never share passwords
- Change passwords regularly
- Enable two-factor authentication

## Two-Factor Authentication (2FA)

Enable 2FA for enhanced security:
- SMS-based verification
- Authenticator app codes
- Backup codes for recovery
- Device-based verification

## Account Protection

### Personal Information
- Keep contact information updated
- Verify your identity promptly
- Don\'t share sensitive documents publicly
- Monitor account activity regularly

### Device Security
- Use secure, updated devices
- Install antivirus software
- Avoid public Wi-Fi for sensitive activities
- Log out from shared computers

## Common Security Threats

### Phishing Attempts
- Verify email senders
- Don\'t click suspicious links
- Report suspicious communications
- Never provide credentials via email

### Fake Support Contacts
- Only use official support channels
- Verify support agent identity
- Never share passwords with "support"
- Report suspicious contact attempts

## Account Recovery

If you suspect unauthorized access:
1. Change your password immediately
2. Enable 2FA if not already active
3. Contact support with security concerns
4. Review recent account activity
5. Report any unauthorized transactions

## Best Practices Summary

- Regular security audits
- Keep software updated
- Monitor account statements
- Report suspicious activity
- Educate yourself about threats

Your security is our priority. Stay protected and earn safely!',
                'tags' => ['security', 'account', 'protection', '2fa'],
                'is_active' => true,
                'featured' => false,
                'views_count' => 423,
                'reading_time' => 9,
            ],
        ];

        $postIds = [];
        foreach ($posts as $index => $postData) {
            $user = $users->random();
            $post = Post::updateOrCreate(
                ['slug' => Str::slug($postData['title'])],
                [
                    'category_id' => $postData['category_id'],
                    'user_id' => $user->id,
                    'title' => $postData['title'],
                    'excerpt' => $postData['excerpt'],
                    'content' => $postData['content'],
                    'tags' => $postData['tags'],
                    'is_active' => $postData['is_active'],
                    'featured' => $postData['featured'],
                    'views_count' => $postData['views_count'],
                    'reading_time' => $postData['reading_time'],
                    'allow_comments' => true,
                ]
            );
            $postIds[] = $post->id;
        }

        // Create Comments
        $comments = [
            [
                'commentable_type' => 'App\Models\Post',
                'commentable_id' => $postIds[0], // First post
                'user_id' => $users->random()->id,
                'title' => 'Great guide!',
                'body' => 'This was exactly what I needed to get started. Thank you for the detailed explanation!',
            ],
            [
                'commentable_type' => 'App\Models\Post',
                'commentable_id' => $postIds[0],
                'user_id' => $users->random()->id,
                'title' => 'Helpful tips',
                'body' => 'I\'ve been struggling with getting started, but following these steps has really helped. The platform is much easier to navigate now.',
            ],
            [
                'commentable_type' => 'App\Models\Post',
                'commentable_id' => $postIds[1], // Second post
                'user_id' => $users->random()->id,
                'title' => 'Earnings doubled!',
                'body' => 'After implementing tip #3 about working during peak hours, my daily earnings doubled. Thanks for sharing these strategies!',
            ],
            [
                'commentable_type' => 'App\Models\Post',
                'commentable_id' => $postIds[1],
                'user_id' => $users->random()->id,
                'title' => 'Question about boosters',
                'body' => 'Is it worth getting the booster subscription for beginners, or should I wait until I earn more?',
            ],
            [
                'commentable_type' => 'App\Models\Post',
                'commentable_id' => $postIds[2], // Third post
                'user_id' => $users->random()->id,
                'title' => 'Facebook tasks expert',
                'body' => 'Great guide! I\'ve been doing Facebook tasks for a while, and these tips align with my experience. The authenticity point is crucial.',
            ],
            [
                'commentable_type' => 'App\Models\Post',
                'commentable_id' => $postIds[3], // Fourth post
                'user_id' => $users->random()->id,
                'title' => 'Payment issues resolved',
                'body' => 'I had trouble with my first withdrawal, but after reading this guide and contacting support, everything worked smoothly. The verification process is important!',
            ],
            [
                'commentable_type' => 'App\Models\Post',
                'commentable_id' => $postIds[4], // Fifth post
                'user_id' => $users->random()->id,
                'title' => 'Security first',
                'body' => 'Account security should always be the top priority. I enabled 2FA right after creating my account and never had any issues.',
            ],
        ];

        foreach ($comments as $commentData) {
            Comment::updateOrCreate(
                [
                    'commentable_type' => $commentData['commentable_type'],
                    'commentable_id' => $commentData['commentable_id'],
                    'user_id' => $commentData['user_id'],
                    'body' => $commentData['body'],
                ],
                [
                    'title' => $commentData['title'],
                    'is_flag' => false,
                ]
            );
        }

        $this->command->info('Posts, categories, tags, and comments seeded successfully.');
    }
}
