<?php

namespace App\Livewire\DashboardArea\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationSettings extends Component
{
    public $worker_email = [];
    public $worker_inapp = [];
    public $taskmaster_email = [];
    public $taskmaster_inapp = [];
    public $successMessage = null;

    protected $defaultSettings = [
        'worker_email' => [
            'new_jobs' => true,
            'submission_review' => true,
            'settlement_updates' => true,
            'blog_updates' => false,
            'withdrawal_payment' => true,
            'referral' => true,
            'task_invitation' => true,
            'followed_taskmaster_task' => true,
        ],
        'worker_inapp' => [
            'new_jobs' => true,
            'submission_review' => true,
            'settlement_updates' => true,
            'blog_updates' => true,
            'withdrawal_payment' => true,
            'referral' => true,
            'task_invitation' => true,
            'followed_taskmaster_task' => true,
        ],
        'taskmaster_email' => [
            'job_approval' => true,
            'blog_updates' => false,
            'task_started' => true,
            'task_submitted' => true,
        ],
        'taskmaster_inapp' => [
            'job_approval' => true,
            'blog_updates' => true,
            'task_started' => true,
            'task_submitted' => true,
        ],
    ];

    public function mount()
    {
        $user = Auth::user();
        $settings = $user->notification_settings ?? [];
        if (is_string($settings)) {
            $settings = json_decode($settings, true) ?: [];
        }
        foreach ($this->defaultSettings as $key => $defaults) {
            $this->$key = $settings[$key] ?? $defaults;
        }
    }

    public function saveSettings()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->notification_settings = [
            'worker_email' => $this->worker_email,
            'worker_inapp' => $this->worker_inapp,
            'taskmaster_email' => $this->taskmaster_email,
            'taskmaster_inapp' => $this->taskmaster_inapp,
        ];
        $user->save();
        $this->successMessage = 'Notification settings saved successfully!';
    }

    public function render()
    {
        return view('livewire.dashboard-area.settings.notification-settings');
    }
} 