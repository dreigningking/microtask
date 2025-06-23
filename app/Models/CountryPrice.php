<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryPrice extends Model
{
    protected $fillable = ['country_id','amount','priceable_type','priceable_id'];
}
