<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Models\Referral;
use App\Models\TaskWorker;
use Livewire\WithFileUploads;
use App\Models\TaskSubmission;
use App\Http\Traits\HelperTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskWorker\TaskInviteNotification;
use App\Notifications\Guest\TaskInviteNonUserNotification;
use App\Notifications\TaskMaster\TaskSubmissionNotification;


class ViewTask extends Component
{
    use WithFileUploads,HelperTrait;

    public Task $task;
    public $taskWorker;
    public $submissionFields = [];
    public $requiredTime = null;
    
    public $submittedData = [];
    public $taskRating = 0;
    public $taskReview = '';

    public $showInviteModal = false;
    public $inviteEmail = '';
    public $inviteSummary = '';

    public function mount($task)
    {
        $this->task = $task->load(['user.country', 'platform', 'template', 'workers']);
        $this->taskWorker = $this->task->workers->firstWhere('user_id', Auth::id());
        
        // Initialize submission fields if they exist in the template
        if ($this->task->template && $this->task->template->submission_fields) {
            $this->submissionFields = $this->task->template->submission_fields;
        }
        
        // Initialize submittedData with existing values
        $this->submittedData = [];
        
        // Load task rating and review if they exist
        if ($this->taskWorker) {
            $this->taskRating = $this->taskWorker->task_rating ?? 0;
            $this->taskReview = $this->taskWorker->task_review ?? '';
        }

        $this->requiredTime = $this->getTimeConversion($this->task->expected_completion_minutes);
        
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

    public function updatedInviteEmail()
    {
        $this->inviteSummary = $this->getInviteSummary($this->inviteEmail);
    }

    private function getInviteSummary($emails)
    {
        $parsed = $this->parseEmails($emails);
        if (empty($parsed)) return '';
        $existing = \App\Models\User::whereIn('email', $parsed)->pluck('email')->toArray();
        $toInvite = array_diff($parsed, $existing);
        $summary = [];
        if (count($existing)) $summary[] = count($existing) . ' user' . (count($existing) > 1 ? 's' : '') . ' will be invited';
        if (count($toInvite)) $summary[] = count($toInvite) . ' ' . (count($toInvite) > 1 ? 'people' : 'person') . ' will be invited to register and do this task';
        return implode(', ', $summary) . '.';
    }

    private function parseEmails($emails)
    {
        $emails = preg_split('/[\s,]+/', $emails);
        $emails = array_filter($emails, function($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });
        return array_unique($emails);
    }

    public function inviteUser()
    {
        $this->validate(['inviteEmail' => 'required']);

        $emails = $this->parseEmails($this->inviteEmail);
        if (empty($emails)) {
            $this->addError('inviteEmail', 'Please enter at least one valid email address.');
            return;
        }

        $unexpiredEmails = Referral::where('task_id', $this->task->id)
            ->whereIn('email', $emails)
            ->where('expire_at', '>', now())
            ->pluck('email')
            ->toArray();

        $emailsToSend = array_diff($emails, $unexpiredEmails);
        $skippedCount = count($unexpiredEmails);

        if (empty($emailsToSend)) {
            $this->inviteSummary = "$skippedCount " . ($skippedCount > 1 ? 'emails' : 'email') . " already have a pending invitation for this task.";
            return;
        }

        $existingUsers = \App\Models\User::whereIn('email', $emailsToSend)->get();
        $existingEmails = $existingUsers->pluck('email')->toArray();
        $toInvite = array_diff($emailsToSend, $existingEmails);

        $expiryDays = (int) (DB::table('settings')->where('name', 'job_invite_expiry')->value('value') ?? 7);
        $expireAt = now()->addDays($expiryDays);

        $invited = 0;
        $registered = 0;

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

    public function startTask()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to start tasks.');
            return;
        }

        // Check if user is banned from taking tasks
        if (Auth::user()->isBannedFromTasks()) {
            session()->flash('error', 'You are currently banned from taking tasks. Please contact support for more information.');
            return;
        }

        // Check if task is still available (not full)
        $acceptedWorkersCount = $this->task->workers->count();
        if ($acceptedWorkersCount >= $this->task->number_of_submissions) {
            session()->flash('error', 'This task is full and cannot be started.');
            return;
        }

        // Check if task has expired
        if ($this->task->expiry_date && $this->task->expiry_date->isPast()) {
            session()->flash('error', 'This task has expired and can no longer be started.');
            return;
        }

        // Create or update the task worker record
        $this->taskWorker = TaskWorker::updateOrCreate(
            ['task_id' => $this->task->id, 'user_id' => Auth::id()]
        );

        session()->flash('message', 'Task started successfully! You can now submit your work.');
        
        // Refresh the component to show updated status
        $this->dispatch('$refresh');
    }

