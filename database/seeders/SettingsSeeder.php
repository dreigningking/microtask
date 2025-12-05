<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Global Settings
        $globalSettings = [
            [
                'name' => 'task_application_limit_per_day',
                'value' => '2',
                'data_type' => 'integer',
            ],
            [
                'name' => 'maximum_tasks_at_hand',
                'value' => '10',
                'data_type' => 'integer',
            ],
            [
                'name' => 'multiple_submission_interval_minutes',
                'value' => '60',
                'data_type' => 'integer',
            ],
            [
                'name' => 'submission_review_deadline',
                'value' => '24',
                'data_type' => 'integer',
            ],
            [
                'name' => 'enable_system_submission_review',
                'value' => '0',
                'data_type' => 'boolean',
            ],
            [
                'name' => 'freeze_wallets_globally',
                'value' => '0',
                'data_type' => 'boolean',
            ],
            [
                'name' => 'allow_wallet_funds_exchange',
                'value' => '0',
                'data_type' => 'boolean',
            ],
            [
                'name' => 'invitation_expiry_day',
                'value' => '7',
                'data_type' => 'integer',
            ],
            [
                'name' => 'enforce_2fa',
                'value' => '1',
                'data_type' => 'boolean',
            ],
            [
                'name' => 'auto_ban_on_flag_hours_count',
                'value'=> 72,
                'data_type' => 'integer',
            ],
        ];

        foreach ($globalSettings as $setting) {
            Setting::updateOrCreate(
                ['name' => $setting['name']],
                [
                    'value' => $setting['value'],
                    'data_type' => $setting['data_type'],
                ]
            );
        }

        $this->command->info('Global settings seeded successfully.');
    }
}
