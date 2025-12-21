<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views_count',
        'tags',
        'reading_time',
        'allow_comments',
        'featured',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'allow_comments' => 'boolean',
        'featured' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the category this post belongs to
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user who created this post
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all comments on this post
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the moderations for this post
     */
    public function moderations(): MorphMany
    {
        return $this->morphMany(Moderation::class, 'moderatable');
    }

    public function latestModeration(): MorphOne
    {
        return $this->morphOne(Moderation::class, 'moderatable')->latestOfMany();
    }

    /**
     * Check if post is published
     */
    public function isPublished(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if post is featured
     */
    public function isFeatured(): bool
    {
        return $this->featured !== null;
    }

    /**
     * Check if post allows comments
     */
    public function allowsComments(): bool
    {
        return $this->allow_comments;
    }

    /**
     * Increment views count
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Scope for published posts
     */
    public function scopePublished($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured posts
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', '!=', null);
    }

    /**
     * Scope for posts in specific category
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope for help posts
     */
    public function scopeHelp($query)
    {
        return $query->whereHas('category', function ($q) {
            $q->where('is_help', true);
        });
    }
}
