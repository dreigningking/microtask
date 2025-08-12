<?php

namespace App\Livewire\DashboardArea\Notifications;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class ListNotifications extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, unread, read
    public $perPage = 20;

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'perPage' => ['except' => 20],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->markAsRead();
            session()->flash('success', 'Notification marked as read.');
            $this->dispatch('notificationRead');
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        session()->flash('success', 'All notifications marked as read.');
        $this->dispatch('notificationRead');
    }

    public function deleteNotification($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->delete();
            session()->flash('success', 'Notification deleted successfully.');
            $this->dispatch('notificationDeleted');
        }
    }

    public function clearAllRead()
    {
        Auth::user()->readNotifications()->delete();
        session()->flash('success', 'All read notifications cleared.');
        $this->dispatch('notificationDeleted');
    }

    public function getNotificationsQuery()
    {
        $query = Auth::user()->notifications();

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('data->title', 'like', '%' . $this->search . '%')
                  ->orWhere('data->message', 'like', '%' . $this->search . '%')
                  ->orWhere('data->subject', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        switch ($this->filter) {
            case 'unread':
                $query->whereNull('read_at');
                break;
            case 'read':
                $query->whereNotNull('read_at');
                break;
            default:
                // 'all' - no filter
                break;
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function render()
    {
        $notifications = $this->getNotificationsQuery()->paginate($this->perPage);
        
        $stats = [
            'total' => Auth::user()->notifications()->count(),
            'unread' => Auth::user()->unreadNotifications()->count(),
            'read' => Auth::user()->readNotifications()->count(),
        ];

        return view('livewire.dashboard-area.notifications.list-notifications', [
            'notifications' => $notifications,
            'stats' => $stats,
        ]);
    }
}
