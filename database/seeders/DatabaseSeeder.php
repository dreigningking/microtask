<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            SettingsSeeder::class,
            GatewaysSeeder::class,
            BoostersSeeder::class,
            PlatformsSeeder::class,
            PlatformTemplatesSeeder::class,
            CountrySettingsSeeder::class,
            UsersSeeder::class,
            UserSubscriptionsSeeder::class,
            InterestsSeeder::class,
            PostsSeeder::class,
            TasksSeeder::class,
            TaskWorkersSeeder::class,
            UserNotificationsSeeder::class,

        ]);
    }
}
