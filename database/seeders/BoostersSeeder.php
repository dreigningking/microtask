<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booster;

class BoostersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boosters = [
            [
                'name' => 'Task Limit Booster',
                'slug' => 'task-limit-booster',
                'description' => 'Increase your daily task application limit and maximum tasks at hand',
                'minimum_duration_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Submission Speed Booster',
                'slug' => 'submission-speed-booster',
                'description' => 'Reduce the interval between multiple task submissions',
                'minimum_duration_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Feature All Tasks',
                'slug' => 'feature-all-tasks',
                'description' => 'Automatically feature all your tasks for better visibility',
                'minimum_duration_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Broadcast All Tasks',
                'slug' => 'broadcast-all-tasks',
                'description' => 'Automatically broadcast all your tasks to reach more workers',
                'minimum_duration_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Withdrawal Limit Booster',
                'slug' => 'withdrawal-limit-booster',
                'description' => 'Increase your maximum withdrawal limit',
                'minimum_duration_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Referral Earnings Booster',
                'slug' => 'referral-earnings-booster',
                'description' => 'Increase your referral earnings and invitee commission percentage',
                'minimum_duration_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Premium Support',
                'slug' => 'premium-support',
                'description' => 'Get priority customer support and faster response times',
                'minimum_duration_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Task Analytics Plus',
                'slug' => 'task-analytics-plus',
                'description' => 'Access detailed analytics and insights for your tasks',
                'minimum_duration_days' => 30,
                'is_active' => true,
            ],
        ];

        foreach ($boosters as $booster) {
            Booster::updateOrCreate(
                ['slug' => $booster['slug']],
                $booster
            );
        }

        $this->command->info('Boosters seeded successfully.');
    }
}
