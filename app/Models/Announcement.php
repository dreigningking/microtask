<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'message',
        'via',
        'sent_by',
        'recipients_count',
        'status',
        'target_segment',
        'target_criteria',
        'scheduled_at',
        'sent_at',
        'expires_at',
        'emails_sent',
        'emails_delivered',
        'emails_failed',
        'database_notifications_sent',
        'database_notifications_read',
        'priority',
        'is_archived',
        'metadata',
    ];

    protected $casts = [
        'recipients_count' => 'integer',
        'target_criteria' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'expires_at' => 'datetime',
        'metadata' => 'array',
        'emails_sent' => 'integer',
        'emails_delivered' => 'integer',
        'emails_failed' => 'integer',
        'database_notifications_sent' => 'integer',
        'database_notifications_read' => 'integer',
        'is_archived' => 'boolean',
    ];

    /**
     * Get the user who sent the announcement
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    /**
     * Get the recipients of this announcement
     */
    public function recipients()
    {
        return $this->hasMany(AnnouncementRecipient::class);
    }

    /**
     * Get users who received this announcement
     */
    public function recipientUsers()
    {
        return $this->hasManyThrough(User::class, AnnouncementRecipient::class, 'announcement_id', 'id', 'id', 'user_id');
    }

    /**
     * Scope for successful announcements
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope for failed announcements
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for scheduled announcements
     */
    public function scopeScheduled($query)
    {
        return $query->where('scheduled_at', '>', now())->where('status', '!=', 'sent');
    }

    /**
     * Scope for active announcements (not expired or archived)
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->where('is_archived', false);
    }

    /**
     * Scope for announcements by priority
     */
    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Check if announcement was sent successfully
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'sent';
    }

    /**
     * Check if announcement failed to send
     */
    public function hasFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Check if announcement is scheduled for future delivery
     */
    public function isScheduled(): bool
    {
        return $this->scheduled_at && $this->scheduled_at->isFuture() && $this->status !== 'sent';
    }

    /**
     * Check if announcement has expired
     */
    public function hasExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if announcement is active (not expired or archived)
     */
    public function isActive(): bool
    {
        return !$this->hasExpired() && !$this->is_archived;
    }

    /**
     * Get delivery rate percentage
     */
    public function getDeliveryRateAttribute(): float
    {
        if ($this->emails_sent === 0) {
            return 0.0;
        }
        return round(($this->emails_delivered / $this->emails_sent) * 100, 2);
    }

    /**
     * Get read rate percentage
     */
    public function getReadRateAttribute(): float
    {
        if ($this->database_notifications_sent === 0) {
            return 0.0;
        }
        return round(($this->database_notifications_read / $this->database_notifications_sent) * 100, 2);
    }

    /**
     * Get open rate percentage (first views)
     */
    public function getOpenRateAttribute(): float
    {
        $totalRecipients = $this->recipients()->count();
        if ($totalRecipients === 0) {
            return 0.0;
        }
        $openedCount = $this->recipients()->whereNotNull('first_viewed_at')->count();
        return round(($openedCount / $totalRecipients) * 100, 2);
    }

    /**
     * Get click rate percentage
     */
    public function getClickRateAttribute(): float
    {
        $totalRecipients = $this->recipients()->count();
        if ($totalRecipients === 0) {
            return 0.0;
        }
        $clickedCount = $this->recipients()->where('clicked_link', true)->count();
        return round(($clickedCount / $totalRecipients) * 100, 2);
    }

    /**
     * Get target segment configuration
     */
    public function getTargetSegmentConfigAttribute(): ?array
    {
        if (!$this->target_segment) {
            return null;
        }
        
        $segments = config('settings.announcement_segments');
        return $segments[$this->target_segment] ?? null;
    }

    /**
     * Get readable via delivery method
     */
    public function getViaLabelAttribute(): string
    {
        $viaMap = [
            'email' => 'Email',
            'database' => 'In-App Notification',
            'both' => 'Email & In-App'
        ];
        
        return $viaMap[$this->via] ?? ucfirst($this->via);
    }

    /**
     * Get readable priority label
     */
    public function getPriorityLabelAttribute(): string
    {
        $priorityMap = [
            'low' => 'Low',
            'normal' => 'Normal',
            'high' => 'High',
            'urgent' => 'Urgent'
        ];
        
        return $priorityMap[$this->priority] ?? ucfirst($this->priority);
    }

    /**
     * Get readable status with additional context
     */
    public function getDetailedStatusAttribute(): array
    {
        $status = [
            'status' => $this->status,
            'label' => ucfirst($this->status),
            'is_scheduled' => $this->isScheduled(),
            'is_sent' => $this->isSuccessful(),
            'has_failed' => $this->hasFailed(),
            'is_expired' => $this->hasExpired(),
            'is_archived' => $this->is_archived,
        ];

        if ($this->isScheduled()) {
            $status['label'] = 'Scheduled';
            $status['scheduled_for'] = $this->scheduled_at;
        }

        if ($this->hasExpired()) {
            $status['label'] = 'Expired';
        }

        if ($this->is_archived) {
            $status['label'] = 'Archived';
        }

        return $status;
    }

    /**
     * Update delivery statistics
     */
    public function updateDeliveryStats(): void
    {
        $recipients = $this->recipients();
        
        $stats = [
            'emails_sent' => $recipients->whereNotNull('email_sent_at')->count(),
            'emails_delivered' => $recipients->whereNotNull('email_delivered_at')->count(),
            'emails_failed' => $recipients->whereNotNull('email_failed_at')->count(),
            'database_notifications_sent' => $recipients->whereNotNull('database_notification_sent_at')->count(),
            'database_notifications_read' => $recipients->whereNotNull('database_notification_read_at')->count(),
        ];
        
        $this->update($stats);
    }

    /**
     * Mark announcement as sent and update sent_at timestamp
     */
    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now()
        ]);
    }

    /**
     * Schedule announcement for future delivery
     */
    public function scheduleFor(\DateTime $scheduledAt): void
    {
        $this->update([
            'scheduled_at' => $scheduledAt,
            'status' => 'scheduled'
        ]);
    }

    /**
     * Get announcements that are due for sending (scheduled and past scheduled time)
     */
    public function scopeDueForSending($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('scheduled_at', '<=', now());
    }
}
