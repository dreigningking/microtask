<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CountryPrice extends Model
{
    protected $fillable = [
        'country_id',
        'amount',
        'priceable_type',
        'priceable_id',
    ];

    /**
     * Get the polymorphic related model
     */
    public function priceable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the country this price belongs to
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Check if this price is for a booster
     */
    public function isBoosterPrice(): bool
    {
        return $this->priceable_type === Booster::class;
    }

    /**
     * Check if this price is for a platform template
     */
    public function isPlatformTemplatePrice(): bool
    {
        return $this->priceable_type === PlatformTemplate::class;
    }
}
