<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskWorker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskSubmission extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'task_id',
        'task_worker_id',
        'paid_at',
        'accepted',
        'submission_details',
        'review_body',
        'review_rating',
        'reviewed_at',
    ];

    protected $casts = [
        'paid_at'=> 'datetime',
        'accepted'=> 'boolean',
        'reviewed_at'=> 'datetime',
        'deleted_at'=> 'datetime',
        'submission_details'=> 'array'
    ];

    public function getStatusAttribute(){
        $hours = Setting::getValue('submission_review_deadline');
        if ($this->completed_at) {
            return 'completed at ' . $this->completed_at->format('M d, Y H:i');
        }
        if ($this->dispute) {
            if ($this->dispute->resolved_at) {
                return 'dispute resolved at ' . $this->dispute->resolved_at->format('M d, Y H:i');
            }
            return 'disputed at ' . $this->dispute->created_at->format('M d, Y H:i');
        }
        
        if ($this->paid_at) {
            return 'paid at ' . $this->paid_at->format('M d, Y H:i');
        }
        if ($this->created_at->diffInHours($this->completed_at) > $hours) {
            return 'overdue review';
        }
        
        return 'pending review since ' . $this->created_at->format('M d, Y H:i');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function taskWorker(): BelongsTo
    {
        return $this->belongsTo(TaskWorker::class);
    }

    /**
     * Get the dispute for this submission
     */
    public function dispute()
    {
        return $this->hasOne(TaskDispute::class);
    }

    /**
     * Check if submission is paid
     */
    public function isPaid(): bool
    {
        return !is_null($this->paid_at);
    }

    /**
     * Check if submission is completed
     */
    public function isCompleted(): bool
    {
        return !is_null($this->completed_at);
    }

    /**
     * Scope for paid submissions
     */
    public function scopePaid($query)
    {
        return $query->whereNotNull('paid_at');
    }

    /**
     * Scope for completed submissions
     */
    public function scopeAccepted($query)
    {
        return $query->where('accepted',1);
    }

    /**
     * Scope for pending submissions
     */
    public function scopePending($query)
    {
        return $query->whereNull('reviewed_at');
    }
}
