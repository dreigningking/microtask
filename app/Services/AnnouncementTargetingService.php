<?php

namespace App\Services;

use App\Models\User;
use App\Models\Announcement;
use App\Models\AnnouncementRecipient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AnnouncementTargetingService
{
    /**
     * Get target users based on segment and criteria
     */
    public function getTargetUsers(string $segment, array $criteria = []): Collection
    {
        $query = User::query();
        
        // Apply the segment targeting
        $query->bySegment($segment, $criteria);
        
        // Exclude users who already received this announcement if it exists
        if (isset($criteria['announcement_id'])) {
            $query->whereDoesntHave('announcementRecipients', function ($q) use ($criteria) {
                $q->where('announcement_id', $criteria['announcement_id']);
            });
        }
        
        return $query->get();
    }

    /**
     * Get target user count for a segment
     */
    public function getTargetUserCount(string $segment, array $criteria = []): int
    {
        $query = User::query()->bySegment($segment, $criteria);
        
        if (isset($criteria['announcement_id'])) {
            $query->whereDoesntHave('announcementRecipients', function ($q) use ($criteria) {
                $q->where('announcement_id', $criteria['announcement_id']);
            });
        }
        
        return $query->count();
    }

    /**
     * Create recipient records for an announcement
     */
    public function createRecipients(Announcement $announcement, Collection $users): Collection
    {
        $recipients = collect();
        
        DB::beginTransaction();
        try {
            foreach ($users as $user) {
                // Check if recipient already exists
                $existingRecipient = AnnouncementRecipient::where('announcement_id', $announcement->id)
                    ->where('user_id', $user->id)
                    ->first();
                
                if (!$existingRecipient) {
                    $recipient = AnnouncementRecipient::create([
                        'announcement_id' => $announcement->id,
                        'user_id' => $user->id,
                        'status' => 'pending',
                        'cleanup_at' => now()->addDays(30) // Default cleanup after 30 days
                    ]);
                    
                    $recipients->push($recipient);
                }
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
        return $recipients;
    }

    /**
     * Send announcement to target users
     */
    public function sendToTargets(Announcement $announcement, string $segment, array $criteria = []): array
    {
        $targetUsers = $this->getTargetUsers($segment, array_merge($criteria, [
            'announcement_id' => $announcement->id
        ]));
        
        if ($targetUsers->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No users found for the specified segment',
                'count' => 0
            ];
        }
        
        // Create recipient records
        $recipients = $this->createRecipients($announcement, $targetUsers);
        
        // Update announcement with recipient count
        $announcement->update([
            'recipients_count' => $targetUsers->count(),
            'status' => 'pending'
        ]);
        
        // Process delivery based on via method
        $deliveryResults = $this->processDelivery($announcement, $recipients);
        
        return [
            'success' => true,
            'message' => 'Announcement sent to ' . $targetUsers->count() . ' users',
            'count' => $targetUsers->count(),
            'recipients' => $recipients,
            'delivery_results' => $deliveryResults
        ];
    }

    /**
     * Process delivery based on announcement settings
     */
    private function processDelivery(Announcement $announcement, Collection $recipients): array
    {
        $results = [
            'email' => ['sent' => 0, 'failed' => 0],
            'database' => ['sent' => 0, 'failed' => 0]
        ];
        
        foreach ($recipients as $recipient) {
            $user = $recipient->user;
            
            // Process email delivery if via includes 'email' or 'both'
            if (in_array($announcement->via, ['email', 'both'])) {
                $emailResult = $this->sendEmailNotification($announcement, $user, $recipient);
                if ($emailResult) {
                    $results['email']['sent']++;
                } else {
                    $results['email']['failed']++;
                }
            }
            
            // Process database notification if via includes 'database' or 'both'
            if (in_array($announcement->via, ['database', 'both'])) {
                $dbResult = $this->sendDatabaseNotification($announcement, $user, $recipient);
                if ($dbResult) {
                    $results['database']['sent']++;
                } else {
                    $results['database']['failed']++;
                }
            }
        }
        
        // Update announcement delivery statistics
        $announcement->update([
            'emails_sent' => $results['email']['sent'] + $results['email']['failed'],
            'emails_delivered' => $results['email']['sent'],
            'emails_failed' => $results['email']['failed'],
            'database_notifications_sent' => $results['database']['sent'] + $results['database']['failed']
        ]);
        
        return $results;
    }

    /**
     * Send email notification (placeholder - implement based on your email service)
     */
    private function sendEmailNotification(Announcement $announcement, User $user, AnnouncementRecipient $recipient): bool
    {
        try {
            // Mark email as sent
            $recipient->markEmailSent();
            
            // Here you would integrate with your email service
            // For example: Mail::to($user->email)->send(new AnnouncementEmail($announcement));
            
            // Simulate email delivery (in real implementation, you'd handle this via events/callbacks)
            $recipient->markEmailDelivered();
            
            return true;
        } catch (\Exception $e) {
            $recipient->markEmailFailed($e->getMessage());
            return false;
        }
    }

    /**
     * Send database notification
     */
    private function sendDatabaseNotification(Announcement $announcement, User $user, AnnouncementRecipient $recipient): bool
    {
        try {
            // Mark notification as sent
            $recipient->markNotificationSent();
            
            // Create database notification for the user
            $user->notifications()->create([
                'id' => \Illuminate\Support\Str::uuid(),
                'type' => 'App\\Notifications\\General\\AnnouncementNotification',
                'notifiable_type' => 'App\\Models\\User',
                'notifiable_id' => $user->id,
                'data' => [
                    'announcement_id' => $announcement->id,
                    'subject' => $announcement->subject,
                    'message' => $announcement->message,
                    'priority' => $announcement->priority,
                    'sender_id' => $announcement->sent_by
                ],
                'read_at' => null,
                'created_at' => now()
            ]);
            
            return true;
        } catch (\Exception $e) {
            // Log error but don't mark as failed since database notifications are more reliable
            \Illuminate\Support\Facades\Log::error('Failed to create database notification for announcement: ' . $announcement->id . ' User: ' . $user->id, [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Mark recipient as having viewed the announcement
     */
    public function markAsViewed(AnnouncementRecipient $recipient, array $interactionData = []): void
    {
        $recipient->markAsViewed();
        
        if (!empty($interactionData)) {
            $recipient->update([
                'interaction_data' => array_merge($recipient->interaction_data ?? [], $interactionData)
            ]);
        }
    }

    /**
     * Mark recipient as having clicked a link
     */
    public function markAsClicked(AnnouncementRecipient $recipient, array $interactionData = []): void
    {
        $recipient->markAsClicked($interactionData);
        
        // Mark announcement as completed if this is the final interaction
        $announcement = $recipient->announcement;
        $totalRecipients = $announcement->recipients()->whereNotNull('completed_at')->count() + 1;
        
        if ($totalRecipients >= $announcement->recipients()->count()) {
            $announcement->update(['status' => 'completed']);
        }
    }

    /**
     * Get delivery statistics for an announcement
     */
    public function getDeliveryStats(Announcement $announcement): array
    {
        $recipients = $announcement->recipients();
        
        return [
            'total_recipients' => $recipients->count(),
            'emails' => [
                'sent' => $recipients->whereNotNull('email_sent_at')->count(),
                'delivered' => $recipients->whereNotNull('email_delivered_at')->count(),
                'failed' => $recipients->whereNotNull('email_failed_at')->count(),
                'delivery_rate' => $this->calculateRate($recipients->whereNotNull('email_delivered_at')->count(), $recipients->whereNotNull('email_sent_at')->count())
            ],
            'database_notifications' => [
                'sent' => $recipients->whereNotNull('database_notification_sent_at')->count(),
                'read' => $recipients->whereNotNull('database_notification_read_at')->count(),
                'read_rate' => $this->calculateRate($recipients->whereNotNull('database_notification_read_at')->count(), $recipients->whereNotNull('database_notification_sent_at')->count())
            ],
            'engagement' => [
                'viewed' => $recipients->whereNotNull('first_viewed_at')->count(),
                'clicked' => $recipients->where('clicked_link', true)->count(),
                'view_rate' => $this->calculateRate($recipients->whereNotNull('first_viewed_at')->count(), $recipients->count()),
                'click_rate' => $this->calculateRate($recipients->where('clicked_link', true)->count(), $recipients->count())
            ]
        ];
    }

    /**
     * Calculate percentage rate
     */
    private function calculateRate(int $count, int $total): float
    {
        if ($total === 0) {
            return 0.0;
        }
        
        return round(($count / $total) * 100, 2);
    }

    /**
     * Clean up old recipient records
     */
    public function cleanupOldRecipients(int $daysOld = 30): int
    {
        $cutoffDate = now()->subDays($daysOld);
        
        return AnnouncementRecipient::where('cleanup_at', '<=', $cutoffDate)
            ->where('is_archived', true)
            ->delete();
    }

    /**
     * Get available segments with user counts
     */
    public function getSegmentsWithCounts(array $excludeAnnouncementIds = []): array
    {
        $segments = config('settings.announcement_segments', []);
        $segmentsWithCounts = [];
        
        foreach ($segments as $key => $segment) {
            $query = User::query()->bySegment($key);
            
            // Exclude users who have already received specific announcements
            if (!empty($excludeAnnouncementIds)) {
                $query->whereDoesntHave('announcementRecipients', function ($q) use ($excludeAnnouncementIds) {
                    $q->whereIn('announcement_id', $excludeAnnouncementIds);
                });
            }
            
            $segmentsWithCounts[$key] = [
                'name' => $segment['name'],
                'description' => $segment['description'],
                'user_count' => $query->count(),
                'filters' => $segment['filters']
            ];
        }
        
        return $segmentsWithCounts;
    }

    /**
     * Validate segment configuration
     */
    public function validateSegment(string $segment): bool
    {
        $segments = config('settings.announcement_segments', []);
        return isset($segments[$segment]);
    }

    /**
     * Get segment display information
     */
    public function getSegmentInfo(string $segment): ?array
    {
        $segments = config('settings.announcement_segments', []);
        return $segments[$segment] ?? null;
    }
}