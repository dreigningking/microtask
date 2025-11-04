<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlatformTemplate extends Model
{
    protected $fillable = [
        'platform_id',
        'name',
        'description',
        'task_fields',
        'submission_fields',
        'is_active',
    ];

    protected $casts = [
        'task_fields' => 'array',
        'submission_fields' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the platform this template belongs to
     */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    /**
     * Get tasks that use this template
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get country prices for this template
     */
    public function countryPrices()
    {
        return $this->morphMany(CountryPrice::class, 'priceable');
    }

    /**
     * Check if template is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Scope for active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for templates by platform
     */
    public function scopeByPlatform($query, $platformId)
    {
        return $query->where('platform_id', $platformId);
    }

    /**
     * Scope for templates with specific task fields
     */
    public function scopeWithTaskField($query, $field)
    {
        return $query->whereJsonContains('task_fields', $field);
    }

    /**
     * Scope for templates with specific submission fields
     */
    public function scopeWithSubmissionField($query, $field)
    {
        return $query->whereJsonContains('submission_fields', $field);
    }

    /**
     * Get price for specific country
     */
    public function getPriceForCountry($countryId): ?string
    {
        $price = $this->countryPrices()->where('country_id', $countryId)->first();
        return $price ? $price->amount : null;
    }

    /**
     * Check if template is available in country
     */
    public function isAvailableInCountry($countryId): bool
    {
        return $this->countryPrices()->where('country_id', $countryId)->exists();
    }
}
