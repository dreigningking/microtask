<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CountryPrice extends Model
{
    protected $fillable = ['country_id','amount','priceable_type','priceable_id'];

    public function priceable(): MorphTo
    {
        return $this->morphTo();
    }
}
