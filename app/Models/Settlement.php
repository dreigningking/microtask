<?php

namespace App\Models;

use App\Observers\SettlementObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([SettlementObserver::class])]
class Settlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'status',
        'settlementable_id',
        'settlementable_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function settlementable()
    {
        return $this->morphTo();
    }
}
