<?php

namespace App\Livewire\Admin\Announcements;

use App\Models\User;
use App\Services\AnnouncementTargetingService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnnouncementForm extends Component
{
    public $announcementId = null;
    
    #[Validate('required|string|max:255')]
    public $subject = '';
    
    #[Validate('required|string|max:5000')]
    public $message = '';
    
    #[Validate('required|in:email,database,both')]
    public $via = 'both';
    
    #[Validate('required|string')]
    public $targetSegment = '';
    
    public $targetCriteria = [];
    
    #[Validate('required|in:low,normal,high,urgent')]
    public $priority = 'normal';
    
    public $scheduledAt = '';
    public $expiresAt = '';
    public $metadata = [];
    
    public $segments = [];
    public $availableSegments = [];
    public $targetUserCount = 0;
    public $previewUsers = [];
    public $showPreview = false;
    public $isEdit = false;
    
    protected $targetingService;
    
    public function boot(AnnouncementTargetingService $targetingService)
    {
        $this->targetingService = $targetingService;
    }

    public function mount($announcementId = null)
    {
        $this->announcementId = $announcementId;
        $this->loadSegments();
        
        if ($announcementId) {
            $this->loadAnnouncement();
            $this->isEdit = true;
        }
    }

    public function loadSegments()
    {
        $this->segments = $this->targetingService->getSegmentsWithCounts();
        $this->availableSegments = User::getAvailableSegments();
    }

    public function loadAnnouncement()
    {
        $announcement = \App\Models\Announcement::findOrFail($this->announcementId);
        
        $this->subject = $announcement->subject;
        $this->message = $announcement->message;
        $this->via = $announcement->via;
        $this->targetSegment = $announcement->target_segment;
        $this->targetCriteria = $announcement->target_criteria ?? [];
        $this->priority = $announcement->priority;
        $this->scheduledAt = $announcement->scheduled_at ? $announcement->scheduled_at->format('Y-m-d\TH:i') : '';
        $this->expiresAt = $announcement->expires_at ? $announcement->expires_at->format('Y-m-d\TH:i') : '';
        $this->metadata = $announcement->metadata ?? [];
    }

    public function updatedTargetSegment()
    {
        $this->updateTargetUserCount();
        $this->updatePreviewUsers();
    }

    public function updatedTargetCriteria()
    {
        $this->updateTargetUserCount();
        $this->updatePreviewUsers();
    }

    public function updateTargetUserCount()
    {
        if ($this->targetSegment) {
            $this->targetUserCount = $this->targetingService->getTargetUserCount(
                $this->targetSegment,
                $this->targetCriteria
            );
            $this->dispatch('targetCountUpdated', count: $this->targetUserCount);
        }
    }

    public function updatePreviewUsers()
    {
        if ($this->targetSegment) {
            $this->previewUsers = $this->targetingService->getTargetUsers(
                $this->targetSegment,
                $this->targetCriteria
            )->take(10)->values()->toArray();
            $this->dispatch('previewUsersUpdated', users: $this->previewUsers);
        }
    }

    public function togglePreview()
    {
        $this->showPreview = !$this->showPreview;
    }

    public function addMetadataField()
    {
        $this->metadata[] = ['key' => '', 'value' => ''];
    }

    public function removeMetadataField($index)
    {
        unset($this->metadata[$index]);
        $this->metadata = array_values($this->metadata);
    }

    public function validateTargetSegment()
    {
        if (!$this->targetSegment) {
            return;
        }

        $isValid = $this->targetingService->validateSegment($this->targetSegment);
        if (!$isValid) {
            $this->addError('targetSegment', 'Invalid target segment selected.');
        } else {
            $this->resetErrorBag('targetSegment');
        }
    }

    public function validateSchedule()
    {
        if ($this->scheduledAt) {
            $scheduled = Carbon::parse($this->scheduledAt);
            if ($scheduled->isPast()) {
                $this->addError('scheduledAt', 'Scheduled time must be in the future.');
            } else {
                $this->resetErrorBag('scheduledAt');
            }
        }

        if ($this->expiresAt) {
            $expires = Carbon::parse($this->expiresAt);
            if ($this->scheduledAt && $expires->lte(Carbon::parse($this->scheduledAt))) {
                $this->addError('expiresAt', 'Expiration time must be after scheduled time.');
            } else {
                $this->resetErrorBag('expiresAt');
            }
        }
    }

    public function updatedScheduledAt()
    {
        $this->validateSchedule();
    }

    public function updatedExpiresAt()
    {
        $this->validateSchedule();
    }

    public function save()
    {
        $this->validate();
        $this->validateTargetSegment();
        $this->validateSchedule();

        if ($this->getErrorBag()->isNotEmpty()) {
            return;
        }

        try {
            $data = [
                'subject' => $this->subject,
                'message' => $this->message,
                'via' => $this->via,
                'target_segment' => $this->targetSegment,
                'target_criteria' => $this->targetCriteria,
                'priority' => $this->priority,
                'metadata' => $this->formatMetadata()
            ];

            if ($this->scheduledAt) {
                $data['scheduled_at'] = Carbon::parse($this->scheduledAt);
            }

            if ($this->expiresAt) {
                $data['expires_at'] = Carbon::parse($this->expiresAt);
            }

            if ($this->isEdit) {
                $announcement = \App\Models\Announcement::findOrFail($this->announcementId);
                $announcement->update($data);
                $message = 'Announcement updated successfully.';
            } else {
                $data['sent_by'] = Auth::id();
                $data['status'] = $this->scheduledAt ? 'scheduled' : 'pending';
                
                $announcement = \App\Models\Announcement::create($data);
                $message = 'Announcement created successfully.';
            }

            // If not scheduled, send immediately
            if (!$this->scheduledAt) {
                $result = $this->targetingService->sendToTargets(
                    $announcement,
                    $this->targetSegment,
                    $this->targetCriteria
                );

                if ($result['success']) {
                    $announcement->markAsSent();
                    $message .= ' Sent to ' . $result['count'] . ' users.';
                } else {
                    $message .= ' However, sending failed: ' . $result['message'];
                }
            } else {
                $message .= ' Scheduled for ' . Carbon::parse($this->scheduledAt)->format('M d, Y \a\t h:i A');
            }

            $this->dispatch('showAlert', type: 'success', message: $message);
            $this->dispatch('announcementSaved');
            $this->resetForm();

        } catch (\Exception $e) {
            $this->dispatch('showAlert', type: 'error', message: 'Failed to save announcement: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'subject', 'message', 'via', 'targetSegment', 'targetCriteria',
            'priority', 'scheduledAt', 'expiresAt', 'metadata', 'targetUserCount',
            'previewUsers', 'showPreview'
        ]);
        $this->resetErrorBag();
        $this->loadSegments();
    }

    private function formatMetadata()
    {
        $formatted = [];
        foreach ($this->metadata as $field) {
            if (!empty($field['key']) && !empty($field['value'])) {
                $formatted[$field['key']] = $field['value'];
            }
        }
        return $formatted;
    }

    public function render()
    {
        return view('livewire.admin.announcements.announcement-form');
    }
}