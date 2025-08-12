<?php

namespace App\Livewire\DashboardArea\Notifications;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationDropdown extends Component
{
    public $unreadCount = 0;

    protected $listeners = [
        'notificationReceived' => 'updateCount',
        'notificationRead' => 'updateCount',
        'notificationDeleted' => 'updateCount'
    ];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        if (Auth::check()) {
            $this->unreadCount = Auth::user()->unreadNotifications()->count();
        }
    }

    public function render()
    {
        return view('livewire.dashboard-area.notifications.notification-dropdown');
    }
}
