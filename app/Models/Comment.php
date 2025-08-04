<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Http\Traits\HasMentions;
use App\Models\User;

class Comment extends Model
{
    use HasFactory, HasMentions;

    protected $fillable = ['user_id','commentable_id','commentable_type','body','attachments','is_flag'];
    protected $casts = ['attachments'=> 'array'];

    protected $touches = ['commentable']; // name of the relationship method


    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSpam($query)
    {
        return $query->where('status', 'spam');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByBlogPost($query, $blogPostId)
    {
        return $query->where('blog_post_id', $blogPostId);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Methods
    public function approve($approvedBy = null): bool
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $approvedBy ?? auth()->id(),
        ]);

        return true;
    }

    public function reject($rejectedBy = null): bool
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $rejectedBy ?? auth()->id(),
        ]);

        return true;
    }

    public function markAsSpam(): bool
    {
        $this->update(['status' => 'spam']);
        return true;
    }

    public function toggleFeatured(): bool
    {
        $this->update(['is_featured' => !$this->is_featured]);
        return $this->is_featured;
    }

    public function incrementLikes(): void
    {
        $this->increment('likes_count');
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
        return $this->isByUser($user) && $this->is_pending;
    }

    public function canBeDeletedBy(User $user): bool
    {
        return $this->isByUser($user) || $user->hasRole('admin');
    }

    // Boot method for processing mentions
    protected static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            $comment->processMentions();
        });

        static::updated(function ($comment) {
            if ($comment->isDirty('content')) {
                $comment->processMentions();
            }
        });
    }

    

    public function commentable()
    {
        return $this->morphTo();
    }


}
