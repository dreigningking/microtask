<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CountrySetting;
use App\Models\CountryPrice;
use App\Models\PlatformTemplate;

class CountrySettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Country IDs: 233 (USA), 39 (Canada), 232 (UK), 161 (Nigeria), 113 (Kenya), 83 (Ghana), 101 (India), 14 (Australia)

        $countries = [
            233 => [ // USA
                'gateway_id' => 1,
                'banking_settings' => [
                    'account_verification_required' => true,
                    'account_verification_method' => 'gateway',
                ],
                'banking_fields' => [],
                'verification_settings' => [
                    'verification_provider' => 'veriff',
                    
                ],
                'verification_fields' => [
                    'govt_id' => ['file' => ['national_id'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false]
                ],
                'promotion_settings' => ['feature_rate' => 2.50, 'broadcast_rate' => 1.50],
                'transaction_settings' => [
                    'charges' => ['percentage' => 2.5, 'fixed' => 0.30, 'cap' => 25.00],
                    'tax' => ['percentage' => 0.0, 'apply' => false]
                ],
                'withdrawal_settings' => [
                    'charges' => ['percentage' => 1.5, 'fixed' => 0.25, 'cap' => 10.00],
                    'min_withdrawal' => 10.00,
                    'max_withdrawal' => 5000.00,
                    'method' => 'gateway',
                    'weekend_payout' => true,
                    'holiday_payout' => false
                ],
                'wallet_settings' => ['wallet_status' => true, 'usd_exchange_rate' => 0],
                'referral_settings' => ['signup_referral_earnings_percentage' => 5.0, 'task_referral_commission_percentage' => 3.0],
                'review_settings' => ['admin_review_cost' => 0.50, 'system_review_cost' => 0.25],
                
            ],
            39 => [ // Canada
                'gateway_id' => 1,
                'banking_settings' => [
                    'account_verification_required' => true,
                    'account_verification_method' => 'gateway',
                ],
                'banking_fields' => [],
                'verification_settings' => [
                    'verification_provider' => 'veriff',
                    
                ],
                'verification_fields' => [
                    'govt_id' => ['file' => ['national_id'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => 'date'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false]
                ],
                'promotion_settings' => ['feature_rate' => 2.25, 'broadcast_rate' => 1.35],
                'transaction_settings' => [
                    'charges' => ['percentage' => 2.4, 'fixed' => 0.25, 'cap' => 20.00],
                    'tax' => ['percentage' => 0.0, 'apply' => false]
                ],
                'withdrawal_settings' => [
                    'charges' => ['percentage' => 1.25, 'fixed' => 0.25, 'cap' => 10.00],
                    'min_withdrawal' => 8.00,
                    'max_withdrawal' => 4000.00,
                    'method' => 'gateway',
                    'weekend_payout' => true,
                    'holiday_payout' => false
                ],
                'wallet_settings' => ['wallet_status' => true, 'usd_exchange_rate' => 5.0],
                'referral_settings' => ['signup_referral_earnings_percentage' => 4.5, 'task_referral_commission_percentage' => 2.8],
                'review_settings' => ['admin_review_cost' => 0.45, 'system_review_cost' => 0.22],
                
            ],
            232 => [ // UK
                'gateway_id' => 6,
                'banking_settings' => [
                    'account_verification_required' => true,
                    'account_verification_method' => 'gateway',
                ],
                'banking_fields' => [
                    ['title' => 'Paypal Email', 'slug' => 'paypal_email', 'type' => 'email', 'default' => null, 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter paypal email'],
                ],

                'verification_settings' => [
                    'verification_provider' => 'veriff',
                    
                ],
                'verification_fields' => [
                    'govt_id' => ['file' => ['passport', 'national_id'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => 'date'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false]
                ],
                'promotion_settings' => ['feature_rate' => 2.00, 'broadcast_rate' => 1.20],
                'transaction_settings' => [
                    'charges' => ['percentage' => 2.3, 'fixed' => 0.20, 'cap' => 18.00],
                    'tax' => ['percentage' => 20.0, 'apply' => true]
                ],
                'withdrawal_settings' => [
                    'charges' => ['percentage' => 1.0, 'fixed' => 0.20, 'cap' => 10.00],
                    'min_withdrawal' => 6.00,
                    'max_withdrawal' => 3500.00,
                    'method' => 'gateway',
                    'weekend_payout' => true,
                    'holiday_payout' => false
                ],
                'wallet_settings' => ['wallet_status' => true, 'usd_exchange_rate' => 10.0],
                'referral_settings' => ['signup_referral_earnings_percentage' => 4.0, 'task_referral_commission_percentage' => 2.5],
                'review_settings' => ['admin_review_cost' => 0.40, 'system_review_cost' => 0.20],
            ],
            161 => [ // Nigeria
                'gateway_id' => 2,
                'banking_settings' => [
                    'account_verification_required' => true,
                    'account_verification_method' => 'gateway',
                ],
                'banking_fields' => [
                    ['title' => 'Bank', 'slug' => 'bank_code', 'type' => 'select', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Select Bank'],
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 10, 'max_length' => 10, 'placeholder' => 'Enter account number'],
                ],
                'transaction_settings' => [
                    'charges' => ['percentage' => 2.0, 'fixed' => 15.00, 'cap' => 2000.00],
                    'tax' => ['percentage' => 7.5, 'apply' => true]
                ],
                'withdrawal_settings' => [
                    'charges' => ['percentage' => 1.0, 'fixed' => 10.00, 'cap' => 100.00],
                    'min_withdrawal' => 500.00,
                    'max_withdrawal' => 500000.00,
                    'method' => 'gateway',
                    'weekend_payout' => true,
                    'holiday_payout' => true
                ],
                'wallet_settings' => ['wallet_status' => true, 'usd_exchange_rate' => 15.0],
                'verification_settings' => [
                    'verification_provider' => 'manual',
                    
                ],
                'verification_fields' => [
                    'govt_id' => ['file' => ['national_id', 'nin', 'passport'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false],
                    'address' => ['file' => ['utility_bill', 'waste_bill'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false]
                ],
                'promotion_settings' => ['feature_rate' => 1.00, 'broadcast_rate' => 0.75],
                'referral_settings' => ['signup_referral_earnings_percentage' => 3.0, 'task_referral_commission_percentage' => 2.0],
                'review_settings' => ['admin_review_cost' => 50.00, 'system_review_cost' => 25.00],
                
            ],
            113 => [ // Kenya
                'gateway_id' => 3,
                'banking_settings' => [
                    'account_verification_required' => true,
                    'account_verification_method' => 'gateway',
                ],
                'banking_fields' => [
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number'],
                ],
                'verification_settings' => [
                    'verification_provider' => 'manual',
                    
                ],
                'verification_fields' => [
                    'govt_id' => ['file' => ['national_id', 'passport'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => 'date'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false]
                ],
                'promotion_settings' => ['feature_rate' => 0.75, 'broadcast_rate' => 0.50],
                'transaction_settings' => [
                    'charges' => ['percentage' => 2.5, 'fixed' => 50.00, 'cap' => 5000.00],
                    'tax' => ['percentage' => 16.0, 'apply' => true]
                ],
                'withdrawal_settings' => [
                    'charges' => ['percentage' => 1.5, 'fixed' => 25.00, 'cap' => 100.00],
                    'min_withdrawal' => 100.00,
                    'max_withdrawal' => 100000.00,
                    'method' => 'manual',
                    'weekend_payout' => false,
                    'holiday_payout' => false
                ],
                'wallet_settings' => ['wallet_status' => true, 'usd_exchange_rate' => 20.0],
                'referral_settings' => ['signup_referral_earnings_percentage' => 2.5, 'task_referral_commission_percentage' => 1.5],
                'review_settings' => ['admin_review_cost' => 25.00, 'system_review_cost' => 12.50],
                
            ],
            83 => [ // Ghana
                'gateway_id' => 4,
                'banking_settings' => [
                    'account_verification_required' => true,
                    'account_verification_method' => 'gateway',
                ],
                'banking_fields' => [
                    ['title' => 'Bank', 'slug' => 'bank_code', 'type' => 'select', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Select Bank'],
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 10, 'max_length' => 10, 'placeholder' => 'Enter account number'],
                    ['title' => 'Branch', 'slug' => 'branch', 'type' => 'select', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Select Branch']
                ],
                'verification_settings' => [
                    'verification_provider' => 'manual',
                    
                ],
                'verification_fields' => [
                    'govt_id' => ['file' => ['national_id', 'passport'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => 'date'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false]
                ],
                'promotion_settings' => ['feature_rate' => 0.60, 'broadcast_rate' => 0.40],
                'transaction_settings' => [
                    'charges' => ['percentage' => 2.8, 'fixed' => 30.00, 'cap' => 3000.00],
                    'tax' => ['percentage' => 15.0, 'apply' => true]
                ],
                'withdrawal_settings' => [
                    'charges' => ['percentage' => 1.25, 'fixed' => 20.00, 'cap' => 100.00],
                    'min_withdrawal' => 50.00,
                    'max_withdrawal' => 75000.00,
                    'method' => 'manual',
                    'weekend_payout' => false,
                    'holiday_payout' => false
                ],
                'wallet_settings' => ['wallet_status' => true, 'usd_exchange_rate' => 18.0],
                'referral_settings' => ['signup_referral_earnings_percentage' => 2.0, 'task_referral_commission_percentage' => 1.25],
                'review_settings' => ['admin_review_cost' => 20.00, 'system_review_cost' => 10.00],
                
            ],
            101 => [ // India
                'gateway_id' => 5,
                'banking_settings' => [
                    'account_verification_required' => true,
                    'account_verification_method' => 'gateway',
                ],
                'banking_fields' => [
                    ['title' => 'Bank', 'slug' => 'bank_code', 'type' => 'select', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Select Bank'],
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 10, 'max_length' => 10, 'placeholder' => 'Enter account number'],
                    ['title' => 'Sort Code', 'slug' => 'sort_code', 'type' => 'text', 'default' => '', 'min_length' => 11, 'max_length' => 11, 'placeholder' => 'Enter Sort Code'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number'],
                    ['title' => 'Branch', 'slug' => 'branch', 'type' => 'select', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Select Branch']
                ],
                'verification_settings' => [
                    'verification_provider' => 'veriff',
                    
                ],
                'verification_fields' => [
                    'govt_id' => ['file' => ['national_id', 'passport'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false]
                ],
                'promotion_settings' => ['feature_rate' => 0.85, 'broadcast_rate' => 0.55],
                'transaction_settings' => [
                    'charges' => ['percentage' => 2.0, 'fixed' => 3.00, 'cap' => 500.00],
                    'tax' => ['percentage' => 18.0, 'apply' => true]
                ],
                'withdrawal_settings' => [
                    'charges' => ['percentage' => 1.0, 'fixed' => 5.00, 'cap' => 100.00],
                    'min_withdrawal' => 50.00,
                    'max_withdrawal' => 75000.00,
                    'method' => 'gateway',
                    'weekend_payout' => true,
                    'holiday_payout' => false
                ],
                'wallet_settings' => ['wallet_status' => true, 'usd_exchange_rate' => 22.0],
                'referral_settings' => ['signup_referral_earnings_percentage' => 2.75, 'task_referral_commission_percentage' => 1.75],
                'review_settings' => ['admin_review_cost' => 10.00, 'system_review_cost' => 5.00],
                
            ],
            14 => [ // Australia
                'gateway_id' => 1,
                'banking_settings' => [
                    'account_verification_required' => true,
                    'account_verification_method' => 'gateway',
                ],
                'banking_fields' => [],
                'verification_settings' => [
                    'verification_provider' => 'veriff',
                    
                ],
                'verification_fields' => [
                    'govt_id' => ['file' => ['drivers_license', 'passport'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => 'date'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => true, 'expiry_date' => false]
                ],
                'promotion_settings' => ['feature_rate' => 2.75, 'broadcast_rate' => 1.65],
                'transaction_settings' => [
                    'charges' => ['percentage' => 2.7, 'fixed' => 0.35, 'cap' => 28.00],
                    'tax' => ['percentage' => 10.0, 'apply' => true]
                ],
                'withdrawal_settings' => [
                    'charges' => ['percentage' => 1.75, 'fixed' => 0.30, 'cap' => 10.00],
                    'min_withdrawal' => 12.00,
                    'max_withdrawal' => 4500.00,
                    'method' => 'gateway',
                    'weekend_payout' => true,
                    'holiday_payout' => false
                ],
                'wallet_settings' => ['wallet_status' => true, 'usd_exchange_rate' => 8.0],
                'referral_settings' => ['signup_referral_earnings_percentage' => 4.25, 'task_referral_commission_percentage' => 2.75],
                'review_settings' => ['admin_review_cost' => 0.55, 'system_review_cost' => 0.28],
                
            ],
        ];

        // Create country settings
        foreach ($countries as $countryId => $settings) {
            CountrySetting::updateOrCreate(
                ['country_id' => $countryId],
                $settings
            );
        }

        $this->command->info('Country settings seeded successfully.');

        // Get all active platform templates
        $templates = PlatformTemplate::where('is_active', true)->get();

        // Create sample country prices for boosters and platform templates
        $prices = [
            // USA (233) prices
            ['country_id' => 233, 'amount' => '5.99', 'priceable_type' => 'App\Models\Booster', 'priceable_id' => 1],
            ['country_id' => 233, 'amount' => '12.99', 'priceable_type' => 'App\Models\Booster', 'priceable_id' => 2],
            ['country_id' => 233, 'amount' => '19.99', 'priceable_type' => 'App\Models\Booster', 'priceable_id' => 3],

            // Nigeria (161) prices
            ['country_id' => 161, 'amount' => '2500', 'priceable_type' => 'App\Models\Booster', 'priceable_id' => 1],
            ['country_id' => 161, 'amount' => '5000', 'priceable_type' => 'App\Models\Booster', 'priceable_id' => 2],
            ['country_id' => 161, 'amount' => '7500', 'priceable_type' => 'App\Models\Booster', 'priceable_id' => 3],
        ];

        // Add random prices for PlatformTemplate for each country
        $countries = [233, 39, 232, 161, 113, 83, 101, 14]; // Country IDs from the seeder
        foreach ($countries as $countryId) {
            foreach ($templates as $template) {
                // Generate random price based on country (higher for developed countries, lower for developing)
                $basePrice = match($countryId) {
                    233 => rand(500, 2000) / 100, // USA: $5.00 - $20.00
                    39 => rand(450, 1800) / 100,  // Canada: $4.50 - $18.00
                    232 => rand(400, 1600) / 100, // UK: $4.00 - $16.00
                    14 => rand(550, 2200) / 100,  // Australia: $5.50 - $22.00
                    161 => rand(2000, 10000),     // Nigeria: ₦2000 - ₦10000
                    113 => rand(500, 2500),       // Kenya: KSh 500 - 2500
                    83 => rand(50, 300),          // Ghana: GH₵ 50 - 300
                    101 => rand(300, 1500),       // India: ₹300 - 1500
                    default => rand(100, 1000) / 100 // Default: $1.00 - $10.00
                };

                $prices[] = [
                    'country_id' => $countryId,
                    'amount' => (string) $basePrice,
                    'priceable_type' => 'App\Models\PlatformTemplate',
                    'priceable_id' => $template->id,
                ];
            }
        }

        foreach ($prices as $price) {
            CountryPrice::updateOrCreate(
                [
                    'country_id' => $price['country_id'],
                    'priceable_type' => $price['priceable_type'],
                    'priceable_id' => $price['priceable_id'],
                ],
                ['amount' => $price['amount']]
            );
        }

        $this->command->info('Country prices seeded successfully.');
    }
}
