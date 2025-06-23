<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $fillable = [
        'user_id', 'base_currency', 'target_currency', 'exchange_rate', 'base_amount', 'target_amount', 'base_wallet_id', 'target_wallet_id', 'status', 'reference'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function base_wallet()
    {
        return $this->belongsTo(Wallet::class, 'base_wallet_id');
    }

    public function target_wallet()
    {
        return $this->belongsTo(Wallet::class, 'target_wallet_id');
    }
}
