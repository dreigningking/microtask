<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Booster;
use Illuminate\Support\Carbon;

class UserSubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users and boosters
        $users = User::whereNotNull('email_verified_at')->take(8)->get();
        $boosters = Booster::all();

        // If no users exist, create some sample users
        
        $sampleUsers = [
            [
                'name' => 'Jennifer Wilson',
                'username' => 'jennifer-wilson',
                'email' => 'jennifer@wonegig.com',
                'password' => bcrypt('12345678'),
                'country_id' => '233', // USA
                'email_verified_at' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Ahmed Hassan',
                'username' => 'ahmed-hassan',
                'email' => 'ahmed@wonegig.com',
                'password' => bcrypt('12345678'),
                'country_id' => '161', // Nigeria
                'email_verified_at' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Sophie Dubois',
                'username' => 'sophie-dubois',
                'email' => 'sophie@wonegig.com',
                'password' => bcrypt('12345678'),
                'country_id' => '39', // Canada
                'email_verified_at' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Carlos Rodriguez',
                'username' => 'carlos-rodriguez',
                'email' => 'carlos@wonegig.com',
                'password' => bcrypt('12345678'),
                'country_id' => '232', // UK
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
        
        $users = User::whereNotNull('email_verified_at')->take(8)->get();

        if ($boosters->isEmpty()) {
            $this->command->warn('No boosters found. Please run BoostersSeeder first.');
            return;
        }

        // Create subscriptions
        $subscriptions = [
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'booster_id' => $boosters->random()->id,
                'cost' => 2500, // NGN
                'currency' => 'NGN',
                'multiplier' => 2,
                'duration_days' => 1,
                'starts_at' => now()->subDays(15),
                'expires_at' => now()->addDays(15),
                'billing_cycle' => 'monthly',
                
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'booster_id' => $boosters->random()->id,
                'cost' => 5.99, // USD
                'currency' => 'USD',
                'multiplier' => 3,
                'duration_days' => 3,
                'starts_at' => now()->subDays(30),
                'expires_at' => now()->addDays(60),
                'billing_cycle' => 'monthly',
                
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'booster_id' => $boosters->random()->id,
                'cost' => 7500, // NGN
                'currency' => 'NGN',
                'multiplier' => 5,
                'duration_days' => 6,
                'starts_at' => now()->subDays(10),
                'expires_at' => now()->addDays(170),
                'billing_cycle' => 'monthly',
                
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'booster_id' => $boosters->random()->id,
                'cost' => 12.99, // USD
                'currency' => 'USD',
                'multiplier' => 2,
                'duration_days' => 1,
                'starts_at' => now()->subDays(5),
                'expires_at' => now()->addDays(25),
                'billing_cycle' => 'monthly',
                
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'booster_id' => $boosters->random()->id,
                'cost' => 5000, // NGN
                'currency' => 'NGN',
                'multiplier' => 3,
                'duration_days' => 2,
                'starts_at' => now()->subDays(20),
                'expires_at' => now()->addDays(40),
                'billing_cycle' => 'monthly',
                
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'booster_id' => $boosters->random()->id,
                'cost' => 19.99, // USD
                'currency' => 'USD',
                'multiplier' => 4,
                'duration_days' => 3,
                'starts_at' => now()->subDays(7),
                'expires_at' => now()->addDays(83),
                'billing_cycle' => 'monthly',
                
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'booster_id' => $boosters->random()->id,
                'cost' => 3000, // NGN
                'currency' => 'NGN',
                'multiplier' => 2,
                'duration_days' => 1,
                'starts_at' => now()->subDays(2),
                'expires_at' => now()->addDays(28),
                'billing_cycle' => 'monthly',
                
            ],
            [
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'booster_id' => $boosters->random()->id,
                'cost' => 8.99, // USD
                'currency' => 'USD',
                'multiplier' => 3,
                'duration_days' => 2,
                'starts_at' => now()->subDays(1),
                'expires_at' => now()->addDays(59),
                'billing_cycle' => 'monthly',
                
            ],
        ];

        foreach ($subscriptions as $subscriptionData) {
            Subscription::updateOrCreate(
                [
                    'user_id' => $subscriptionData['user_id'],
                    'booster_id' => $subscriptionData['booster_id'],
                    'starts_at' => $subscriptionData['starts_at'],
                ],
                [
                    'cost' => $subscriptionData['cost'],
                    'currency' => $subscriptionData['currency'],
                    'multiplier' => $subscriptionData['multiplier'],
                    'duration_days' => $subscriptionData['duration_days'],
                    'expires_at' => $subscriptionData['expires_at'],
                    'billing_cycle' => $subscriptionData['billing_cycle'],
                ]
            );
        }

        $this->command->info('User subscriptions seeded successfully.');
    }
}
