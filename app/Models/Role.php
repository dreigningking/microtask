<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Role extends Model
{
    use Sluggable;
    protected $fillable = ['name', 'description'];

    public function sluggable(): array
    {
        return [
            'name' => [
                'source' => 'description'
            ]
        ];
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
} 