<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Referral;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskWorker\TaskInviteNotification;
use App\Notifications\Guest\TaskInviteNonUserNotification;
use Illuminate\Support\Facades\DB;

class TaskInvitation extends Component
{
    public Task $task;
    public $emails = [''];
    public $inviteSummary = null;
    public $totalInvitees = 0;
    public $accepted_invitees = 0;
    public $pending_invitees = 0;

    protected $rules = [
        'emails.*' => 'nullable|email',
    ];

    protected $messages = [
        'emails.*.email' => 'Please enter a valid email address.',
    ];

    public function mount($task) {
        $this->task = $task;
        $this->loadStats();
    }

    public function loadStats()
    {
        $invitees = Referral::where('task_id', $this->task->id)->get();
        $this->totalInvitees = $invitees->count();
        $this->accepted_invitees = $invitees->where('status', 'accepted')->count();
        $this->pending_invitees = $invitees->where('status', 'invited')->count();
    }

    public function addEmailField()
    {
        $this->emails[] = '';
    }

    public function removeEmailField($index)
    {
        if (count($this->emails) > 1) {
            unset($this->emails[$index]);
            $this->emails = array_values($this->emails);
        }
    }

    public function updatedEmails()
    {
        $this->resetValidation();
    }

    public function inviteUsers()
    {
        $this->validate();

        // Filter out empty emails
        $emails = array_filter($this->emails, function($email) {
            return !empty(trim($email));
        });

        if (empty($emails)) {
            $this->addError('emails', 'Please enter at least one email address.');
            return;
        }

        // Check for existing, unexpired invitations for this specific task
        $unexpiredEmails = Referral::where('task_id', $this->task->id)
            ->whereIn('email', $emails)
            ->where('expire_at', '>', now())
            ->pluck('email')
            ->toArray();

        $emailsToSend = array_diff($emails, $unexpiredEmails);
        $skippedCount = count($unexpiredEmails);

        if (empty($emailsToSend)) {
            $this->inviteSummary = "$skippedCount " . ($skippedCount > 1 ? 'emails' : 'email') . " already have a pending invitation for this task. No new invitations were sent.";
            return;
        }

        $existingUsers = User::whereIn('email', $emailsToSend)->get();
        $existingEmails = $existingUsers->pluck('email')->toArray();
        $toInvite = array_diff($emailsToSend, $existingEmails);

        $expiryDays = (int) (DB::table('settings')->where('name', 'job_invite_expiry')->value('value') ?? 7);
        $expireAt = now()->addDays($expiryDays);

        $invited = 0;
        $registered = 0;

        // Notify existing users
        foreach ($existingUsers as $user) {
            Referral::create([
                'referrer_id' => Auth::id(),
                'email' => $user->email,
                'task_id' => $this->task->id,
                'status' => 'invited',
                'expire_at' => $expireAt,
            ]);
            $user->notify(new TaskInviteNotification($this->task));
            $invited++;
        }

        // Notify non-users
        foreach ($toInvite as $email) {
            Referral::create([
                'referrer_id' => Auth::id(),
                'email' => $email,
                'task_id' => $this->task->id,
                'status' => 'invited',
                'expire_at' => $expireAt,
            ]);
            Notification::route('mail', $email)
                ->notify(new TaskInviteNonUserNotification($this->task, $email));
            $registered++;
        }

        $summary = [];
        if ($invited) $summary[] = "$invited user" . ($invited > 1 ? 's' : '') . " invited";
        if ($registered) $summary[] = "$registered " . ($registered > 1 ? 'people' : 'person') . " invited to register";
        if ($skippedCount) $summary[] = "$skippedCount " . ($skippedCount > 1 ? 'emails were' : 'email was') . " skipped (already invited)";

        $this->inviteSummary = !empty($summary) ? implode(', ', $summary) . '.' : 'No new invitations sent.';

        // Reset form and reload stats
        $this->emails = [''];
        $this->loadStats();

        session()->flash('message', 'Processing complete! ' . $this->inviteSummary);
    }

    public function render()
    {
        $existingInvitations = Referral::where('task_id', $this->task->id)
            ->with('invitee')
            ->latest()
            ->get();

        return view('livewire.tasks.task-invitation', [
            'existingInvitations' => $existingInvitations
        ]);
    }
}

