<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'platform_id',
    ];

    /**
     * Get the user who owns this cart item
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the platform in this cart
     */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    /**
     * Check if cart item is active
     */
    public function isActive(): bool
    {
        return true; // Cart items are always active
    }
}
