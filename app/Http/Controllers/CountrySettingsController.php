<?php

namespace App\Http\Controllers;

use App\Http\Traits\HelperTrait;
use App\Models\Booster;
use App\Models\Country;
use App\Models\CountryPrice;
use App\Models\TaskTemplate;
use Illuminate\Http\Request;
use App\Models\CountrySetting;

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
        
        if (!$settings) {
            $settings = new CountrySetting();
            $settings->country_id = $country->id;
        }
        
        $templates = TaskTemplate::where('is_active', true)->orderBy('name', 'asc')->get();
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
        return view('backend.settings.country-config', compact('country', 'settings', 'templates','boosters', 'countryPricesByKey', 'exchangeRate'));
    }

    public function update(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        
        $settings = CountrySetting::where('country_id', $countryId)->first();
        
        if (!$settings) {
            $settings = new CountrySetting();
            $settings->country_id = $countryId;
        }
        
        // Handle Banking Fields
        if ($request->has('banking_fields')) {
            $bankingFields = $request->input('banking_fields');
            if (is_string($bankingFields)) {
                $settings->banking_fields = json_decode($bankingFields, true);
            } else {
                $settings->banking_fields = $bankingFields;
            }
        }
        
        // Handle Transaction Charges
        if ($request->has('transaction_charges')) {
            $transactionCharges = $request->input('transaction_charges');
            if (is_string($transactionCharges)) {
                $settings->transaction_charges = json_decode($transactionCharges, true);
            } else {
                $settings->transaction_charges = $transactionCharges;
            }
        }
        
        // Handle Withdrawal Charges
        if ($request->has('withdrawal_charges')) {
            $withdrawalCharges = $request->input('withdrawal_charges');
            if (is_string($withdrawalCharges)) {
                $settings->withdrawal_charges = json_decode($withdrawalCharges, true);
            } else {
                $settings->withdrawal_charges = $withdrawalCharges;
            }
        }
        
        // Handle Feature Rates
        if ($request->has('feature_rates')) {
            $featureRates = $request->input('feature_rates');
            if (is_string($featureRates)) {
                $settings->feature_rates = json_decode($featureRates, true);
            } else {
                $settings->feature_rates = $featureRates;
            }
        }
        
        // Handle Broadcast Rates
        if ($request->has('broadcast_rates')) {
            $broadcastRates = $request->input('broadcast_rates');
            if (is_string($broadcastRates)) {
                $settings->broadcast_rates = json_decode($broadcastRates, true);
            } else {
                $settings->broadcast_rates = $broadcastRates;
            }
        }
        
        // Handle Notification Emails
        if ($request->has('notification_emails')) {
            $notificationEmails = $request->input('notification_emails');
            // Validate each email if present
            foreach ($notificationEmails as $key => $email) {
                if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return back()->withInput()->withErrors(["notification_emails.$key" => "Invalid email address for $key notification."]);
                }
            }
            $settings->notification_emails = $notificationEmails;
        }
        
        // Update other fields
        $settings->platform_fee = $request->input('platform_fee', 0);
        $settings->tax_rate = $request->input('tax_rate', 0);
        $settings->usd_exchange_rate = $request->input('usd_exchange_rate', 1);
        $settings->verification_required = $request->has('verification_required');
        $settings->verification_method = $request->input('verification_method', 'manual');
        $settings->account_length = $request->input('account_length', 0);
        $settings->payout_method = $request->input('payout_method', 'manual');
        $settings->weekend_payout = $request->has('weekend_payout');
        $settings->holiday_payout = $request->has('holiday_payout');
        $settings->gateway = $request->input('gateway');
        $settings->feature_rate = $request->input('feature_rate', 0);
        $settings->broadcast_rate = $request->input('broadcast_rate', 0);
        $settings->save();

        // Handle Country Prices for Templates
        if ($request->has('template_prices')) {
            foreach ($request->input('template_prices') as $templateId => $amount) {
                \App\Models\CountryPrice::updateOrCreate(
                    [
                        'country_id' => $countryId,
                        'priceable_type' => TaskTemplate::class,
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

        return redirect()->route('admin.settings.countries')
            ->with('success', "Settings for {$country->name} have been updated successfully.");
    }

    public function saveBanking(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        $settings = CountrySetting::firstOrNew(['country_id' => $countryId]);

        // Banking fields
        if ($request->has('banking_fields')) {
            $bankingFields = $request->input('banking_fields');
            if (is_string($bankingFields)) {
                $settings->banking_fields = json_decode($bankingFields, true);
            } else {
                $settings->banking_fields = $bankingFields;
            }
        }
        $settings->bank_account_storage = $request->input('bank_account_storage', 'on_premises');
        $settings->account_length = $request->input('account_length', 0);
        $settings->tax_rate = $request->input('tax_rate', 0);
        $settings->bank_verification_required = $request->has('bank_verification_required');
        $settings->bank_verification_method = $request->input('bank_verification_method', 'manual');
        $settings->usd_exchange_rate_percentage = $request->input('usd_exchange_rate_percentage', 0);
        $settings->save();
        return redirect()->route('admin.settings.country', $country)->withInput()->with('success', 'Banking settings updated.');
    }

    public function saveTransactions(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        $settings = CountrySetting::firstOrNew(['country_id' => $countryId]);

        // Transaction Charges
        $settings->transaction_charges = [
            'percentage' => $request->input('transaction_percentage', 2),
            'fixed' => $request->input('transaction_fixed', 100),
            'cap' => $request->input('transaction_cap', 2000),
        ];
        // Withdrawal Charges
        $settings->withdrawal_charges = [
            'percentage' => $request->input('withdrawal_percentage', 1),
            'fixed' => $request->input('withdrawal_fixed', 50),
            'cap' => $request->input('withdrawal_cap', 1000),
        ];
        $settings->min_withdrawal = $request->input('min_withdrawal', 0);
        $settings->max_withdrawal = $request->input('max_withdrawal', 0);
        $settings->gateway = $request->input('gateway');
        $settings->wallet_status = $request->input('wallet_status');
        $settings->payout_method = $request->input('payout_method', 'manual');
        $settings->weekend_payout = $request->has('weekend_payout');
        $settings->holiday_payout = $request->has('holiday_payout');
        $settings->save();
        return redirect()->route('admin.settings.country', $country)->withInput()->with('success', 'Transaction settings updated.');
    }

    public function saveTasks(Request $request)
    {
        $countryId = $request->input('country_id');
        $country = Country::findOrFail($countryId);
        $settings = CountrySetting::firstOrNew(['country_id' => $countryId]);

        $settings->feature_rate = $request->input('feature_rate', 0);
        $settings->broadcast_rate = $request->input('broadcast_rate', 0);
        $settings->admin_review_cost = $request->input('admin_review_cost', 0);
        $settings->system_review_cost = $request->input('system_review_cost', 0);
        $settings->invitee_commission_percentage = $request->input('invitee_commission_percentage', 0);
        $settings->referral_earnings_percentage = $request->input('referral_earnings_percentage', 0);
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
                        'priceable_type' => \App\Models\TaskTemplate::class,
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

        $settings->verification_provider = $request->input('verification_provider', 'manual');
        $settings->verifications_can_expire = $request->has('verifications_can_expire');
        $fields = $request->input('verification_fields', []);
        // Ensure structure for gov_id and address
        $verificationFields = [
            'gov_id' => [
                'mode' => $fields['gov_id']['mode'] ?? 'one',
                'docs' => $fields['gov_id']['docs'] ?? [],
            ],
            'address' => [
                'mode' => $fields['address']['mode'] ?? 'one',
                'docs' => $fields['address']['docs'] ?? [],
            ],
        ];
        $settings->verification_fields = $verificationFields;
        $settings->save();
        return redirect()->route('admin.settings.country', $country)->with('success', 'Verification settings updated.');
    }
} 