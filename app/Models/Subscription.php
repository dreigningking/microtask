<?php

namespace App\Models;

use App\Models\User;
use App\Models\Booster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $connection = 'mysql';
    protected $fillable = ['user_id','booster_id', 'cost', 'currency', 'duration_days',
     'starts_at', 'expires_at','multiplier'];
    protected $casts = ['starts_at'=>'datetime', 'expires_at'=>'datetime'];

    public function booster(){
        return $this->belongsTo(Booster::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getExpiresInDaysAttribute(){
        return ceil(now()->diffInDays($this->expires_at, false));
    }

    public function scopeLocalize($query)
    {
        $user = Auth::user();
        if ($user->role->name == 'super-admin') {
            return $query;
        }

        return $query->where(function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('country_id', Auth::user()->country_id);
            });
        });
    }

}
