<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'user_id',
        'currency',
        'balance',
        'is_frozen'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getBalanceAttribute()
    {
        return $this->decryptBalance();
    }

    public function setBalanceAttribute($value)
    {
        $this->attributes['balance'] = $this->encryptBalance($value);
    }

    public function getBalance()
    {
        return $this->decryptBalance();
    }

    public function hasFunds()
    {
        return $this->decryptBalance() > 0;
    }

    protected function encryptBalance($value)
    {
        return encrypt($value);
    }

    protected function decryptBalance()
    {
        if (empty($this->attributes['balance'])) {
            return 0;
        }

        try {
            return decrypt($this->attributes['balance']);
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function scopeLocalize($query)
    {
        if (Auth::user()->role->slug == 'super-admin') {
            return $query;
        }

        return $query->where(function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('country_id', Auth::user()->country_id);
            });
        });
    }
}
