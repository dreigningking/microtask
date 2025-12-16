<?php

namespace App\Models;

use App\Models\CountryPrice;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Booster extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'description',
        'minimum_duration_days',
        'max_multiplier',
        'is_active',
    ];

     /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
     
    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    public function prices(): MorphMany
    {
        return $this->morphMany(CountryPrice::class, 'priceable');
    }

    
}
