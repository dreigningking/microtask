<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    protected $connection = 'mysql'; 
    protected $table = 'user_locations';

    protected $fillable = [
        'user_id',
        'country_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->setConnection('sqlite_countries')->belongsTo(Country::class);
    }
}
