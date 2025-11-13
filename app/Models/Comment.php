<?php

namespace App\Models;

use App\Models\User;
use App\Models\Moderation;
use App\Observers\CommentObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CommentObserver::class])]
class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'parent_id',
        'title',
        'body',
        'attachments',
        'is_flag',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_flag' => 'boolean',
    ];

    protected $touches = ['commentable']; // name of the relationship method

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment (for nested comments)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the child comments (replies)
     */
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function moderations(): MorphMany
    {
        return $this->morphMany(Moderation::class, 'moderatable');
    }

    public function latestModeration(): MorphOne
    {
        return $this->morphOne(Moderation::class, 'moderatable')->latestOfMany();
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
    public function approve(): bool
    {
        $this->update(['is_flag' => false]);
        return true;
    }

    public function reject(): bool
    {
        $this->update(['is_flag' => true]);
        return true;
    }

    public function toggleFlag(): bool
    {
        $this->update(['is_flag' => !$this->is_flag]);
        return $this->is_flag;
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
    public function getIsByAdminAttribute()
    {
        return isset($this->user->role_id);
    }

    public function canBeEditedBy(User $user): bool
    {
        return $this->isByUser($user);
    }

    public function canBeDeletedBy(User $user): bool
    {
        return $this->isByUser($user) || ($user->hasPermission && $user->hasPermission('system-settings'));
    }
}