    public function cancelTask()
    {
        if (!Auth::check() || !$this->taskWorker) {
            session()->flash('error', 'You must be logged in and have started the task to cancel it.');
            return;
        }

        // Delete all submissions for this worker
        TaskSubmission::where('task_worker_id', $this->taskWorker->id)->delete();

        // Delete the task worker record
        $this->taskWorker->delete();

        session()->flash('message', 'Task cancelled successfully. All submissions have been deleted.');
        
        // Refresh the component
        $this->dispatch('$refresh');
    }

    public function submitTask()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to submit tasks.');
            return;
        }

        // Check if user has started the task
        if (!$this->taskWorker) {
            session()->flash('error', 'You must start the task before you can submit your work.');
            return;
        }

        // Check if worker has been rejected
        if ($this->taskWorker->rejected_at) {
            session()->flash('error', 'You have been rejected from this task and cannot submit work.');
            return;
        }

        // Check if user is banned from taking tasks
        if (Auth::user()->isBannedFromTasks()) {
            session()->flash('error', 'You are currently banned from taking tasks. Please contact support for more information.');
            return;
        }

        // Check if multiple submissions are allowed
        if (!$this->task->allow_multiple_submissions) {
            $existingSubmission = TaskSubmission::where('task_worker_id', $this->taskWorker->id)->first();
            if ($existingSubmission) {
                session()->flash('error', 'Multiple submissions are not allowed for this task.');
                return;
            }
        }

        $this->validate([
            'submittedData.*' => 'required',
        ]);

        $submissionOutput = [];
        foreach ($this->submissionFields as $field) {
            $fieldName = $field['name'];
            $fieldValue = $this->submittedData[$fieldName] ?? null;
            
            if ($field['type'] === 'file' && $fieldValue instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                // Store the new file and get its path
                $path = $fieldValue->store('submissions', 'public');
                $submissionOutput[$fieldName] = 'storage/' . $path;
            } else {
                $submissionOutput[$fieldName] = $fieldValue;
            }
        }

        // Create task submission record
        TaskSubmission::create([
            'user_id' => Auth::id(),
            'task_id' => $this->task->id,
            'task_worker_id' => $this->taskWorker->id,
            'submissions' => $submissionOutput,
        ]);

        // Send job submission notification to task master
        $this->task->user->notify(new TaskSubmissionNotification($this->task, Auth::user()));

        session()->flash('message', 'Task submitted successfully!');
        return redirect()->route('tasks.applied');
    }

    public function reviewTask()
    {
        $this->validate([
            'taskRating' => 'required|integer|min:1|max:5',
            'taskReview' => 'required|string|min:10',
        ]);

        if (!$this->taskWorker) {
            session()->flash('error', 'You must be a worker on this task to review it.');
            return;
        }

        $this->taskWorker->update([
            'task_rating' => $this->taskRating,
            'task_review' => $this->taskReview,
        ]);

        session()->flash('message', 'Task review submitted successfully!');
        $this->dispatch('$refresh');
    }

    public function setRating($rating)
    {
        $this->taskRating = $rating;
    }

    public function render()
    {
        $submissions = collect();
        if ($this->taskWorker) {
            $submissions = TaskSubmission::where('task_worker_id', $this->taskWorker->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('livewire.tasks.unused.view-task', [
            'submissions' => $submissions,
        ]);
    }
}
