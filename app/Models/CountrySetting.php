<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountrySetting extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'account_length',
        'banking_fields',
        'bank_verification_required',
        'bank_account_storage',
        'verification_fields',
        'verification_provider',
        'platform_fee',
        'tax_rate',
        'feature_rate',
        'urgent_rate',
        'usd_exchange_rate',
        'transaction_charges',
        'withdrawal_charges',
        'min_withdrawal',
        'max_withdrawal',
        'payout_method',
        'weekend_payout',
        'holiday_payout',
        'gateway',
        'notification_emails',
        'verifications_can_expire',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'banking_fields' => 'array',
        'transaction_charges' => 'array',
        'withdrawal_charges' => 'array',
        'bank_verification_required' => 'boolean',
        'weekend_payout' => 'boolean',
        'holiday_payout' => 'boolean',
        'notification_emails' => 'array',
        'verification_fields' => 'array',
        'verifications_can_expire' => 'boolean',
    ];

    /**
     * Get the country that owns the settings.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
