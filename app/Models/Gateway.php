<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'bank_account_storage',
        'banking_fields',
    ];

    protected $casts = [
        'banking_fields' => 'array',
    ];
}