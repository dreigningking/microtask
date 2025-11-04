<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $users = User::whereNotNull('email_verified_at')->get();

        // If no users exist, create some sample users
        if ($users->isEmpty()) {
            $sampleUsers = [
                [
                    'name' => 'Rachel Green',
                    'username' => 'rachel-green',
                    'email' => 'rachel@wonegig.com',
                    'password' => bcrypt('12345678'),
                    'country_id' => '233', // USA
                    'email_verified_at' => now(),
                    'is_active' => true,
                ],
                [
                    'name' => 'Ibrahim Musa',
                    'username' => 'ibrahim-musa',
                    'email' => 'ibrahim@wonegig.com',
                    'password' => bcrypt('12345678'),
                    'country_id' => '161', // Nigeria
                    'email_verified_at' => now(),
                    'is_active' => true,
                ],
                [
                    'name' => 'Claire Thompson',
                    'username' => 'claire-thompson',
                    'email' => 'claire@wonegig.com',
                    'password' => bcrypt('12345678'),
                    'country_id' => '14', // Australia
                    'email_verified_at' => now(),
                    'is_active' => true,
                ],
                [
                    'name' => 'Raj Patel',
                    'username' => 'raj-patel',
                    'email' => 'raj@wonegig.com',
                    'password' => bcrypt('12345678'),
                    'country_id' => '101', // India
                    'email_verified_at' => now(),
                    'is_active' => true,
                ],
            ];

            foreach ($sampleUsers as $userData) {
                User::updateOrCreate(
                    ['email' => $userData['email']],
                    $userData
                );
            }
            
            $users = User::whereNotNull('email_verified_at')->get();
        }

        // Create notifications directly using DB since there's no Notification model
        $notifications = [
            // Welcome notifications
            [
                'type' => 'welcome',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Welcome to OneGig!',
                    'message' => 'Thank you for joining our platform. Start earning by completing tasks today!',
                    'action_url' => '/tasks',
                    'action_text' => 'Browse Tasks'
                ]),
                'read_at' => null,
                'created_at' => now()->subDays(1),
            ],
            [
                'type' => 'welcome',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Complete Your Profile',
                    'message' => 'Complete your profile to access more tasks and earn more money.',
                    'action_url' => '/profile',
                    'action_text' => 'Edit Profile'
                ]),
                'read_at' => now()->subHours(12),
                'created_at' => now()->subDays(2),
            ],

            // Task-related notifications
            [
                'type' => 'task_assigned',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'New Task Available',
                    'message' => 'A new Facebook post creation task matches your preferences.',
                    'action_url' => '/tasks/1',
                    'action_text' => 'View Task'
                ]),
                'read_at' => null,
                'created_at' => now()->subHours(3),
            ],
            [
                'type' => 'task_completed',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Task Payment Processed',
                    'message' => 'Your payment of $4.00 for completing the Twitter engagement task has been processed.',
                    'action_url' => '/wallet',
                    'action_text' => 'View Wallet'
                ]),
                'read_at' => now()->subHours(6),
                'created_at' => now()->subHours(6),
            ],
            [
                'type' => 'task_reminder',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Task Deadline Reminder',
                    'message' => 'You have 2 hours left to complete the Instagram story engagement task.',
                    'action_url' => '/tasks/2',
                    'action_text' => 'Complete Task'
                ]),
                'read_at' => null,
                'created_at' => now()->subMinutes(30),
            ],

            // Payment notifications
            [
                'type' => 'payment_received',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Payment Received',
                    'message' => 'You have received a payment of ₦2,500 for completed tasks.',
                    'action_url' => '/wallet',
                    'action_text' => 'View Wallet'
                ]),
                'read_at' => now()->subDays(1),
                'created_at' => now()->subDays(1),
            ],
            [
                'type' => 'withdrawal_processed',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Withdrawal Processed',
                    'message' => 'Your withdrawal request of $25.00 has been processed and sent to your bank account.',
                    'action_url' => '/wallet/withdrawals',
                    'action_text' => 'View Withdrawals'
                ]),
                'read_at' => now()->subDays(3),
                'created_at' => now()->subDays(3),
            ],
            [
                'type' => 'withdrawal_failed',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Withdrawal Failed',
                    'message' => 'Your withdrawal request failed due to invalid bank details. Please update your information.',
                    'action_url' => '/profile/banking',
                    'action_text' => 'Update Banking'
                ]),
                'read_at' => null,
                'created_at' => now()->subHours(8),
            ],

            // Account notifications
            [
                'type' => 'verification_required',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Account Verification Required',
                    'message' => 'Please verify your account to increase your task limits and withdrawal amounts.',
                    'action_url' => '/verification',
                    'action_text' => 'Start Verification'
                ]),
                'read_at' => null,
                'created_at' => now()->subDays(5),
            ],
            [
                'type' => 'account_verified',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Account Verified',
                    'message' => 'Congratulations! Your account has been verified. You now have access to premium tasks.',
                    'action_url' => '/tasks',
                    'action_text' => 'Browse Tasks'
                ]),
                'read_at' => now()->subDays(2),
                'created_at' => now()->subDays(2),
            ],

            // Subscription notifications
            [
                'type' => 'subscription_expired',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Subscription Expired',
                    'message' => 'Your Task Limit Booster subscription has expired. Renew now to maintain enhanced limits.',
                    'action_url' => '/subscriptions',
                    'action_text' => 'Renew Subscription'
                ]),
                'read_at' => null,
                'created_at' => now()->subHours(2),
            ],
            [
                'type' => 'subscription_renewed',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Subscription Renewed',
                    'message' => 'Your Feature All Tasks subscription has been successfully renewed for another month.',
                    'action_url' => '/subscriptions',
                    'action_text' => 'View Subscriptions'
                ]),
                'read_at' => now()->subDays(1),
                'created_at' => now()->subDays(1),
            ],

            // System notifications
            [
                'type' => 'maintenance',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Scheduled Maintenance',
                    'message' => 'Platform maintenance is scheduled for tonight from 2 AM to 4 AM UTC. Some features may be unavailable.',
                    'action_url' => null,
                    'action_text' => null
                ]),
                'read_at' => now()->subHours(12),
                'created_at' => now()->subHours(12),
            ],
            [
                'type' => 'new_feature',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'New Feature: Task Analytics',
                    'message' => 'We\'ve launched detailed analytics for your tasks. Track your performance and earnings!',
                    'action_url' => '/analytics',
                    'action_text' => 'View Analytics'
                ]),
                'read_at' => null,
                'created_at' => now()->subDays(4),
            ],

            // Support notifications
            [
                'type' => 'support_ticket',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Support Ticket Response',
                    'message' => 'We have responded to your support ticket regarding payment issues.',
                    'action_url' => '/support',
                    'action_text' => 'View Ticket'
                ]),
                'read_at' => now()->subHours(4),
                'created_at' => now()->subHours(4),
            ],
            [
                'type' => 'support_ticket_created',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'data' => json_encode([
                    'title' => 'Support Ticket Created',
                    'message' => 'Your support ticket has been created. Our team will respond within 24 hours.',
                    'action_url' => '/support',
                    'action_text' => 'View Ticket'
                ]),
                'read_at' => now()->subDays(1),
                'created_at' => now()->subDays(1),
            ],
        ];

        foreach ($notifications as $notificationData) {
            DB::table('notifications')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => $notificationData['type'],
                'notifiable_type' => $notificationData['notifiable_type'],
                'notifiable_id' => $notificationData['notifiable_id'],
                'data' => $notificationData['data'],
                'read_at' => $notificationData['read_at'],
                'created_at' => $notificationData['created_at'],
                'updated_at' => $notificationData['created_at'],
            ]);
        }

        $this->command->info('User notifications seeded successfully.');
    }
}
