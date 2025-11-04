<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $connection = 'mysql';
    protected $fillable = [
        'order_id',
        'orderable_id',
        'orderable_type',
        'amount',
    ];

    /**
     * Get the polymorphic related model (task, promotion, subscription)
     */
    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the order this item belongs to
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if this item is for a task
     */
    public function isTask(): bool
    {
        return $this->orderable_type === Task::class;
    }

    /**
     * Check if this item is for a promotion
     */
    public function isPromotion(): bool
    {
        return $this->orderable_type === TaskPromotion::class;
    }

    /**
     * Check if this item is for a subscription
     */
    public function isSubscription(): bool
    {
        return $this->orderable_type === Subscription::class;
    }
}
