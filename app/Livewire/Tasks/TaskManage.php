<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;
use App\Models\Referral;
use App\Models\Settlement;
use App\Models\TaskWorker;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskWorker\TaskInviteNotification;
use App\Notifications\Guest\TaskInviteNonUserNotification;


class TaskManage extends Component
{
    use WithFileUploads, WithPagination;

    public Task $task;
    public $search;


    public function mount(Task $task)
    {
        $this->task = $task->load([
            'user.country',
            'platform',
            'platformTemplate',
            'promotions',
            'taskSubmissions.task_worker.user'
        ]);
    }

    public function inviteUser()
    {
        $this->validate([
            'inviteEmail' => 'required',
        ]);

        $emails = $this->parseEmails($this->inviteEmail);
        if (empty($emails)) {
            $this->addError('inviteEmail', 'Please enter at least one valid email address.');
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
        
        $this->reset(['inviteEmail']);
        session()->flash('message', 'Processing complete! ' . $this->inviteSummary);
    }

    public function getWorkersQuery()
    {
        return TaskWorker::where('task_id', $this->task->id)
            ->when($this->search, function($query) {
                $query->whereHas('user', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->with('user');
    }

    public function render()
    {
        // Get invitees statistics
        $invitees = Referral::where('task_id', $this->task->id)->get();
        $totalInvitees = $invitees->count();
        $acceptedInvitees = $invitees->where('status', 'accepted')->count();
        $pendingInvitees = $invitees->where('status', 'invited')->count();
        
        $stats = [
            'total_workers' => $this->task->taskWorkers->count(),
            'submissions' => $this->task->taskSubmissions->count(),
            'completed' => $this->task->taskSubmissions->whereNotNull('reviewed_at')->count(),
            'amount_disbursed' => $this->task->taskSubmissions->whereNotNull('paid_at')->sum('task.budget_per_submission'),
            'total_budget' => $this->task->budget_per_submission * $this->task->number_of_submissions,
            'total_invitees' => $totalInvitees,
            'accepted_invitees' => $acceptedInvitees,
            'pending_invitees' => $pendingInvitees
        ];

        $workers = $this->getWorkersQuery()
            ->latest()
            ->paginate(10);

        return view('livewire.tasks.task-manage', [
            'stats' => $stats,
            'workers' => $workers
        ]);
    }

    public function parseEmails($input)
    {
        // Split by comma, semicolon, or whitespace
        $parts = preg_split('/[\s,;]+/', $input);
        $emails = [];
        foreach ($parts as $part) {
            $email = trim($part);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emails[] = strtolower($email);
            }
        }
        return array_unique($emails);
    }
}

