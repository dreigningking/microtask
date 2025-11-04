<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PreferredPlatform;
use App\Models\PreferredLocation;
use App\Models\User;
use App\Models\Platform;
use Illuminate\Support\Facades\DB;

class InterestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users, platforms
        $users = User::whereNotNull('email_verified_at')->get();
        $platforms = Platform::all();

        // If no users exist, create some sample users first
        
            $sampleUsers = [
                [
                    'name' => 'Alice Cooper',
                    'username' => 'alice-cooper',
                    'email' => 'alice@wonegig.com',
                    'password' => bcrypt('12345678'),
                    'country_id' => '233', // USA
                    'email_verified_at' => now(),
                    'is_active' => true,
                ],
                [
                    'name' => 'Robert Smith',
                    'username' => 'robert-smith',
                    'email' => 'robert@wonegig.com',
                    'password' => bcrypt('12345678'),
                    'country_id' => '39', // Canada
                    'email_verified_at' => now(),
                    'is_active' => true,
                ],
                [
                    'name' => 'Lisa Anderson',
                    'username' => 'lisa-anderson',
                    'email' => 'lisa@wonegig.com',
                    'password' => bcrypt('12345678'),
                    'country_id' => '232', // UK
                    'email_verified_at' => now(),
                    'is_active' => true,
                ],
                [
                    'name' => 'David Kumar',
                    'username' => 'david-kumar',
                    'email' => 'david@wonegig.com',
                    'password' => bcrypt('12345678'),
                    'country_id' => '161', // Nigeria
                    'email_verified_at' => now(),
                    'is_active' => true,
                ],
                [
                    'name' => 'Maria Garcia',
                    'username' => 'maria-garcia',
                    'email' => 'maria@wonegig.com',
                    'password' => bcrypt('12345678'),
                    'country_id' => '101', // India
                    'email_verified_at' => now(),
                    'is_active' => true,
                ],
                [
                    'name' => 'John Thompson',
                    'username' => 'john-thompson',
                    'email' => 'john@wonegig.com',
                    'password' => bcrypt('12345678'),
                    'country_id' => '14', // Australia
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

        // Country IDs: 233 (USA), 39 (Canada), 232 (UK), 161 (Nigeria), 113 (Kenya), 83 (Ghana), 101 (India), 14 (Australia)
        $availableCountries = ['233', '39', '232', '161', '113', '83', '101', '14'];

        // Create preferred platforms for each user
        foreach ($users as $user) {
            // Each user gets 2-4 preferred platforms randomly
            $userPlatforms = $platforms->random(rand(2, min(4, $platforms->count())));
            
            foreach ($userPlatforms as $platform) {
                PreferredPlatform::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'platform_id' => $platform->id,
                    ],
                    []
                );
            }

            // Each user gets 1-3 preferred countries randomly (excluding their own country)
            $userCountry = $user->country_id;
            $availableForUser = array_filter($availableCountries, function($countryId) use ($userCountry) {
                return $countryId !== $userCountry;
            });
            
            $preferredCountriesCount = rand(1, min(3, count($availableForUser)));
            $preferredCountries = array_rand(array_flip($availableForUser), $preferredCountriesCount);
            
            if (!is_array($preferredCountries)) {
                $preferredCountries = [$preferredCountries];
            }

            foreach ($preferredCountries as $countryId) {
                PreferredLocation::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'country_id' => $countryId,
                    ],
                    []
                );
            }
        }

        // Add some specific platform preferences based on user patterns
        $specificPreferences = [
            // Users from USA prefer US-based platforms
            ['user_email' => 'alice@wonegig.com', 'platform_slugs' => ['facebook', 'twitter', 'instagram']],
            ['user_email' => 'john@wonegig.com', 'platform_slugs' => ['youtube', 'linkedin', 'facebook']],
            
            // Users from Nigeria prefer WhatsApp and global platforms
            ['user_email' => 'david@wonegig.com', 'platform_slugs' => ['whatsapp', 'facebook', 'custom-website']],
            
            // Users from India prefer diverse platforms
            ['user_email' => 'maria@wonegig.com', 'platform_slugs' => ['instagram', 'tiktok', 'mobile-games']],
            
            // Users from UK prefer professional platforms
            ['user_email' => 'lisa@wonegig.com', 'platform_slugs' => ['linkedin', 'twitter', 'survey-sites']],
            
            // Users from Canada prefer mixed platforms
            ['user_email' => 'robert@wonegig.com', 'platform_slugs' => ['facebook', 'youtube', 'review-platforms']],
        ];

        foreach ($specificPreferences as $preference) {
            $user = User::where('email', $preference['user_email'])->first();
            if ($user) {
                foreach ($preference['platform_slugs'] as $slug) {
                    $platform = Platform::where('slug', $slug)->first();
                    if ($platform) {
                        PreferredPlatform::updateOrCreate(
                            [
                                'user_id' => $user->id,
                                'platform_id' => $platform->id,
                            ],
                            []
                        );
                    }
                }
            }
        }

        // Add some specific location preferences
        $specificLocationPreferences = [
            ['user_email' => 'alice@wonegig.com', 'countries' => ['233', '39']], // USA user likes USA and Canada
            ['user_email' => 'david@wonegig.com', 'countries' => ['161', '113', '83']], // Nigeria user likes African countries
            ['user_email' => 'maria@wonegig.com', 'countries' => ['101', '233', '14']], // India user likes diverse countries
            ['user_email' => 'lisa@wonegig.com', 'countries' => ['232', '39', '233']], // UK user likes English-speaking countries
        ];

        foreach ($specificLocationPreferences as $preference) {
            $user = User::where('email', $preference['user_email'])->first();
            if ($user) {
                foreach ($preference['countries'] as $countryId) {
                    PreferredLocation::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'country_id' => $countryId,
                        ],
                        []
                    );
                }
            }
        }

        $this->command->info('Preferred platforms and locations seeded successfully.');
    }
}
