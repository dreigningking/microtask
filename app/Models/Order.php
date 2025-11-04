<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the user who created this order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if order is processed
     */
    public function isProcessed(): bool
    {
        return !is_null($this->processed_at);
    }

    /**
     * Check if order is completed
     */
    public function isCompleted(): bool
    {
        return !is_null($this->completed_at);
    }

    /**
     * Check if order is refunded
     */
    public function isRefunded(): bool
    {
        return !is_null($this->refunded_at);
    }

    /**
     * Scope for processed orders
     */
    public function scopeProcessed($query)
    {
        return $query->whereNotNull('processed_at');
    }

    /**
     * Scope for completed orders
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    /**
     * Scope for refunded orders
     */
    public function scopeRefunded($query)
    {
        return $query->whereNotNull('refunded_at');
    }

    /**
     * Scope for orders by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for orders with specific slug
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
