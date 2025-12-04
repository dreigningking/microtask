<?php

namespace App\Models;

use App\Models\Trail;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TaskDispute extends Model
{
    protected $fillable = [
        'task_submission_id',
        'desired_outcome',
        'resolved_at',
        'resolution',
        'resolution_value',
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
    public function latestTrail(): MorphOne
    {
        return $this->morphOne(Trail::class,'trailable')->latestOfMany();
    }
    
    
    public function trails(): MorphMany
    {
        
        return $this->morphMany(Trail::class,'trailable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
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

    public function getOutcomeAttribute(){
        switch($this->desired_outcome){
            case 'full-payment': return 'Worker is seeking full payment for work';
                break;
            case 'partial-payment': return 'Worker is seeking partial payment for work';
                break;
            case 'resubmission': return 'Worker is seeking resubmission of work';
                break;
            default: return 'Not provided';
        }
        
    }

    public function getResolutionInstructionAttribute(){
        switch($this->resolution){
            case 'full-payment': return 'Full payment awarded to worker';
                break;
            case 'partial-payment': return 'Partial payment of '.$this->resolution_value.'% awarded to worker';
                break;
            case 'resubmission': return 'Worker was granted resubmission of task';
                break;
            default: return 'Not provided';
        }
        
    }
}
