<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CountrySetting;
use App\Models\CountryPrice;

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
                'gateway' => 'stripe',
                'banking_settings' => json_encode([
                    'account_length' => '10',
                    'require_account_verification' => true,
                    'account_verification_method' => 'gateway',
                    'bank_account_storage' => 'on_premises'
                ]),
                'banking_fields' => json_encode(['account_name', 'bank_name', 'account_number', 'routing_number', 'swift_code']),
                'verification_fields' => json_encode([
                    'govt_id' => ['file' => ['national_id'], 'require' => 'one', 'expiry_date' => 'nullable'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => 'date', 'expiry_date' => 'nullable']
                ]),
                'promotion_settings' => json_encode(['feature_rate' => 2.50, 'broadcast_rate' => 1.50]),
                'transaction_settings' => json_encode(['percentage' => 2.5, 'fixed' => 0.30, 'cap' => 25.00]),
                'withdrawal_settings' => json_encode(['percentage' => 1.5, 'fixed' => 0.25, 'min_withdrawal' => 10.00, 'max_withdrawal' => 5000.00]),
                'wallet_settings' => json_encode(['wallet_status' => true, 'usd_exchange_rate_percentage' => 0]),
                'referral_settings' => json_encode(['referral_earnings_percentage' => 5.0, 'invitee_commission_percentage' => 3.0]),
                'review_settings' => json_encode(['admin_review_cost' => 0.50, 'system_review_cost' => 0.25]),
                'security_settings' => json_encode(['ban_settings' => ['auto_ban_on_flag_count' => 5, 'ban_duration' => 'week']]),
            ],
            39 => [ // Canada
                'gateway' => 'stripe',
                'banking_settings' => json_encode([
                    'account_length' => '8',
                    'require_account_verification' => true,
                    'account_verification_method' => 'gateway',
                    'bank_account_storage' => 'on_premises'
                ]),
                'banking_fields' => json_encode(['account_name', 'bank_name', 'account_number', 'routing_number']),
                'verification_fields' => json_encode([
                    'govt_id' => ['file' => ['national_id'], 'require' => 'one', 'expiry_date' => 'date'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => 'date']
                ]),
                'promotion_settings' => json_encode(['feature_rate' => 2.25, 'broadcast_rate' => 1.35]),
                'transaction_settings' => json_encode(['percentage' => 2.4, 'fixed' => 0.25, 'cap' => 20.00]),
                'withdrawal_settings' => json_encode(['percentage' => 1.25, 'fixed' => 0.25, 'min_withdrawal' => 8.00, 'max_withdrawal' => 4000.00]),
                'wallet_settings' => json_encode(['wallet_status' => true, 'usd_exchange_rate_percentage' => 5.0]),
                'referral_settings' => json_encode(['referral_earnings_percentage' => 4.5, 'invitee_commission_percentage' => 2.8]),
                'review_settings' => json_encode(['admin_review_cost' => 0.45, 'system_review_cost' => 0.22]),
                'security_settings' => json_encode(['ban_settings' => ['auto_ban_on_flag_count' => 5, 'ban_duration' => 'week']]),
            ],
            232 => [ // UK
                'gateway' => 'stripe',
                'banking_settings' => json_encode([
                    'account_length' => '8',
                    'require_account_verification' => true,
                    'account_verification_method' => 'gateway',
                    'bank_account_storage' => 'on_premises'
                ]),
                'banking_fields' => json_encode(['account_name', 'bank_name', 'account_number', 'sort_code', 'iban_number']),
                'verification_fields' => json_encode([
                    'govt_id' => ['file' => ['passport', 'national_id'], 'require' => 'one', 'expiry_date' => 'date'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => 'date']
                ]),
                'promotion_settings' => json_encode(['feature_rate' => 2.00, 'broadcast_rate' => 1.20]),
                'transaction_settings' => json_encode(['percentage' => 2.3, 'fixed' => 0.20, 'cap' => 18.00]),
                'withdrawal_settings' => json_encode(['percentage' => 1.0, 'fixed' => 0.20, 'min_withdrawal' => 6.00, 'max_withdrawal' => 3500.00]),
                'wallet_settings' => json_encode(['wallet_status' => true, 'usd_exchange_rate_percentage' => 10.0]),
                'referral_settings' => json_encode(['referral_earnings_percentage' => 4.0, 'invitee_commission_percentage' => 2.5]),
                'review_settings' => json_encode(['admin_review_cost' => 0.40, 'system_review_cost' => 0.20]),
                'security_settings' => json_encode(['ban_settings' => ['auto_ban_on_flag_count' => 5, 'ban_duration' => 'week']]),
            ],
            161 => [ // Nigeria
                'gateway' => 'paystack',
                'banking_settings' => json_encode([
                    'account_length' => '10',
                    'require_account_verification' => true,
                    'account_verification_method' => 'gateway',
                    'bank_account_storage' => 'on_premises'
                ]),
                'banking_fields' => json_encode(['account_name', 'bank_name', 'account_number', 'bvn']),
                'verification_fields' => json_encode([
                    'govt_id' => ['file' => ['national_id', 'nin', 'passport'], 'require' => 'one', 'expiry_date' => 'nullable'],
                    'address' => ['file' => ['utility_bill', 'waste_bill'], 'require' => 'one', 'issue_date' => 'date']
                ]),
                'promotion_settings' => json_encode(['feature_rate' => 1.00, 'broadcast_rate' => 0.75]),
                'transaction_settings' => json_encode(['percentage' => 2.0, 'fixed' => 15.00, 'cap' => 2000.00]),
                'withdrawal_settings' => json_encode(['percentage' => 1.0, 'fixed' => 10.00, 'min_withdrawal' => 500.00, 'max_withdrawal' => 500000.00]),
                'wallet_settings' => json_encode(['wallet_status' => true, 'usd_exchange_rate_percentage' => 15.0]),
                'referral_settings' => json_encode(['referral_earnings_percentage' => 3.0, 'invitee_commission_percentage' => 2.0]),
                'review_settings' => json_encode(['admin_review_cost' => 50.00, 'system_review_cost' => 25.00]),
                'security_settings' => json_encode(['ban_settings' => ['auto_ban_on_flag_count' => 3, 'ban_duration' => 'day']]),
            ],
            113 => [ // Kenya
                'gateway' => 'mpesa',
                'banking_settings' => json_encode([
                    'account_length' => '6',
                    'require_account_verification' => false,
                    'account_verification_method' => 'manual',
                    'bank_account_storage' => 'on_premises'
                ]),
                'banking_fields' => json_encode(['account_name', 'bank_name', 'account_number', 'swift_code']),
                'verification_fields' => json_encode([
                    'govt_id' => ['file' => ['national_id', 'passport'], 'require' => 'one', 'expiry_date' => 'date'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => 'date']
                ]),
                'promotion_settings' => json_encode(['feature_rate' => 0.75, 'broadcast_rate' => 0.50]),
                'transaction_settings' => json_encode(['percentage' => 2.5, 'fixed' => 50.00, 'cap' => 5000.00]),
                'withdrawal_settings' => json_encode(['percentage' => 1.5, 'fixed' => 25.00, 'min_withdrawal' => 100.00, 'max_withdrawal' => 100000.00]),
                'wallet_settings' => json_encode(['wallet_status' => true, 'usd_exchange_rate_percentage' => 20.0]),
                'referral_settings' => json_encode(['referral_earnings_percentage' => 2.5, 'invitee_commission_percentage' => 1.5]),
                'review_settings' => json_encode(['admin_review_cost' => 25.00, 'system_review_cost' => 12.50]),
                'security_settings' => json_encode(['ban_settings' => ['auto_ban_on_flag_count' => 4, 'ban_duration' => 'day']]),
            ],
            83 => [ // Ghana
                'gateway' => 'flutterwave',
                'banking_settings' => json_encode([
                    'account_length' => '8',
                    'require_account_verification' => true,
                    'account_verification_method' => 'manual',
                    'bank_account_storage' => 'on_premises'
                ]),
                'banking_fields' => json_encode(['account_name', 'bank_name', 'account_number']),
                'verification_fields' => json_encode([
                    'govt_id' => ['file' => ['national_id', 'passport'], 'require' => 'one', 'expiry_date' => 'date'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => 'date']
                ]),
                'promotion_settings' => json_encode(['feature_rate' => 0.60, 'broadcast_rate' => 0.40]),
                'transaction_settings' => json_encode(['percentage' => 2.8, 'fixed' => 30.00, 'cap' => 3000.00]),
                'withdrawal_settings' => json_encode(['percentage' => 1.25, 'fixed' => 20.00, 'min_withdrawal' => 50.00, 'max_withdrawal' => 75000.00]),
                'wallet_settings' => json_encode(['wallet_status' => true, 'usd_exchange_rate_percentage' => 18.0]),
                'referral_settings' => json_encode(['referral_earnings_percentage' => 2.0, 'invitee_commission_percentage' => 1.25]),
                'review_settings' => json_encode(['admin_review_cost' => 20.00, 'system_review_cost' => 10.00]),
                'security_settings' => json_encode(['ban_settings' => ['auto_ban_on_flag_count' => 4, 'ban_duration' => 'day']]),
            ],
            101 => [ // India
                'gateway' => 'razorpay',
                'banking_settings' => json_encode([
                    'account_length' => '11',
                    'require_account_verification' => true,
                    'account_verification_method' => 'gateway',
                    'bank_account_storage' => 'on_premises'
                ]),
                'banking_fields' => json_encode(['account_name', 'bank_name', 'account_number', 'ifsc_code']),
                'verification_fields' => json_encode([
                    'govt_id' => ['file' => ['national_id', 'passport'], 'require' => 'one', 'expiry_date' => 'nullable'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => 'date']
                ]),
                'promotion_settings' => json_encode(['feature_rate' => 0.85, 'broadcast_rate' => 0.55]),
                'transaction_settings' => json_encode(['percentage' => 2.0, 'fixed' => 3.00, 'cap' => 500.00]),
                'withdrawal_settings' => json_encode(['percentage' => 1.0, 'fixed' => 5.00, 'min_withdrawal' => 50.00, 'max_withdrawal' => 75000.00]),
                'wallet_settings' => json_encode(['wallet_status' => true, 'usd_exchange_rate_percentage' => 22.0]),
                'referral_settings' => json_encode(['referral_earnings_percentage' => 2.75, 'invitee_commission_percentage' => 1.75]),
                'review_settings' => json_encode(['admin_review_cost' => 10.00, 'system_review_cost' => 5.00]),
                'security_settings' => json_encode(['ban_settings' => ['auto_ban_on_flag_count' => 4, 'ban_duration' => 'day']]),
            ],
            14 => [ // Australia
                'gateway' => 'stripe',
                'banking_settings' => json_encode([
                    'account_length' => '6',
                    'require_account_verification' => true,
                    'account_verification_method' => 'gateway',
                    'bank_account_storage' => 'on_premises'
                ]),
                'banking_fields' => json_encode(['account_name', 'bank_name', 'account_number', 'bsb_code']),
                'verification_fields' => json_encode([
                    'govt_id' => ['file' => ['drivers_license', 'passport'], 'require' => 'one', 'expiry_date' => 'date'],
                    'address' => ['file' => ['utility_bill'], 'require' => 'one', 'issue_date' => 'date']
                ]),
                'promotion_settings' => json_encode(['feature_rate' => 2.75, 'broadcast_rate' => 1.65]),
                'transaction_settings' => json_encode(['percentage' => 2.7, 'fixed' => 0.35, 'cap' => 28.00]),
                'withdrawal_settings' => json_encode(['percentage' => 1.75, 'fixed' => 0.30, 'min_withdrawal' => 12.00, 'max_withdrawal' => 4500.00]),
                'wallet_settings' => json_encode(['wallet_status' => true, 'usd_exchange_rate_percentage' => 8.0]),
                'referral_settings' => json_encode(['referral_earnings_percentage' => 4.25, 'invitee_commission_percentage' => 2.75]),
                'review_settings' => json_encode(['admin_review_cost' => 0.55, 'system_review_cost' => 0.28]),
                'security_settings' => json_encode(['ban_settings' => ['auto_ban_on_flag_count' => 5, 'ban_duration' => 'week']]),
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
