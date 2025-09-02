<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'body',
        'attachments',
        'is_flag',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_flag' => 'boolean',
        'approved_at' => 'datetime',
        'approved_by' => 'integer'
    ];

    protected $touches = ['commentable']; // name of the relationship method

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    public function scopePending($query)
    {
        return $query->whereNull('approved_at');
    }

    public function scopeFlagged($query)
    {
        return $query->where('is_flag', true);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Methods
    public function approve($approvedBy = null): bool
    {
        $this->update([
            'approved_at' => now(),
            'approved_by' => $approvedBy ?? auth()->id(),
        ]);

        return true;
    }

    public function reject($rejectedBy = null): bool
    {
        $this->update([
            'approved_at' => null,
            'approved_by' => $rejectedBy ?? auth()->id(),
        ]);

        return true;
    }

    public function toggleFlag(): bool
    {
        $this->update(['is_flag' => !$this->is_flag]);
        return $this->is_flag;
    }

    public function isApproved(): bool
    {
        return !is_null($this->approved_at);
    }

    public function isPending(): bool
    {
        return is_null($this->approved_at);
    }

    public function isFlagged(): bool
    {
        return $this->is_flag;
    }

    public function isByGuest(): bool
    {
        return is_null($this->user_id);
    }

    public function isByUser(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    public function canBeEditedBy(User $user): bool
    {
        return $this->isByUser($user) && $this->isPending();
    }

    public function canBeDeletedBy(User $user): bool
    {
        return $this->isByUser($user) || $user->hasRole('super-admin');
    }
}
