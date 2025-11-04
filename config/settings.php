<?php


return [
    "global" => [
        'task_application_limit_per_day' => 2,
        'maximum_tasks_at_hand' => 10,
        //submissions
        'multiple_submission_interval_minutes' => 60,
        'submission_review_deadline' => 24,
        'enable_system_submission_review' => 0,
        //wallets
        'freeze_wallets_globally' => 0,
        'allow_wallet_funds_exchange' => 0,
        //others
        'invitation_expiry_day' => 7,
        'enforce_2fa' => 1,
    ],
    "country_settings"=> [
        "gateways"=> [
            'manual','paystack','stripe','paypal','flutterwave','wise','mpesa'
        ],
        "banking_settings"=> [
            'account_length'=> 'number',
            'require_account_verification'=> 'boolean',
            'account_verification_method'=> ['manual','gateway'],
            'bank_account_storage' => ['on_premises','off_premises']
        ],
        "banking_fields"=> [
            "account_name","bank_name","branch_code","account_number","phone_number","bvn","swift_code","sort_code","ifsc_code","routing_number","iban_number","etc"
        ],
        "verification_settings" => [
            "verification_provider" => ['manual','veriff','onfido','sumsub','jumio'],
            "verifications_can_expire" => 'boolean'
        ],
        "verification_fields"=> [
            "govt_id"=>  [
                "file"=> [ "national_id","nin"],
                "require"=> ["all","one"],
                "issue_date" => 'date',
                'expiry_date' => ['date','nullable']
            ],
            "address"=> [
                "file"=> ["electricity_bill","waste_bill"],
                "require"=> ["all","one"],
                "issue_date" => 'date',
                'expiry_date' => ['date','nullable']
            ],
        ],
        "promotion_settings" => ["feature_rate" => 'double',"broadcast_rate"=> 'double'],
        "transaction_settings" => [
            "charges"=> ["percentage"=> 'double',"fixed"=> 'double', "cap"=> 'double'],
            "tax" => ["percentage"=> 'double','apply'=> 'boolean'],
        ],
        "withdrawal_settings" => [
            "charges"=> ["percentage"=> 'double',"fixed"=> 'double', "cap"=> 'double'],
            "min_withdrawal" => 'double',"max_withdrawal" => 'double',
            "method" => ["manual","gateway"],"weekend_payout"=> 'boolean',"holiday_payout"=> 'boolean'
        ],
        "wallet_settings"=> [
            "wallet_status" => 'boolean', 
            "usd_exchange_rate_percentage"=>'double'
        ],
        "referral_settings" => [
            "referral_earnings_percentage"=> 'double',
            "invitee_commission_percentage"=> 'double'
        ],
        "review_settings" => [
            "admin_review_cost"=> 'double',
            "system_review_cost"=> 'double'
        ],
        "security_settings" => [
            "ban_settings"=> [
                "auto_ban_on_flag_count" => 'number',
                "ban_duration"=> ['life','day','week','month','quarter','half-year','year'],
                ""
            ],
            "ip_blacklist"
        ]
    ]
];
