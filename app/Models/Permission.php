<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use Sluggable;
    protected $fillable = ['name', 'description'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
} 