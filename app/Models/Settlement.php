<?php

namespace App\Models;

use App\Observers\SettlementObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Auth;

#[ObservedBy([SettlementObserver::class])]
class Settlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
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
