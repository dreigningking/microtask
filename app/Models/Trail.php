<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trail extends Model
{
    protected $fillable = [
        'trailable_id',
        'trailable_type',
        'user_id',
        'assigned_by',
        'note',
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
    
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'assigned_by');
    }
}
