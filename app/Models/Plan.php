<?php

namespace App\Models;

use App\Models\CountryPrice;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Plan extends Model
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

    public function getCountryPrice($country_id)
    {
        $price = CountryPrice::where('country_id', $country_id)
            ->where('priceable_type', self::class)
            ->where('priceable_id', $this->id)
            ->first();
        return $price ? (float) $price->amount : null;
    }
}
