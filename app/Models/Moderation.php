<?php

namespace App\Models;

use App\Observers\ModerationObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ModerationObserver::class])]
class Moderation extends Model
{
    protected $fillable = [
        'moderatable_id',
        'moderatable_type',
        'moderator_id',
        'purpose',
        'status',
        'notes',
        'moderated_at',
    ];

    protected $casts = [
        'moderated_at' => 'datetime',
    ];

    /**
     * Get the parent moderatable model (polymorphic)
     */
    public function moderatable()
    {
        return $this->morphTo();
    }

    /**
     * Get the moderator who performed the moderation
     */
    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for pending moderations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved moderations
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for rejected moderations
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope for moderations by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('moderatable_type', $type);
    }

    /**
     * Get the target URL for the moderatable
     */
    public function getTargetAttribute()
    {
        $moderatable = $this->moderatable;

        if ($moderatable instanceof \App\Models\Task) {
            return route('explore.task', $moderatable);
        } elseif ($moderatable instanceof \App\Models\UserVerification) {
            return route('admin.user.verification.show', $moderatable);
        } elseif ($moderatable instanceof \App\Models\Withdrawal) {
            return route('admin.withdrawal.show', $moderatable);
        } elseif ($moderatable instanceof \App\Models\Post) {
            return route('post.show', $moderatable);
        } elseif ($moderatable instanceof \App\Models\Comment) {
            return route('comment.show', $moderatable);
        }

        return '#'; // fallback
    }
}
