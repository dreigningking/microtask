<?php

namespace App\Models;

use App\Models\City;
use App\Models\State;

use App\Models\Booster;
use App\Models\CountryPrice;
use App\Models\TaskTemplate;
use App\Models\CountryBanking;
use App\Models\PlatformTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'phone_code',
        'currency',
        'currency_symbol',
        'is_active',
    ];

    protected $connection = 'sqlite_countries';
    protected $table = 'countries'; // adjust table name if different
    public $appends = ['status', 'detailed_status'];

    /**
     * Get country prices for this country.
     */
    public function countryPrices()
    {
        return $this->hasMany(CountryPrice::class);
    }

    // --- Helper methods for getting specific settings values ---
    
    /**
     * Get the payment gateway for this country
     */
    public function getGatewayAttribute()
    {
        return $this->setting && $this->setting->gateway_id ? $this->setting->gateway->slug : null;
    }

    /**
     * Get banking settings as array
     */
    public function getBankingSettingsArray()
    {
        if (!$this->setting || !$this->setting->banking_settings) {
            return [];
        }
        
        return is_string($this->setting->banking_settings)
            ? json_decode($this->setting->banking_settings, true)
            : $this->setting->banking_settings;
    }

    /**
     * Get transaction settings as array
     */
    public function getTransactionSettingsArray()
    {
        if (!$this->setting || !$this->setting->transaction_settings) {
            return [];
        }
        
        return is_string($this->setting->transaction_settings)
            ? json_decode($this->setting->transaction_settings, true)
            : $this->setting->transaction_settings;
    }

    /**
     * Get withdrawal settings as array
     */
    public function getWithdrawalSettingsArray()
    {
        if (!$this->setting || !$this->setting->withdrawal_settings) {
            return [];
        }
        
        return is_string($this->setting->withdrawal_settings)
            ? json_decode($this->setting->withdrawal_settings, true)
            : $this->setting->withdrawal_settings;
    }

    /**
     * Get wallet settings as array
     */
    public function getWalletSettingsArray()
    {
        if (!$this->setting || !$this->setting->wallet_settings) {
            return [];
        }
        
        return is_string($this->setting->wallet_settings)
            ? json_decode($this->setting->wallet_settings, true)
            : $this->setting->wallet_settings;
    }

    /**
     * Get promotion settings as array
     */
    public function getPromotionSettingsArray()
    {
        if (!$this->setting || !$this->setting->promotion_settings) {
            return [];
        }
        
        return is_string($this->setting->promotion_settings)
            ? json_decode($this->setting->promotion_settings, true)
            : $this->setting->promotion_settings;
    }

    /**
     * Get verification settings as array
     */
    public function getVerificationSettingsArray()
    {
        if (!$this->setting || !$this->setting->verification_fields) {
            return [];
        }
        
        return is_string($this->setting->verification_fields)
            ? json_decode($this->setting->verification_fields, true)
            : $this->setting->verification_fields;
    }

    /**
     * Get referral settings as array
     */
    public function getReferralSettingsArray()
    {
        if (!$this->setting || !$this->setting->referral_settings) {
            return [];
        }
        
        return is_string($this->setting->referral_settings)
            ? json_decode($this->setting->referral_settings, true)
            : $this->setting->referral_settings;
    }

    /**
     * Get review settings as array
     */
    public function getReviewSettingsArray()
    {
        if (!$this->setting || !$this->setting->review_settings) {
            return [];
        }
        
        return is_string($this->setting->review_settings)
            ? json_decode($this->setting->review_settings, true)
            : $this->setting->review_settings;
    }

    /**
     * Check if the country is ready for production use
     */
    public function isReadyForProduction()
    {
        return $this->status && $this->hasBoosterPrices() && $this->hasTemplatePrices();
    }

    /**
     * Check if the country supports payments
     */
    public function supportsPayments()
    {
        return $this->status && $this->hasTransactionSettings() && $this->hasWithdrawalSettings();
    }

    /**
     * Check if the country supports wallets
     */
    public function supportsWallets()
    {
        $walletSettings = $this->getWalletSettingsArray();
        return isset($walletSettings['wallet_status']) && $walletSettings['wallet_status'] === true;
    }

    /**
     * Get price for a specific booster in this country
     */
    public function getBoosterPrice($boosterId)
    {
        $price = $this->countryPrices()
            ->where('priceable_type', Booster::class)
            ->where('priceable_id', $boosterId)
            ->first();
        
        return $price ? $price->amount : null;
    }

    /**
     * Get price for a specific platform template in this country
     */
    public function getTemplatePrice($templateId)
    {
        $price = $this->countryPrices()
            ->where('priceable_type', PlatformTemplate::class)
            ->where('priceable_id', $templateId)
            ->first();
        
        return $price ? $price->amount : null;
    }

    /**
     * Scope for countries that are ready (status = true)
     */
    public function scopeReady($query)
    {
        return $query->whereHas('setting', function ($q) {
            // This will be evaluated in the status attribute
        })->get()->filter(function ($country) {
            return $country->status;
        })->values();
    }

    /**
     * Scope for countries that support a specific feature
     */
    public function scopeSupportsFeature($query, $feature)
    {
        switch ($feature) {
            case 'payments':
                return $query->whereHas('setting', function ($q) {
                    $q->whereNotNull('gateway_id')
                      ->whereNotNull('transaction_settings')
                      ->whereNotNull('withdrawal_settings');
                });
            case 'wallets':
                return $query->whereHas('setting', function ($q) {
                    $q->where('wallet_settings', 'like', '%"wallet_status":true%');
                });
            case 'boosters':
                return $query->has('countryPrices');
            default:
                return $query;
        }
    }

    public function getRouteKeyName(){
        return 'iso2';
    }
    public function states(){
        return $this->hasMany(State::class);
    }
    public function cities(){
        return $this->hasManyThrough(City::class,State::class,'country_id','state_id');
    }

    public function preferred_locations()
    {
        return $this->hasMany(PreferredLocation::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    } 

    /**
     * Get the settings for this country.
     */
    public function setting()
    {
        return $this->hasOne(CountrySetting::class);
    }

    // --- Custom computed properties for settings completeness ---
    
    /**
     * Check if banking settings are properly configured
     */
    public function hasBankingSettings()
    {
        $settings = $this->setting;
        if (!$settings) return false;

        if (!$settings->banking_settings) return false;
        if (!$settings->banking_fields) return false;

        $bankingSettings = is_string($settings->banking_settings)
            ? json_decode($settings->banking_settings, true)
            : $settings->banking_settings;

        if (!$bankingSettings || !is_array($bankingSettings)) return false;

        // Check for required banking settings fields
        return isset($bankingSettings['account_length'])
            && isset($bankingSettings['bank_account_storage'])
            && is_array($settings->banking_fields);
    }

    /**
     * Check if verification settings are properly configured
     */
    public function hasVerificationSettings()
    {
        $settings = $this->setting;
        if (!$settings) return false;
        if (!$settings->verification_fields) return false;

        $verificationFields = is_string($settings->verification_fields)
            ? json_decode($settings->verification_fields, true)
            : $settings->verification_fields;

        if (!$verificationFields || !is_array($verificationFields)) return false;

        // Must have at least one verification type (govt_id or address)
        return count($verificationFields) > 0;
    }

    /**
     * Check if promotion settings are properly configured
     */
    public function hasPromotionSettings()
    {
        $settings = $this->setting;
        if (!$settings) return false;
        if (!$settings->promotion_settings) return false;

        $promotionSettings = is_string($settings->promotion_settings)
            ? json_decode($settings->promotion_settings, true)
            : $settings->promotion_settings;

        if (!$promotionSettings || !is_array($promotionSettings)) return false;

        // Must have feature_rate and broadcast_rate
        return isset($promotionSettings['feature_rate'])
            && isset($promotionSettings['broadcast_rate']);
    }

    /**
     * Check if transaction settings are properly configured
     */
    public function hasTransactionSettings()
    {
        $settings = $this->setting;
        if (!$settings) return false;
        if (!$settings->transaction_settings) return false;
        if (!$settings->gateway_id) return false;

        $transactionSettings = is_string($settings->transaction_settings)
            ? json_decode($settings->transaction_settings, true)
            : $settings->transaction_settings;

        if (!$transactionSettings || !is_array($transactionSettings)) return false;

        // Must have percentage, fixed, and cap
        return isset($transactionSettings['percentage'])
            && isset($transactionSettings['fixed'])
            && isset($transactionSettings['cap']);
    }

    /**
     * Check if withdrawal settings are properly configured
     */
    public function hasWithdrawalSettings()
    {
        $settings = $this->setting;
        if (!$settings) return false;
        if (!$settings->withdrawal_settings) return false;

        $withdrawalSettings = is_string($settings->withdrawal_settings)
            ? json_decode($settings->withdrawal_settings, true)
            : $settings->withdrawal_settings;

        if (!$withdrawalSettings || !is_array($withdrawalSettings)) return false;

        // Must have percentage, fixed, min_withdrawal, and max_withdrawal
        return isset($withdrawalSettings['percentage'])
            && isset($withdrawalSettings['fixed'])
            && isset($withdrawalSettings['min_withdrawal'])
            && isset($withdrawalSettings['max_withdrawal']);
    }

    /**
     * Check if wallet settings are properly configured
     */
    public function hasWalletSettings()
    {
        $settings = $this->setting;
        if (!$settings) return false;
        if (!$settings->wallet_settings) return false;

        $walletSettings = is_string($settings->wallet_settings)
            ? json_decode($settings->wallet_settings, true)
            : $settings->wallet_settings;

        if (!$walletSettings || !is_array($walletSettings)) return false;

        // Must have wallet_status
        return isset($walletSettings['wallet_status']);
    }

    /**
     * Check if referral settings are properly configured
     */
    public function hasReferralSettings()
    {
        $settings = $this->setting;
        if (!$settings) return false;
        if (!$settings->referral_settings) return false;

        $referralSettings = is_string($settings->referral_settings)
            ? json_decode($settings->referral_settings, true)
            : $settings->referral_settings;

        if (!$referralSettings || !is_array($referralSettings)) return false;

        // Must have signup_referral_earnings_percentage and task_referral_commission_percentage
        return isset($referralSettings['signup_referral_earnings_percentage'])
            && isset($referralSettings['task_referral_commission_percentage']);
    }

    /**
     * Check if review settings are properly configured
     */
    public function hasReviewSettings()
    {
        $settings = $this->setting;
        if (!$settings) return false;
        if (!$settings->review_settings) return false;

        $reviewSettings = is_string($settings->review_settings)
            ? json_decode($settings->review_settings, true)
            : $settings->review_settings;

        if (!$reviewSettings || !is_array($reviewSettings)) return false;

        // Must have admin_review_cost and system_review_cost
        return isset($reviewSettings['admin_review_cost'])
            && isset($reviewSettings['system_review_cost']);
    }

    /**
     * Check if security settings are properly configured
     */
    public function hasSecuritySettings()
    {
        $settings = $this->setting;
        if (!$settings) return false;
        if (!$settings->security_settings) return false;

        $securitySettings = is_string($settings->security_settings)
            ? json_decode($settings->security_settings, true)
            : $settings->security_settings;

        if (!$securitySettings || !is_array($securitySettings)) return false;

        // Must have ban_settings
        return isset($securitySettings['ban_settings'])
            && is_array($securitySettings['ban_settings']);
    }

    /**
     * Check if the country has booster prices configured
     */
    public function hasBoosterPrices()
    {
        // Check if there are any active boosters
        $boosters = Booster::where('is_active', true)->count();
        if ($boosters === 0) return true; // No boosters to check

        // Check if at least some boosters have prices for this country
        $pricedBoosters = CountryPrice::where('country_id', $this->id)
            ->where('priceable_type', Booster::class)
            ->whereNotNull('amount')
            ->where('amount', '!=', '')
            ->count();

        return $pricedBoosters > 0;
    }

    /**
     * Check if the country has platform template prices configured
     */
    public function hasTemplatePrices()
    {
        // Check if there are any active templates
        $templates = PlatformTemplate::where('is_active', true)->count();
        if ($templates === 0) return true; // No templates to check

        // Check if at least some templates have prices for this country
        $pricedTemplates = CountryPrice::where('country_id', $this->id)
            ->where('priceable_type', PlatformTemplate::class)
            ->whereNotNull('amount')
            ->where('amount', '!=', '')
            ->count();

        return $pricedTemplates > 0;
    }

    /**
     * Get the overall status of the country's configuration
     * Returns true if all required settings are properly configured
     */
    public function getStatusAttribute()
    {
        // Core required settings for a country to be considered "ready"
        $requiredSettings = [
            'hasBankingSettings',
            'hasVerificationSettings',
            'hasPromotionSettings',
            'hasTransactionSettings',
            // 'hasWithdrawalSettings',
            // 'hasReferralSettings',
            // 'hasReviewSettings'
        ];

        // Optional settings (country can function without these)
        $optionalSettings = [
            'hasWalletSettings',
            'hasSecuritySettings',
            'hasBoosterPrices',
            'hasTemplatePrices'
        ];

        // Check all required settings
        foreach ($requiredSettings as $method) {
            if (!$this->$method()) {
                return false;
            }
        }

        // Log missing optional settings but don't fail
        $missingOptional = [];
        foreach ($optionalSettings as $method) {
            if (!$this->$method()) {
                $missingOptional[] = $method;
            }
        }

        // Return true if all required settings are present
        return true;
    }

    /**
     * Get detailed status information
     */
    public function getDetailedStatusAttribute()
    {
        $settings = $this->setting;
        
        if (!$settings) {
            return [
                'overall_status' => false,
                'message' => 'No country settings configured',
                'missing_settings' => ['all']
            ];
        }

        $checks = [
            'banking_settings' => $this->hasBankingSettings(),
            'verification_settings' => $this->hasVerificationSettings(),
            'promotion_settings' => $this->hasPromotionSettings(),
            'transaction_settings' => $this->hasTransactionSettings(),
            'withdrawal_settings' => $this->hasWithdrawalSettings(),
            'wallet_settings' => $this->hasWalletSettings(),
            'referral_settings' => $this->hasReferralSettings(),
            'review_settings' => $this->hasReviewSettings(),
            'security_settings' => $this->hasSecuritySettings(),
            'booster_prices' => $this->hasBoosterPrices(),
            'template_prices' => $this->hasTemplatePrices(),
        ];

        $missingSettings = array_keys(array_filter($checks, function($value) {
            return !$value;
        }));

        $overallStatus = $this->status;

        return [
            'overall_status' => $overallStatus,
            'individual_checks' => $checks,
            'missing_settings' => $missingSettings,
            'required_missing' => array_intersect($missingSettings, [
                'banking_settings', 'verification_settings', 'promotion_settings',
                'transaction_settings', 'withdrawal_settings', 'referral_settings', 'review_settings'
            ]),
            'optional_missing' => array_intersect($missingSettings, [
                'wallet_settings', 'security_settings', 'booster_prices', 'template_prices'
            ])
        ];
    }
}
