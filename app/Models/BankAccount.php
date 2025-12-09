<?php

namespace App\Models;

use App\Models\User;
use App\Models\Gateway;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $connection = 'mysql';
    
    protected $fillable = [
        'user_id',
        'gateway_id',
        'details',
        'verified_at'
    ];

    protected $casts = ['details'=> 'array'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function gateway(){
        return $this->belongsTo(Gateway::class);
    }

    public function moderations(){
        return $this->morphMany(\App\Models\Moderation::class, 'moderatable');
    }
}
