<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gateway;

class GatewaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                'name' => 'Stripe',
                'slug' => 'stripe',
                'bank_account_storage' => 'off_premises',
                'banking_fields' => [
                    ['title' => 'Connect Bank Details', 'slug' => 'connect_stripe', 'type' => 'button', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => ''],
                ]
            ],
            [
                'name' => 'Paystack',
                'slug' => 'paystack',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 10, 'max_length' => 10, 'placeholder' => 'Enter account number'],
                    ['title' => 'BVN', 'slug' => 'bvn', 'type' => 'number', 'default' => null, 'min_length' => 11, 'max_length' => 11, 'placeholder' => 'Enter BVN'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number'],
                    ['title' => 'Branch', 'slug' => 'branch', 'type' => 'options', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'M-Pesa',
                'slug' => 'mpesa',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 6, 'max_length' => 15, 'placeholder' => 'Enter account number'],
                    ['title' => 'SWIFT Code', 'slug' => 'swift_code', 'type' => 'text', 'default' => '', 'min_length' => 8, 'max_length' => 11, 'placeholder' => 'Enter SWIFT code'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'Flutterwave',
                'slug' => 'flutterwave',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 15, 'placeholder' => 'Enter account number'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number'],
                    ['title' => 'Branch', 'slug' => 'branch', 'type' => 'options', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'Razorpay',
                'slug' => 'razorpay',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 11, 'max_length' => 18, 'placeholder' => 'Enter account number'],
                    ['title' => 'IFSC Code', 'slug' => 'ifsc_code', 'type' => 'text', 'default' => '', 'min_length' => 11, 'max_length' => 11, 'placeholder' => 'Enter IFSC code'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'PayPal',
                'slug' => 'paypal',
                'bank_account_storage' => 'off_premises',
                'banking_fields' => [
                    ['title' => 'PayPal Email', 'slug' => 'paypal_email', 'type' => 'email', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter PayPal email address']
                ]
            ],
            [
                'name' => 'Adyen',
                'slug' => 'adyen',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 25, 'placeholder' => 'Enter account number'],
                    ['title' => 'Routing Number', 'slug' => 'routing_number', 'type' => 'number', 'default' => null, 'min_length' => 9, 'max_length' => 9, 'placeholder' => 'Enter routing number'],
                    ['title' => 'SWIFT Code', 'slug' => 'swift_code', 'type' => 'text', 'default' => '', 'min_length' => 8, 'max_length' => 11, 'placeholder' => 'Enter SWIFT code'],
                    ['title' => 'IBAN Number', 'slug' => 'iban_number', 'type' => 'text', 'default' => '', 'min_length' => 15, 'max_length' => 34, 'placeholder' => 'Enter IBAN number']
                ]
            ],
            [
                'name' => 'Square',
                'slug' => 'square',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 17, 'placeholder' => 'Enter account number'],
                    ['title' => 'Routing Number', 'slug' => 'routing_number', 'type' => 'number', 'default' => null, 'min_length' => 9, 'max_length' => 9, 'placeholder' => 'Enter routing number']
                ]
            ],
            [
                'name' => 'Checkout.com',
                'slug' => 'checkout',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 25, 'placeholder' => 'Enter account number'],
                    ['title' => 'Routing Number', 'slug' => 'routing_number', 'type' => 'number', 'default' => null, 'min_length' => 9, 'max_length' => 9, 'placeholder' => 'Enter routing number'],
                    ['title' => 'SWIFT Code', 'slug' => 'swift_code', 'type' => 'text', 'default' => '', 'min_length' => 8, 'max_length' => 11, 'placeholder' => 'Enter SWIFT code'],
                    ['title' => 'IBAN Number', 'slug' => 'iban_number', 'type' => 'text', 'default' => '', 'min_length' => 15, 'max_length' => 34, 'placeholder' => 'Enter IBAN number']
                ]
            ],
            [
                'name' => 'Mollie',
                'slug' => 'mollie',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 25, 'placeholder' => 'Enter account number'],
                    ['title' => 'IBAN Number', 'slug' => 'iban_number', 'type' => 'text', 'default' => '', 'min_length' => 15, 'max_length' => 34, 'placeholder' => 'Enter IBAN number']
                ]
            ],
            [
                'name' => 'Wise',
                'slug' => 'wise',
                'bank_account_storage' => 'off_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 25, 'placeholder' => 'Enter account number'],
                    ['title' => 'SWIFT Code', 'slug' => 'swift_code', 'type' => 'text', 'default' => '', 'min_length' => 8, 'max_length' => 11, 'placeholder' => 'Enter SWIFT code'],
                    ['title' => 'IBAN Number', 'slug' => 'iban_number', 'type' => 'text', 'default' => '', 'min_length' => 15, 'max_length' => 34, 'placeholder' => 'Enter IBAN number']
                ]
            ],
            [
                'name' => 'GoCardless',
                'slug' => 'gocardless',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 25, 'placeholder' => 'Enter account number'],
                    ['title' => 'IBAN Number', 'slug' => 'iban_number', 'type' => 'text', 'default' => '', 'min_length' => 15, 'max_length' => 34, 'placeholder' => 'Enter IBAN number'],
                    ['title' => 'Sort Code', 'slug' => 'sort_code', 'type' => 'number', 'default' => null, 'min_length' => 6, 'max_length' => 6, 'placeholder' => 'Enter sort code']
                ]
            ],
            [
                'name' => 'Interswitch',
                'slug' => 'interswitch',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 10, 'max_length' => 10, 'placeholder' => 'Enter account number'],
                    ['title' => 'BVN', 'slug' => 'bvn', 'type' => 'number', 'default' => null, 'min_length' => 11, 'max_length' => 11, 'placeholder' => 'Enter BVN'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'Okra',
                'slug' => 'okra',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 10, 'max_length' => 10, 'placeholder' => 'Enter account number'],
                    ['title' => 'BVN', 'slug' => 'bvn', 'type' => 'number', 'default' => null, 'min_length' => 11, 'max_length' => 11, 'placeholder' => 'Enter BVN']
                ]
            ],
            [
                'name' => 'Paga',
                'slug' => 'paga',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 10, 'max_length' => 10, 'placeholder' => 'Enter account number'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'Cellulant',
                'slug' => 'cellulant',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 15, 'placeholder' => 'Enter account number'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'DPO Group',
                'slug' => 'dpo',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 15, 'placeholder' => 'Enter account number'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            
            [
                'name' => 'MFS Africa',
                'slug' => 'mfs',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 15, 'placeholder' => 'Enter account number'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'Plaid',
                'slug' => 'plaid',
                'bank_account_storage' => 'off_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 17, 'placeholder' => 'Enter account number'],
                    ['title' => 'Routing Number', 'slug' => 'routing_number', 'type' => 'number', 'default' => null, 'min_length' => 9, 'max_length' => 9, 'placeholder' => 'Enter routing number']
                ]
            ],
            [
                'name' => 'TrueLayer',
                'slug' => 'truelayer',
                'bank_account_storage' => 'off_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 25, 'placeholder' => 'Enter account number'],
                    ['title' => 'IBAN Number', 'slug' => 'iban_number', 'type' => 'text', 'default' => '', 'min_length' => 15, 'max_length' => 34, 'placeholder' => 'Enter IBAN number'],
                    ['title' => 'Sort Code', 'slug' => 'sort_code', 'type' => 'number', 'default' => null, 'min_length' => 6, 'max_length' => 6, 'placeholder' => 'Enter sort code']
                ]
            ],
            [
                'name' => 'Tink',
                'slug' => 'tink',
                'bank_account_storage' => 'off_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 25, 'placeholder' => 'Enter account number'],
                    ['title' => 'IBAN Number', 'slug' => 'iban_number', 'type' => 'text', 'default' => '', 'min_length' => 15, 'max_length' => 34, 'placeholder' => 'Enter IBAN number']
                ]
            ],
            [
                'name' => 'Nordigen',
                'slug' => 'nordigen',
                'bank_account_storage' => 'off_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 25, 'placeholder' => 'Enter account number'],
                    ['title' => 'IBAN Number', 'slug' => 'iban_number', 'type' => 'text', 'default' => '', 'min_length' => 15, 'max_length' => 34, 'placeholder' => 'Enter IBAN number']
                ]
            ],
            [
                'name' => 'Belvo',
                'slug' => 'belvo',
                'bank_account_storage' => 'off_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 17, 'placeholder' => 'Enter account number'],
                    ['title' => 'Routing Number', 'slug' => 'routing_number', 'type' => 'number', 'default' => null, 'min_length' => 9, 'max_length' => 9, 'placeholder' => 'Enter routing number']
                ]
            ],
            [
                'name' => 'Akoya',
                'slug' => 'akoya',
                'bank_account_storage' => 'off_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 8, 'max_length' => 17, 'placeholder' => 'Enter account number'],
                    ['title' => 'Routing Number', 'slug' => 'routing_number', 'type' => 'number', 'default' => null, 'min_length' => 9, 'max_length' => 9, 'placeholder' => 'Enter routing number']
                ]
            ],
            [
                'name' => 'Mono',
                'slug' => 'mono',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 10, 'max_length' => 10, 'placeholder' => 'Enter account number'],
                    ['title' => 'BVN', 'slug' => 'bvn', 'type' => 'number', 'default' => null, 'min_length' => 11, 'max_length' => 11, 'placeholder' => 'Enter BVN']
                ]
            ],
            [
                'name' => 'MTN Mobile Money',
                'slug' => 'mtn',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'Airtel Money',
                'slug' => 'airtel',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'Orange Money',
                'slug' => 'orange',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'GCash',
                'slug' => 'gcash',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
            [
                'name' => 'Paytm',
                'slug' => 'paytm',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number'],
                    ['title' => 'Bank Name', 'slug' => 'bank_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter bank name'],
                    ['title' => 'Account Number', 'slug' => 'account_number', 'type' => 'number', 'default' => null, 'min_length' => 10, 'max_length' => 18, 'placeholder' => 'Enter account number'],
                    ['title' => 'IFSC Code', 'slug' => 'ifsc_code', 'type' => 'text', 'default' => '', 'min_length' => 11, 'max_length' => 11, 'placeholder' => 'Enter IFSC code']
                ]
            ],
            [
                'name' => 'Wave',
                'slug' => 'wave',
                'bank_account_storage' => 'on_premises',
                'banking_fields' => [
                    ['title' => 'Account Name', 'slug' => 'account_name', 'type' => 'text', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter account holder name'],
                    ['title' => 'Phone Number', 'slug' => 'phone_number', 'type' => 'tel', 'default' => '', 'min_length' => '', 'max_length' => '', 'placeholder' => 'Enter phone number']
                ]
            ],
        ];

        foreach ($gateways as $gateway) {
            Gateway::updateOrCreate(
                ['slug' => $gateway['slug']],
                $gateway
            );
        }

        $this->command->info('Gateways seeded successfully.');
    }
}