<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\CountrySetting;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id', 'currency', 'amount', 'payment_method', 'paid_at', 'rejected_at', 'approved_by', 'approved_at', 'reference', 'status', 'note', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'paid_at' => 'datetime',
        'rejected_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getGatewayAttribute()
    {
        $country_settings = CountrySetting::where('country_id', $this->user->country_id)->first();
        return $country_settings->gateway;
    }

    public function getPaymentMethodAttribute()
    {
        $country_settings = CountrySetting::where('country_id', $this->user->country_id)->first();
        return $country_settings->payout_method;
    }

    public function scopeLocalize($query)
    {
        if (Auth::check() && Auth::user()->first_role && Auth::user()->first_role->name == 'super-admin') {
            return $query;
        }

        return $query->where(function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('country_id', Auth::user()->country_id);
            });
        });
    }
}
