<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Order extends Model
{
    use Sluggable;

    protected $fillable = [
        'user_id',
        'slug',
        'processed_at',
        'completed_at',
        'refunded_at',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getNameAttribute()
    {
        return uniqid();
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
