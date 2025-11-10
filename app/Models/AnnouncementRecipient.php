<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementRecipient extends Model
{
    use HasFactory;

    protected $table = 'announcement_recipients';

    protected $fillable = [
        'announcement_id',
        'user_id',
        'email_sent_at',
        'email_delivered_at',
        'email_failed_at',
        'email_failure_reason',
        'database_notification_sent_at',
        'database_notification_read_at',
        'first_viewed_at',
        'clicked_link',
        'clicked_at',
        'interaction_data',
        'status',
        'completed_at',
        'cleanup_at',
        'is_archived',
    ];

    protected $casts = [
        'email_sent_at' => 'datetime',
        'email_delivered_at' => 'datetime',
        'email_failed_at' => 'datetime',
        'database_notification_sent_at' => 'datetime',
        'database_notification_read_at' => 'datetime',
        'first_viewed_at' => 'datetime',
        'clicked_at' => 'datetime',
        'interaction_data' => 'array',
        'completed_at' => 'datetime',
        'cleanup_at' => 'datetime',
        'clicked_link' => 'boolean',
        'is_archived' => 'boolean',
    ];

    /**
     * Get the announcement this recipient belongs to
     */
    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    /**
     * Get the user who received the announcement
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for pending recipients
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for sent recipients
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope for delivered recipients
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Scope for failed recipients
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for read recipients
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Scope for clicked recipients
     */
    public function scopeClicked($query)
    {
        return $query->where('clicked_link', true);
    }

    /**
     * Scope for recipients that can be cleaned up
     */
    public function scopeForCleanup($query)
    {
        return $query->where('cleanup_at', '<=', now())
                    ->where('is_archived', true);
    }

    /**
     * Check if email was sent successfully
     */
    public function isEmailSent(): bool
    {
        return !is_null($this->email_sent_at);
    }

    /**
     * Check if email was delivered
     */
    public function isEmailDelivered(): bool
    {
        return !is_null($this->email_delivered_at);
    }

    /**
     * Check if email failed
     */
    public function isEmailFailed(): bool
    {
        return !is_null($this->email_failed_at);
    }

    /**
     * Check if database notification was sent
     */
    public function isNotificationSent(): bool
    {
        return !is_null($this->database_notification_sent_at);
    }

    /**
     * Check if database notification was read
     */
    public function isNotificationRead(): bool
    {
        return !is_null($this->database_notification_read_at);
    }

    /**
     * Check if recipient has viewed the announcement
     */
    public function hasViewed(): bool
    {
        return !is_null($this->first_viewed_at);
    }

    /**
     * Check if recipient clicked any link
     */
    public function hasClicked(): bool
    {
        return $this->clicked_link;
    }

    /**
     * Get the current status based on delivery timestamps
     */
    public function getCurrentStatusAttribute(): string
    {
        if ($this->email_failed_at || $this->status === 'failed') {
            return 'failed';
        }

        if ($this->clicked_at) {
            return 'clicked';
        }

        if ($this->first_viewed_at || $this->database_notification_read_at) {
            return 'read';
        }

        if ($this->email_delivered_at || $this->database_notification_sent_at) {
            return 'delivered';
        }

        if ($this->email_sent_at) {
            return 'sent';
        }

        return 'pending';
    }

    /**
     * Mark email as sent
     */
    public function markEmailSent(): void
    {
        $this->update([
            'email_sent_at' => now(),
            'status' => $this->status === 'pending' ? 'sent' : $this->status
        ]);
    }

    /**
     * Mark email as delivered
     */
    public function markEmailDelivered(): void
    {
        $this->update([
            'email_delivered_at' => now(),
            'status' => in_array($this->status, ['pending', 'sent']) ? 'delivered' : $this->status
        ]);
    }

    /**
     * Mark email as failed
     */
    public function markEmailFailed(string $reason = null): void
    {
        $this->update([
            'email_failed_at' => now(),
            'email_failure_reason' => $reason,
            'status' => 'failed'
        ]);
    }

    /**
     * Mark database notification as sent
     */
    public function markNotificationSent(): void
    {
        $this->update([
            'database_notification_sent_at' => now(),
            'status' => in_array($this->status, ['pending', 'sent']) ? 'delivered' : $this->status
        ]);
    }

    /**
     * Mark database notification as read
     */
    public function markNotificationRead(): void
    {
        $this->update([
            'database_notification_read_at' => now(),
            'status' => 'read'
        ]);
    }

    /**
     * Mark announcement as viewed
     */
    public function markAsViewed(): void
    {
        $this->update([
            'first_viewed_at' => now(),
            'status' => 'read'
        ]);
    }

    /**
     * Mark as clicked
     */
    public function markAsClicked(array $interactionData = []): void
    {
        $this->update([
            'clicked_link' => true,
            'clicked_at' => now(),
            'interaction_data' => array_merge($this->interaction_data ?? [], $interactionData),
            'status' => 'clicked',
            'completed_at' => now()
        ]);
    }

    /**
     * Mark as completed (all interactions done)
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'completed_at' => now(),
            'status' => 'clicked'
        ]);
    }

    /**
     * Set cleanup timestamp
     */
    public function setCleanupDate(\DateTime $cleanupDate): void
    {
        $this->update(['cleanup_at' => $cleanupDate]);
    }

    /**
     * Archive record for cleanup
     */
    public function archiveForCleanup(): void
    {
        $this->update([
            'is_archived' => true,
            'cleanup_at' => now()->addDays(30) // Default 30 days for cleanup
        ]);
    }

    /**
     * Get total interaction time (from sent to completed)
     */
    public function getInteractionTimeAttribute(): ?int
    {
        if ($this->completed_at && $this->email_sent_at) {
            return $this->completed_at->diffInMinutes($this->email_sent_at);
        }
        return null;
    }

    /**
     * Get readable status label
     */
    public function getStatusLabelAttribute(): string
    {
        $statusMap = [
            'pending' => 'Pending',
            'sent' => 'Sent',
            'delivered' => 'Delivered',
            'failed' => 'Failed',
            'read' => 'Read',
            'clicked' => 'Clicked'
        ];

        return $statusMap[$this->current_status] ?? ucfirst($this->current_status);
    }
}