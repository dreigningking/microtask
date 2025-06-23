<?php

namespace App\Models;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Model;

class TaskTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'platform_id',
        'task_fields',
        'submission_fields',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'task_fields' => 'array',
        'submission_fields' => 'array',
    ];

    /**
     * Get the tasks that use this template.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'template_id');
    }

    public function platform(){
        return $this->belongsTo(Platform::class);
    }

    public function getCountryPrice($country_id)
    {
        $price = \App\Models\CountryPrice::where('country_id', $country_id)
            ->where('priceable_type', self::class)
            ->where('priceable_id', $this->id)
            ->first();
        return $price ? (float) $price->amount : null;
    }
}
