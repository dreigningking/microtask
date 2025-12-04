<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    use HasFactory,Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'bank_account_storage',
        'banking_fields',
    ];

    protected $casts = [
        'banking_fields' => 'array',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}