<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskPromotion extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'type',
        'days',
        'start_at',
        'end_at',
        'cost',
        'currency',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getExpiresAtAttribute(){
        return $this->created_at->addDays($this->days);
    }

    public function scopeLocalize($query)
    {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->slug == 'super-admin') {
            return $query;
        }

        return $query->where(function ($q) {
            $q->whereHas('user', function ($q) {
                $q->where('country_id', Auth::user()->country_id);
            });
        });
    }

    /**
     * Scope for running promotions (not expired)
     */
    public function scopeRunning($query)
    {
        return $query->where('end_at', '>', now());
    }

    /**
     * Scope for finished promotions (expired)
     */
    public function scopeFinished($query)
    {
        return $query->where('end_at', '<=', now());
    }

    /**
     * Scope for promotions by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for promotions by country
     */
    public function scopeByCountry($query, $countryId)
    {
        return $query->whereHas('user', function ($q) use ($countryId) {
            $q->where('country_id', $countryId);
        });
    }

    /**
     * Scope for searching task title
     */
    public function scopeSearchTask($query, $search)
    {
        return $query->whereHas('task', function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }
}
