<?php

namespace App\Http\Controllers;

use App\Models\Booster;
use App\Models\Country;
use App\Models\Gateway;
use App\Models\CountryPrice;
use Illuminate\Http\Request;
use App\Models\CountrySetting;
use App\Http\Traits\HelperTrait;
use App\Models\PlatformTemplate;

class CountrySettingsController extends Controller
{
    use HelperTrait;
    /**
     * Display a listing of country settings.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     */
    public function countries()
    {
        $countries = Country::all();
        //dd($countries->where('name','LIKE','Nigeria')->first()->setting->platform_fee);
        return view('backend.settings.countries',compact('countries'));
    }

    /**
     * Show the form for configuring a specific country.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function country(Country $country)
    {
        $settings = $country->setting;
        $gateways = Gateway::all();
        if (!$settings) {
            $settings = new CountrySetting();
            $settings->country_id = $country->id;
        }
        
        $templates = PlatformTemplate::where('is_active', true)->orderBy('name', 'asc')->get();
        $boosters = Booster::where('is_active',true)->get();
        // Fetch all country prices for this country
        $countryPrices = CountryPrice::where('country_id', $country->id)->get();
        // Key by priceable_type and priceable_id for easy lookup in the view
        $countryPricesByKey = [];
        foreach ($countryPrices as $price) {
            $countryPricesByKey[$price->priceable_type][$price->priceable_id] = $price;
        }
        // Get the current exchange rate for this country currency (default to 1 if not available)
        $exchangeRate = 1;
        try {
            $exchangeRate = $this->getExchangeRate($country->currency);
        } catch (\Exception $e) {
            $exchangeRate = 1;
        }
        return view('backend.settings.country-config', compact('country','gateways', 'settings', 'templates','boosters', 'countryPricesByKey', 'exchangeRate'));
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);

        $settings = CountrySetting::where('country_id', $countryId)->first();

        if (!$settings) {
            $settings = new CountrySetting();
            $settings->country_id = $countryId;
        }

        // Banking settings
        if($request->has('gateway_id')){
            $settings->gateway_id = $request->input('gateway_id');
        }

        if($request->has('banking_settings')){
            $settings->banking_settings = array_merge($settings->banking_settings ?? [], [
                'account_verification_required' => $request->boolean('banking_settings.account_verification_required'),
                'account_verification_method' => $request->input('banking_settings.account_verification_method', 'manual'),
            ]);
        }

        // Banking fields configuration
        if ($request->has('banking_fields')) {
            $bankingFieldsInput = $request->input('banking_fields');
            $configuredFields = [];

            foreach ($bankingFieldsInput as $key => $fieldData) {
                $configuredFields[] = [
                    'slug'=> $key,
                    'enable'=> isset($fieldData['enabled']) && $fieldData['enabled'], 
                    'required'=> isset($fieldData['required']) && $fieldData['required']
                ];
            }

            $settings->banking_fields = $configuredFields;
        }

        // Wallet settings
        if($request->has('wallet_settings')){
            $settings->wallet_settings = array_merge($settings->wallet_settings ?? [], [
                'wallet_status' => $request->boolean('wallet_settings.wallet_status'),
                'usd_exchange_rate' => $request->input('wallet_settings.usd_exchange_rate', 0),
            ]);
        }

        // Transaction settings
        if($request->has('transaction_settings')){
            $settings->transaction_settings = array_merge($settings->transaction_settings ?? [], [
                'charges' => [
                    'percentage' => $request->input('transaction_settings.charges.percentage', 2),
                    'fixed' => $request->input('transaction_settings.charges.fixed', 100),
                    'cap' => $request->input('transaction_settings.charges.cap', 2000),
                ],
                'tax' => [
                    'percentage' => $request->input('transaction_settings.tax.percentage', 0),
                    'apply' => $request->boolean('transaction_settings.tax.apply'),
                ],
            ]);
        }

        // Withdrawal settings
        if($request->has('withdrawal_settings')){
            $settings->withdrawal_settings = array_merge($settings->withdrawal_settings ?? [], [
                'charges' => [
                    'percentage' => $request->input('withdrawal_settings.charges.percentage', 1),
                    'fixed' => $request->input('withdrawal_settings.charges.fixed', 50),
                    'cap' => $request->input('withdrawal_settings.charges.cap', 1000),
                ],
                'min_withdrawal' => $request->input('withdrawal_settings.min_withdrawal', 10),
                'max_withdrawal' => $request->input('withdrawal_settings.max_withdrawal', 5000),
                'method' => $request->input('withdrawal_settings.method', 'manual'),
                'weekend_payout' => $request->boolean('withdrawal_settings.weekend_payout'),
                'holiday_payout' => $request->boolean('withdrawal_settings.holiday_payout'),
            ]);
        }

        // Promotion settings
        if($request->has('promotion_settings')){
            $settings->promotion_settings = array_merge($settings->promotion_settings ?? [], [
                'feature_rate' => $request->input('promotion_settings.feature_rate', 0),
                'broadcast_rate' => $request->input('promotion_settings.broadcast_rate', 0),
            ]);
        }

        // Review settings
        if($request->has('review_settings')){
            $settings->review_settings = array_merge($settings->review_settings ?? [], [
                'admin_review_cost' => $request->input('review_settings.admin_review_cost', 0),
                'system_review_cost' => $request->input('review_settings.system_review_cost', 0),
            ]);
        }

        // Referral settings
        if($request->has('referral_settings')){
            $settings->referral_settings = array_merge($settings->referral_settings ?? [], [
                'signup_referral_earnings_percentage' => $request->input('referral_settings.signup_referral_earnings_percentage', 0),
                'task_referral_commission_percentage' => $request->input('referral_settings.task_referral_commission_percentage', 0),
            ]);
        }

        // Verification settings
        if($request->has('verification_settings')){
            $settings->verification_settings = array_merge($settings->verification_settings ?? [], [
                'verification_provider' => $request->input('verification_settings.verification_provider', 'manual'),
            ]);
        }

        // Verification fields
        if($request->has('verification_fields')){
            $fields = $request->input('verification_fields', []);
            $verificationFields = [
                'govt_id' => [
                    'file' => $fields['govt_id']['docs'] ?? [],
                    'require' => $fields['govt_id']['mode'] ?? 'one',
                    'issue_date' => isset($fields['govt_id']['issue_date']) ? $fields['govt_id']['issue_date'] : true,
                    'expiry_date' => isset($fields['govt_id']['expiry_date']) ? $fields['govt_id']['expiry_date'] : false,
                ],
                'address' => [
                    'file' => $fields['address']['docs'] ?? [],
                    'require' => $fields['address']['mode'] ?? 'one',
                    'issue_date' => isset($fields['address']['issue_date']) ? $fields['address']['issue_date'] : true,
                    'expiry_date' => isset($fields['address']['expiry_date']) ? $fields['address']['expiry_date'] : false,
                ],
            ];
            $settings->verification_fields = $verificationFields;
        }

        $settings->save();

        // Handle Country Prices for Templates
        if ($request->has('template_prices')) {
            foreach ($request->input('template_prices') as $templateId => $amount) {
                \App\Models\CountryPrice::updateOrCreate(
                    [
                        'country_id' => $countryId,
                        'priceable_type' => PlatformTemplate::class,
                        'priceable_id' => $templateId,
                    ],
                    [
                        'amount' => $amount
                    ]
                );
            }
        }

        // Handle Country Prices for Boosters
        if ($request->has('booster_prices')) {
            foreach ($request->input('booster_prices') as $boosterId => $amount) {
                \App\Models\CountryPrice::updateOrCreate(
                    [
                        'country_id' => $countryId,
                        'priceable_type' => Booster::class,
                        'priceable_id' => $boosterId,
                    ],
                    [
                        'amount' => $amount
                    ]
                );
            }
        }

        return redirect()->back()
            ->with('success', "Settings for {$country->name} have been updated successfully.");
    }

    public function saveBanking(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        $settings = CountrySetting::firstOrNew(['country_id' => $countryId]);

        // Banking settings
        $settings->banking_settings = [
            'account_length' => $request->input('account_length', 10),
            'account_verification_required' => $request->has('account_verification_required'),
            'account_verification_method' => $request->input('account_verification_method', 'manual'),
            'bank_account_storage' => $request->input('bank_account_storage', 'on_premises'),
        ];

        // Banking fields
        if ($request->has('banking_fields')) {
            $bankingFields = $request->input('banking_fields');
            if (is_string($bankingFields)) {
                $settings->banking_fields = json_decode($bankingFields, true);
            } else {
                $settings->banking_fields = $bankingFields;
            }
        }

        // Wallet settings
        $settings->wallet_settings = array_merge($settings->wallet_settings ?? [], [
            'usd_exchange_rate' => $request->input('usd_exchange_rate_percentage', 0),
        ]);

        $settings->save();
        return redirect()->route('admin.settings.country', $country)->withInput()->with('success', 'Banking settings updated.');
    }

    public function saveTransactions(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        $settings = CountrySetting::firstOrNew(['country_id' => $countryId]);

        // Transaction settings
        $settings->transaction_settings = [
            'charges' => [
                'percentage' => $request->input('transaction_percentage', 2),
                'fixed' => $request->input('transaction_fixed', 100),
                'cap' => $request->input('transaction_cap', 2000),
            ],
            'tax' => [
                'percentage' => $request->input('tax_percentage', 0),
                'apply' => $request->has('tax_apply'),
            ],
        ];

        // Withdrawal settings
        $settings->withdrawal_settings = [
            'charges' => [
                'percentage' => $request->input('withdrawal_percentage', 1),
                'fixed' => $request->input('withdrawal_fixed', 50),
                'cap' => $request->input('withdrawal_cap', 1000),
            ],
            'min_withdrawal' => $request->input('min_withdrawal', 10),
            'max_withdrawal' => $request->input('max_withdrawal', 5000),
            'method' => $request->input('payout_method', 'manual'),
            'weekend_payout' => $request->has('weekend_payout'),
            'holiday_payout' => $request->has('holiday_payout'),
        ];

        $settings->gateway_id = $request->input('gateway_id');
        $settings->wallet_settings = array_merge($settings->wallet_settings ?? [], [
            'wallet_status' => $request->input('wallet_status') === 'enabled',
        ]);

        $settings->save();
        return redirect()->route('admin.settings.country', $country)->withInput()->with('success', 'Transaction settings updated.');
    }

    public function saveTasks(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        $settings = CountrySetting::firstOrNew(['country_id' => $countryId]);

        $settings->promotion_settings = array_merge($settings->promotion_settings ?? [], [
            'feature_rate' => $request->input('feature_rate', 0),
            'broadcast_rate' => $request->input('broadcast_rate', 0),
        ]);

        $settings->review_settings = array_merge($settings->review_settings ?? [], [
            'admin_review_cost' => $request->input('admin_review_cost', 0),
            'system_review_cost' => $request->input('system_review_cost', 0),
        ]);

        $settings->referral_settings = array_merge($settings->referral_settings ?? [], [
            'signup_referral_earnings_percentage' => $request->input('signup_referral_earnings_percentage', 0),
            'task_referral_commission_percentage' => $request->input('task_referral_commission_percentage', 0),
        ]);

        $settings->save();
        return redirect()->route('admin.settings.country', $country)->withInput()->with('success', 'Task settings updated.');
    }

    public function saveNotificationEmails(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        $settings = CountrySetting::firstOrNew(['country_id' => $countryId]);

        if ($request->has('notification_emails')) {
            $notificationEmails = $request->input('notification_emails');
            foreach ($notificationEmails as $key => $email) {
                if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return back()->withInput()->withErrors(["notification_emails.$key" => "Invalid email address for $key notification."]);
                }
            }
            $settings->notification_emails = $notificationEmails;
        }
        $settings->save();
        return redirect()->route('admin.settings.country', $country)->with('success', 'Notification emails updated.');
    }

    public function saveTemplatePrices(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        if ($request->has('template_prices')) {
            foreach ($request->input('template_prices') as $templateId => $amount) {
                \App\Models\CountryPrice::updateOrCreate(
                    [
                        'country_id' => $countryId,
                        'priceable_type' => \App\Models\PlatformTemplate::class,
                        'priceable_id' => $templateId,
                    ],
                    [
                        'amount' => $amount
                    ]
                );
            }
        }
        return redirect()->route('admin.settings.country', $country)->with('success', 'Template prices updated.');
    }

    public function saveBoosterPrices(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        if ($request->has('booster_prices')) {
            foreach ($request->input('booster_prices') as $boosterId => $amount) {
                \App\Models\CountryPrice::updateOrCreate(
                    [
                        'country_id' => $countryId,
                        'priceable_type' => \App\Models\Booster::class,
                        'priceable_id' => $boosterId,
                    ],
                    [
                        'amount' => $amount
                    ]
                );
            }
        }
        return redirect()->route('admin.settings.country', $country)->with('success', 'Booster prices updated.');
    }

    public function saveVerificationSettings(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        $settings = CountrySetting::firstOrNew(['country_id' => $countryId]);

        $settings->verification_settings = [
            'verification_provider' => $request->input('verification_provider', 'manual'),
        ];

        $fields = $request->input('verification_fields', []);
        // Match seeder structure
        $verificationFields = [
            'govt_id' => [
                'file' => $fields['govt_id']['docs'] ?? [],
                'require' => $fields['govt_id']['mode'] ?? 'one',
                'issue_date' => isset($fields['govt_id']['issue_date']) ? $fields['govt_id']['issue_date'] : true,
                'expiry_date' => isset($fields['govt_id']['expiry_date']) ? $fields['govt_id']['expiry_date'] : false,
            ],
            'address' => [
                'file' => $fields['address']['docs'] ?? [],
                'require' => $fields['address']['mode'] ?? 'one',
                'issue_date' => isset($fields['address']['issue_date']) ? $fields['address']['issue_date'] : true,
                'expiry_date' => isset($fields['address']['expiry_date']) ? $fields['address']['expiry_date'] : false,
            ],
        ];
        $settings->verification_fields = $verificationFields;
        $settings->save();
        return redirect()->route('admin.settings.country', $country)->with('success', 'Verification settings updated.');
    }
} 