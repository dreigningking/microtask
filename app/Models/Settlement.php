<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
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
