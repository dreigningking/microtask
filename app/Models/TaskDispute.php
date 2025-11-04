<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TaskDispute extends Model
{
    protected $fillable = [
        'task_submission_id',
        'resolved_at',
        'resolution',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the task submission this dispute belongs to
     */
    public function taskSubmission(): BelongsTo
    {
        return $this->belongsTo(TaskSubmission::class);
    }

    /**
     * Get all dispute trails (comments) for this dispute
     */
    public function disputeTrails(): MorphMany
    {
        return $this->morphMany(TaskDisputeTrail::class, 'trailable');
    }

    /**
     * Check if dispute is resolved
     */
    public function isResolved(): bool
    {
        return !is_null($this->resolved_at);
    }

    /**
     * Scope for unresolved disputes
     */
    public function scopeUnresolved($query)
    {
        return $query->whereNull('resolved_at');
    }

    /**
     * Scope for resolved disputes
     */
    public function scopeResolved($query)
    {
        return $query->whereNotNull('resolved_at');
    }
}
