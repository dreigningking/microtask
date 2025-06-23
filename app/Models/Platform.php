<?php

namespace App\Models;

use App\Models\TaskTemplate;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Platform extends Model
{
    use HasFactory, Sluggable;
    protected $connection = 'mysql'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }
    /**
     * Get the tasks for the platform.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function templates()
    {
        return $this->hasMany(TaskTemplate::class);
    }
}
