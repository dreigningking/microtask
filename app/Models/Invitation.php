<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    public $fillable = ['user_id','email','status', 'expire_at'];
    public $casts = ['expire_at'=> 'datetime'];
}
