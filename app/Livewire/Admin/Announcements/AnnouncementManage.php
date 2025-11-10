<?php

namespace App\Livewire\Admin\Announcements;

use App\Models\Announcement;
use App\Services\AnnouncementTargetingService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AnnouncementManage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    
    public $search = '';
    public $statusFilter = 'all';
    public $priorityFilter = 'all';
    public $dateFrom = '';
    public $dateTo = '';
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    public $selectedAnnouncement = null;
    
    public $segments = [];
    public $availableSegments = [];
    public $targetUserCount = 0;
    public $previewUsers = [];
    
    protected $targetingService;
    
    public function boot(AnnouncementTargetingService $targetingService)
    {
        $this->targetingService = $targetingService;
    }

    public function mount()
    {
        $this->loadSegments();
    }

    public function loadSegments()
    {
        $this->segments = $this->targetingService->getSegmentsWithCounts();
        $this->availableSegments = \App\Models\User::getAvailableSegments();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedPriorityFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function getAnnouncementsProperty()
    {
        $query = Announcement::with(['sender', 'recipients'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%' . $this->search . '%')
                  ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->priorityFilter !== 'all') {
            $query->where('priority', $this->priorityFilter);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        return $query->paginate(15);
    }

    public function getStatsProperty()
    {
        return [
            'total' => Announcement::count(),
            'sent' => Announcement::successful()->count(),
            'scheduled' => Announcement::scheduled()->count(),
            'failed' => Announcement::failed()->count(),
            'active' => Announcement::active()->count(),
            'archived' => Announcement::where('is_archived', true)->count(),
            'this_month' => Announcement::whereMonth('created_at', now()->month)->count(),
        ];
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
        $this->dispatch('modalOpened');
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->reset(['targetUserCount', 'previewUsers']);
    }

    public function openEditModal($announcementId)
    {
        $this->selectedAnnouncement = Announcement::findOrFail($announcementId);
        $this->showEditModal = true;
        $this->dispatch('modalOpened');
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->selectedAnnouncement = null;
    }

    public function openViewModal($announcementId)
    {
        $this->selectedAnnouncement = Announcement::with(['sender', 'recipients.user'])->findOrFail($announcementId);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedAnnouncement = null;
    }

    public function getTargetUserCount($segment, $criteria = [])
    {
        $this->targetUserCount = $this->targetingService->getTargetUserCount($segment, $criteria);
        $this->dispatch('targetCountUpdated', count: $this->targetUserCount);
    }

    public function getPreviewUsers($segment, $criteria = [])
    {
        $this->previewUsers = $this->targetingService->getTargetUsers($segment, $criteria)->take(10)->toArray();
        $this->dispatch('previewUsersUpdated', users: $this->previewUsers);
    }

    public function sendNow($announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);
        
        if ($announcement->status !== 'scheduled') {
            $this->dispatch('showAlert', type: 'error', message: 'Only scheduled announcements can be sent immediately.');
            return;
        }

        $result = $this->targetingService->sendToTargets(
            $announcement,
            $announcement->target_segment,
            $announcement->target_criteria ?? []
        );

        if ($result['success']) {
            $announcement->markAsSent();
            $this->dispatch('showAlert', type: 'success', message: $result['message']);
            $this->dispatch('announcementUpdated');
        } else {
            $this->dispatch('showAlert', type: 'error', message: $result['message']);
        }
    }

    public function archive($announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);
        $announcement->update(['is_archived' => true]);
        
        $this->dispatch('showAlert', type: 'success', message: 'Announcement archived successfully.');
        $this->dispatch('announcementUpdated');
    }

    public function unarchive($announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);
        $announcement->update(['is_archived' => false]);
        
        $this->dispatch('showAlert', type: 'success', message: 'Announcement unarchived successfully.');
        $this->dispatch('announcementUpdated');
    }

    public function delete($announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);
        
        if (!$announcement->is_archived && $announcement->status !== 'failed') {
            $this->dispatch('showAlert', type: 'error', message: 'Only archived or failed announcements can be deleted.');
            return;
        }

        $announcement->delete();
        $this->dispatch('showAlert', type: 'success', message: 'Announcement deleted successfully.');
        $this->dispatch('announcementUpdated');
    }

    public function render()
    {
        return view('livewire.admin.announcements.announcement-manage', [
            'announcements' => $this->announcements,
            'stats' => $this->stats
        ]);
    }
}