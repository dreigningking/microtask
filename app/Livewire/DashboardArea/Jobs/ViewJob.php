<?php

namespace App\Livewire\DashboardArea\Jobs;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;
use App\Models\Referral;
use App\Models\Settlement;
use App\Models\TaskWorker;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskInviteNotification;
use App\Notifications\TaskInviteNonUserNotification;


class ViewJob extends Component
{
    use WithFileUploads, WithPagination;

    public Task $task;
    public $showInviteModal = false;
    public $showSubmissionModal = false;
    public $showWorkerDetailsModal = false;
    public $showDisburseConfirmModal = false;
    public $selectedWorker = null;
    public $inviteEmail = '';
    public $inviteSummary = '';
    public $search = '';
    public $perPage = 10;

    protected $queryString = ['search'];

    public function mount(Task $task)
    {
        $this->task = $task->load([
            'user.country',
            'platform',
            'template',
            'promotions'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openInviteModal()
    {
        $this->showInviteModal = true;
    }

    public function closeInviteModal()
    {
        $this->showInviteModal = false;
        $this->reset(['inviteEmail', 'inviteSummary']);
    }

    public function viewSubmission($workerId)
    {
        $this->selectedWorker = TaskWorker::with('user')->find($workerId);
        $this->showSubmissionModal = true;
    }

    public function closeSubmissionModal()
    {
        $this->showSubmissionModal = false;
        $this->selectedWorker = null;
    }

    public function viewWorkerDetails($workerId)
    {
        $this->selectedWorker = TaskWorker::with('user')->find($workerId);
        $this->showWorkerDetailsModal = true;
    }

    public function closeWorkerDetailsModal()
    {
        $this->showWorkerDetailsModal = false;
        $this->selectedWorker = null;
    }

    public function confirmDisburse($workerId)
    {
        $this->selectedWorker = TaskWorker::with('user')->find($workerId);
        $this->showDisburseConfirmModal = true;
        
        // Close other modals if they're open
        $this->showSubmissionModal = false;
        $this->showWorkerDetailsModal = false;
    }

    public function closeDisburseConfirmModal()
    {
        $this->showDisburseConfirmModal = false;
        $this->selectedWorker = null;
    }

    public function disbursePayment($workerId)
    {
        $worker = TaskWorker::with('user')->find($workerId);
        
        if ($worker && $worker->submitted_at && !$worker->paid_at) {
            // Create settlement record
            $settlement = Settlement::create([
                'user_id' => $worker->user_id,
                'settlementable_id' => $this->task->id,
                'settlementable_type' => get_class($this->task),
                'amount' => $this->task->budget_per_person,
                'currency' => $this->task->user->country->currency,
                'status' => 'pending'
            ]);

            // Mark as paid
            $worker->paid_at = now();
            $worker->save();
            
            // TODO: Implement actual payment processing logic here
            
            $this->closeDisburseConfirmModal();
            session()->flash('message', 'Payment disbursed successfully!');
        }
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
        $unexpiredEmails = \App\Models\Referral::where('task_id', $this->task->id)
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
            \App\Models\Referral::create([
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
        $stats = [
            'total_workers' => $this->task->workers->count(),
            'submissions' => $this->task->workers->whereNotNull('submitted_at')->count(),
            'completed' => $this->task->workers->whereNotNull('completed_at')->count(),
            'amount_disbursed' => $this->task->workers->whereNotNull('paid_at')->sum('task.budget_per_person'),
            'total_budget' => $this->task->budget_per_person * $this->task->number_of_people
        ];

        $workers = $this->getWorkersQuery()
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.dashboard-area.jobs.view-job', [
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

