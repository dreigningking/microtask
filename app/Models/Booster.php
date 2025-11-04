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
