<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id','plan_id', 'cost', 'currency', 'status', 'duration_months',
     'starts_at', 'expires_at', 'features'];
    protected $casts = ['features'=> 'array','starts_at'=>'datetime', 'expires_at'=>'datetime'];

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
