<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = ['id'];

    public function orderable(){
        return $this->morphTo();
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
