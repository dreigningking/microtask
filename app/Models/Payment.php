<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'reference',
        'request_id',
        'currency',
        'amount',
        'vat_value',
        'gateway',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'vat_value' => 'decimal:2',
    ];

    /**
     * Get the user who made this payment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order this payment belongs to
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if payment failed
     */
    public function hasFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Check if payment is cancelled
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for completed payments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for failed payments
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for payments by gateway
     */
    public function scopeByGateway($query, $gateway)
    {
        return $query->where('gateway', $gateway);
    }

    /**
     * Scope for payments by currency
     */
    public function scopeByCurrency($query, $currency)
    {
        return $query->where('currency', $currency);
    }
}
