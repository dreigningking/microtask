<?php

namespace App\Models;

use App\Models\Moderation;
use App\Models\CountrySetting;
use Illuminate\Support\Facades\Auth;
use App\Observers\WithdrawalObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([WithdrawalObserver::class])]
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

    public function moderations(): MorphMany
    {
        return $this->morphMany(Moderation::class, 'moderatable');
    }

    public function latestModeration(): MorphOne
    {
        return $this->morphOne(Moderation::class, 'moderatable')->latestOfMany();
    }

    public function getGatewayAttribute()
    {
        $country_settings = CountrySetting::where('country_id', $this->user->country_id)->first();
        return $country_settings->gateway->name;
    }

    public function getPaymentMethodAttribute()
    {
        $country_settings = CountrySetting::where('country_id', $this->user->country_id)->first();
        return $country_settings->payout_method;
    }

    public function scopeLocalize($query)
    {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->slug == 'super-admin') {
            return $query;
        }

        return $query->where(function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('country_id', Auth::user()->country_id);
            });
        });
    }
}
