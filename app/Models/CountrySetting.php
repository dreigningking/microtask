<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountrySetting extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    protected $fillable = [
        'country_id',
        'gateway',
        'banking_settings',
        'banking_fields',
        'verification_fields',
        'verification_settings',
        'promotion_settings',
        'transaction_settings',
        'withdrawal_settings',
        'wallet_settings',
        'referral_settings',
        'review_settings',
        'security_settings',
    ];

    protected $casts = [
        'banking_settings' => 'array',
        'banking_fields' => 'array',
        'verification_fields' => 'array',
        'verification_settings' => 'array',
        'promotion_settings' => 'array',
        'transaction_settings' => 'array',
        'withdrawal_settings' => 'array',
        'wallet_settings' => 'array',
        'referral_settings' => 'array',
        'review_settings' => 'array',
        'security_settings' => 'array',
    ];

    /**
     * Get the country that owns the settings.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
