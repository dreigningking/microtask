<?php

namespace App\Models;

use App\Models\Booster;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $connection = 'mysql';
    protected $fillable = ['user_id','booster_id', 'cost', 'currency', 'status', 'duration_months',
     'starts_at', 'expires_at', 'features'];
    protected $casts = ['features'=> 'array','starts_at'=>'datetime', 'expires_at'=>'datetime'];

    public function booster(){
        return $this->belongsTo(Booster::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeLocalize($query)
    {
        if (auth()->user()->role->name == 'super-admin') {
            return $query;
        }

        return $query->where(function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('country_id', auth()->user()->country_id);
            });
        });
    }

}
