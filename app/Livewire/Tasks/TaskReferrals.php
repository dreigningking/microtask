<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Referral;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskWorker\TaskReferralNotification;

class TaskReferrals extends Component
{
    public Task $task;
    public $emails = [''];
    public $referralSummary = null;
    public $totalReferrals = 0;
    public $completed_referrals = 0;
    public $pending_referrals = 0;

    protected $rules = [
        'emails.*' => 'nullable|email|exists:users,email',
    ];

    protected $messages = [
        'emails.*.email' => 'Please enter a valid email address.',
        'emails.*.exists' => 'User not found.',
    ];

    public function mount($task) {
        $this->task = $task;
        $this->loadStats();
    }

    public function loadStats()
    {
        $referrals = Referral::where('task_id', $this->task->id)->get();
        $this->totalReferrals = $referrals->count();
        $this->completed_referrals = $referrals->where('status', 'completed')->count();
        $this->pending_referrals = $referrals->where('status', 'pending')->count();
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

    public function referUsers()
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

        $existingUsers = User::whereIn('email', $emails)->get();
        $existingUserIds = $existingUsers->pluck('id')->toArray();

        
        // For existing users, check if already referred or already applied
        $alreadyReferred = Referral::where('task_id', $this->task->id)
            ->where('user_id', Auth::id())
            ->whereIn('referree_id', $existingUserIds)
            ->pluck('referree_id')
            ->toArray();
        $alreadyReferredCount = count($alreadyReferred);

        $alreadyApplied = \App\Models\TaskWorker::where('task_id', $this->task->id)
            ->whereIn('user_id', $existingUserIds)
            ->pluck('user_id')
            ->toArray();
        $alreadyAppliedCount = count($alreadyApplied);

        // Users to refer: existing, not referred, not applied
        $usersToReferIds = array_diff($existingUserIds, $alreadyReferred, $alreadyApplied);
        $referredCount = count($usersToReferIds);

        // Create referrals for valid users
        foreach ($usersToReferIds as $userId) {
            
            Referral::create([
                'user_id' => Auth::id(),
                'referree_id' => $userId,
                'task_id' => $this->task->id,
                'status' => 'pending',
            ]);
            $user = $existingUsers->find($userId);
            if ($user) {
                $user->notify(new TaskReferralNotification($this->task));
            }
        }

        // Build summary
        $summary = [];
        if ($referredCount > 0) $summary[] = "$referredCount user" . ($referredCount > 1 ? 's' : '') . " referred";
        if ($alreadyReferredCount > 0) $summary[] = "$alreadyReferredCount user" . ($alreadyReferredCount > 1 ? 's' : '') . " already referred";
        if ($alreadyAppliedCount > 0) $summary[] = "$alreadyAppliedCount user" . ($alreadyAppliedCount > 1 ? 's' : '') . " already applied for task";
        
        $this->referralSummary = implode(', ', $summary) . '.';

        // Reset form and reload stats
        $this->emails = [''];
        $this->loadStats();

        session()->flash('message', 'Processing complete! ' . $this->referralSummary);
    }

    public function render()
    {
        $existingReferrals = Referral::where('task_id', $this->task->id)
            ->where('user_id', Auth::id())
            ->with('referree')
            ->latest()
            ->get();

        return view('livewire.tasks.task-referrals', [
            'existingReferrals' => $existingReferrals
        ]);
    }
}

