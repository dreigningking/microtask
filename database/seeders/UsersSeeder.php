<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
                    [
                        'name' => 'Super Admin', 
                        'username' => 'super-admin', 
                        'email' => 'info@wonegig.com', 
                        'phone' => '012345678', 
                        'country_id' => 161, 
                        'role_id' => 1, 
                        'email_verified_at' => now(), 
                        'password' => Hash::make(12345678),
                        'is_active'=> 1,
                        'dashboard_view'=> 'tasks',
                        'two_factor_enabled'=> 1,
                    ],
                    [
                        'name' => 'Country Manager', 
                        'username' => 'country-manager', 
                        'email' => 'manager@wonegig.com', 
                        'phone' => '987654321', 
                        'country_id' => 161, 
                        'role_id' => 2, 
                        'email_verified_at' => now(), 
                        'password' => Hash::make(12345678),
                        'is_active'=> 1,
                        'dashboard_view'=> 'tasks',
                        'two_factor_enabled'=> 1,
                    ],
                    [
                        'name' => 'User Support', 
                        'username' => 'user-support', 
                        'email' => 'support@wonegig.com', 
                        'phone' => '876543210', 
                        'country_id' => 161, 
                        'role_id' => 3, 
                        'email_verified_at' => now(), 
                        'password' => Hash::make(12345678),
                        'is_active'=> 1,
                        'dashboard_view'=> 'tasks',
                        'two_factor_enabled'=> 1,
                    ],
                    [
                        'name' => 'Financial Analyst', 
                        'username' => 'financial-analyst', 
                        'email' => 'finance@wonegig.com', 
                        'phone' => '76543210', 
                        'country_id' => 161, 
                        'role_id' => 4, 
                        'email_verified_at' => now(), 
                        'password' => Hash::make(12345678),
                        'is_active'=> 1,
                        'dashboard_view'=> 'tasks',
                        'two_factor_enabled'=> 1,
                    ],
                    [
                        'name' => 'John Doe', 
                        'username' => 'john-doe', 
                        'email' => 'johndoe@wonegig.com', 
                        'phone' => '012345678', 
                        'country_id' => 161, 
                        'role_id' => null, 
                        'email_verified_at' => now(), 
                        'password' => Hash::make(12345678),
                        'is_active'=> 1,
                        'dashboard_view'=> 'tasks',
                        'two_factor_enabled'=> 1,
                    ],
                    [
                        'name' => 'Bob Alice', 
                        'username' => 'bob-alice', 
                        'email' => 'bobalice@wonegig.com', 
                        'phone' => '012345678', 
                        'country_id' => 161, 
                        'role_id' => null, 
                        'email_verified_at' => now(), 
                        'password' => Hash::make(12345678),
                        'is_active'=> 1,
                        'dashboard_view'=> 'tasks',
                        'two_factor_enabled'=> 1,
                    ],
                    // add more users where role_id is null. 
                    // add users with country_ids 233 (USA), 39 (Canada), 232 (UK), 161 (Nigeria), 113 (Kenya), 83 (Ghana), 101 (India), 14 (Australia)
            ];
            

            DB::table('users')->insert($users);
    }
}
