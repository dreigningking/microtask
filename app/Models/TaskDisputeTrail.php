<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskDisputeTrail extends Model
{
    protected $fillable = [
        'task_dispute_id',
        'user_id',
        'status',
    ];

    /**
     * Get the dispute this trail belongs to
     */
    public function taskDispute(): BelongsTo
    {
        return $this->belongsTo(TaskDispute::class);
    }

    /**
     * Get the user who created this trail
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
