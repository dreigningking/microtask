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
            "signup_referral_earnings_percentage"=> 'double',
            "task_referral_commission_percentage"=> 'double'
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
    ],
    "announcement_segments" => [
        "all_users" => [
            "name" => "All Users",
            "description" => "All registered users on the platform",
            "filters" => [
                "type" => "all",
                "conditions" => []
            ]
        ],
        "all_active_users" => [
            "name" => "All Active Users",
            "description" => "All active users (not banned)",
            "filters" => [
                "type" => "active_users",
                "conditions" => [
                    "is_active" => true,
                    "is_banned_from_tasks" => false
                ]
            ]
        ],
        "all_task_workers" => [
            "name" => "All Task Workers",
            "description" => "Users who have applied for or worked on tasks",
            "filters" => [
                "type" => "relationship",
                "conditions" => [
                    "has_task_workers" => true
                ]
            ]
        ],
        "all_task_creators" => [
            "name" => "All Task Creators",
            "description" => "Users who have created tasks",
            "filters" => [
                "type" => "relationship",
                "conditions" => [
                    "has_tasks" => true
                ]
            ]
        ],
        "all_admin_users" => [
            "name" => "All Admin Users",
            "description" => "Users with admin roles",
            "filters" => [
                "type" => "role",
                "conditions" => [
                    "roles" => ["admin", "super-admin"]
                ]
            ]
        ],
        "verified_users" => [
            "name" => "Verified Users",
            "description" => "Users who have completed verification",
            "filters" => [
                "type" => "verification",
                "conditions" => [
                    "is_verified" => true
                ]
            ]
        ],
        "unverified_users" => [
            "name" => "Unverified Users",
            "description" => "Users who haven't completed verification",
            "filters" => [
                "type" => "verification",
                "conditions" => [
                    "is_verified" => false
                ]
            ]
        ],
        "recent_task_posters" => [
            "name" => "Recent Task Posters",
            "description" => "Users who posted tasks within a specified period",
            "filters" => [
                "type" => "activity",
                "conditions" => [
                    "has_tasks_within_days" => 30
                ]
            ]
        ],
        "recent_task_workers" => [
            "name" => "Recent Task Workers",
            "description" => "Users who worked on tasks within a specified period",
            "filters" => [
                "type" => "activity",
                "conditions" => [
                    "has_task_workers_within_days" => 30
                ]
            ]
        ],
        "premium_subscription_users" => [
            "name" => "Premium Subscription Users",
            "description" => "Users with active premium subscriptions",
            "filters" => [
                "type" => "subscription",
                "conditions" => [
                    "has_active_subscription" => true,
                    "subscription_type" => "premium"
                ]
            ]
        ],
        "worker_subscription_users" => [
            "name" => "Worker Subscription Users",
            "description" => "Users with active worker subscriptions",
            "filters" => [
                "type" => "subscription",
                "conditions" => [
                    "has_active_subscription" => true,
                    "subscription_type" => "worker"
                ]
            ]
        ],
        "creator_subscription_users" => [
            "name" => "Creator Subscription Users",
            "description" => "Users with active creator subscriptions",
            "filters" => [
                "type" => "subscription",
                "conditions" => [
                    "has_active_subscription" => true,
                    "subscription_type" => "creator"
                ]
            ]
        ],
        "no_subscription_users" => [
            "name" => "No Subscription Users",
            "description" => "Users without any active subscriptions",
            "filters" => [
                "type" => "subscription",
                "conditions" => [
                    "has_active_subscription" => false
                ]
            ]
        ],
        "banned_users" => [
            "name" => "Banned Users",
            "description" => "Users banned from taking tasks",
            "filters" => [
                "type" => "status",
                "conditions" => [
                    "is_banned_from_tasks" => true
                ]
            ]
        ],
        "inactive_users" => [
            "name" => "Inactive Users",
            "description" => "Users marked as inactive",
            "filters" => [
                "type" => "status",
                "conditions" => [
                    "is_active" => false
                ]
            ]
        ],
        "high_earning_users" => [
            "name" => "High Earning Users",
            "description" => "Users with earnings above threshold",
            "filters" => [
                "type" => "earnings",
                "conditions" => [
                    "min_earnings" => 100,
                    "currency" => "USD"
                ]
            ]
        ],
        "country_specific" => [
            "name" => "Country Specific",
            "description" => "Users from specific countries",
            "filters" => [
                "type" => "geographic",
                "conditions" => [
                    "country_id" => null // Will be specified at runtime
                ]
            ]
        ],
        "recently_registered" => [
            "name" => "Recently Registered",
            "description" => "Users registered within a specified period",
            "filters" => [
                "type" => "registration",
                "conditions" => [
                    "registered_within_days" => 7
                ]
            ]
        ],
        "task_completion_rate_high" => [
            "name" => "High Task Completion Rate",
            "description" => "Users with high task completion rates",
            "filters" => [
                "type" => "performance",
                "conditions" => [
                    "min_completion_rate" => 80,
                    "min_total_tasks" => 5
                ]
            ]
        ]
    ]
];
