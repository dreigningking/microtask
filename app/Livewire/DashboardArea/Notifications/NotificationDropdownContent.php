<?php

namespace App\Livewire\DashboardArea\Notifications;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationDropdownContent extends Component
{
    public $recentNotifications = [];
    public $maxNotifications = 5;

    protected $listeners = [
        'notificationReceived' => 'loadNotifications',
        'notificationRead' => 'loadNotifications',
        'notificationDeleted' => 'loadNotifications'
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (Auth::check()) {
            $this->recentNotifications = Auth::user()
                ->notifications()
                ->orderBy('created_at', 'desc')
                ->limit($this->maxNotifications)
                ->get();
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
            $this->loadNotifications();
            $this->dispatch('notificationRead');
        }
    }

    public function render()
    {
        return view('livewire.dashboard-area.notifications.notification-dropdown-content');
    }
}
