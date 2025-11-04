<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

}