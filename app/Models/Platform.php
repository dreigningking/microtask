<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all platform templates for this platform
     */
    public function templates(): HasMany
    {
        return $this->hasMany(PlatformTemplate::class);
    }

    /**
     * Get tasks that use this platform
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get users who prefer this platform
     */
    public function preferredByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'preferred_platforms');
    }

    /**
     * Get users who have this platform in their cart
     */
    public function inCarts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Check if platform is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Scope for active platforms
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for platforms by slug
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Scope for platforms with templates
     */
    public function scopeWithTemplates($query)
    {
        return $query->has('templates');
    }
}
