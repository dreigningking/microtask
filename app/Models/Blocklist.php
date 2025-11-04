<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blocklist extends Model
{
    protected $fillable = [
        'user_id',
        'enemy_id',
    ];

    /**
     * Get the user who created the block
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the blocked user
     */
    public function enemy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'enemy_id');
    }

    /**
     * Check if user is blocked
     */
    public function isActive(): bool
    {
        return true; // Blocklist entries are always active
    }
}
