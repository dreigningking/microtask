<?php

namespace App\Livewire\DashboardArea\Tasks;

use App\Http\Traits\HelperTrait;
use App\Models\Referral;
use App\Notifications\TaskInviteNonUserNotification;
use App\Notifications\TaskInviteNotification;
use App\Notifications\JobSubmissionNotification;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use App\Models\TaskWorker;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class ViewTask extends Component
{
    use WithFileUploads,HelperTrait;

    public Task $task;
    public $taskWorker;
    public $submissionFields = [];
    public $requiredTime = null;
    
    public $submittedData = [];

    public $showInviteModal = false;
    public $inviteEmail = '';
    public $inviteSummary = '';

    public function mount($task)
    {
        $this->task = $task->load(['user.country', 'platform', 'template', 'workers']);
        $this->taskWorker = $this->task->workers->firstWhere('user_id', auth()->id());
        
        // Initialize submission fields if they exist in the template
        if ($this->task->template && $this->task->template->submission_fields) {
            $this->submissionFields = $this->task->template->submission_fields;
        }
        
        // Initialize submittedData with existing values
        $this->submittedData = [];
        if ($this->taskWorker && $this->taskWorker->submissions) {
            foreach ($this->submissionFields as $field) {
                $fieldName = $field['name'];
                //dd($this->taskWorker->submissions[$fieldName]);
                if (isset($this->taskWorker->submissions[$fieldName])) {
                    $this->submittedData[$fieldName] = $this->taskWorker->submissions[$fieldName];
                }
            }
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
                'referrer_id' => auth()->id(),
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
                'referrer_id' => auth()->id(),
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

    public function submitTask()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to submit tasks.');
            return;
        }

        // Check if user is banned from taking tasks
        if (Auth::user()->isBannedFromTasks()) {
            session()->flash('error', 'You are currently banned from taking tasks. Please contact support for more information.');
            return;
        }

        // Check if user can submit tasks based on subscription limits
        if (!Auth::user()->canSubmitTask()) {
            session()->flash('error', 'You have reached your hourly submission limit or do not have an active worker subscription.');
            return;
        }

        $this->validate([
            'submittedData.*' => 'required',
        ]);

        $submissionOutput = [];
        foreach ($this->submissionFields as $field) {
            $fieldName = $field['name'];
            $fieldValue = $this->submittedData[$fieldName] ?? null;
            
            if ($field['type'] === 'file' && $fieldValue instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                // Delete old file if it exists
                if (isset($this->taskWorker->submissions[$fieldName])) {
                    $oldPath = str_replace('storage/', '', $this->taskWorker->submissions[$fieldName]);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                
                // Store the new file and get its path
                $path = $fieldValue->store('submissions', 'public');
                $submissionOutput[$fieldName] = 'storage/' . $path;
            } elseif (isset($this->taskWorker->submissions[$fieldName])) {
                // Keep the existing file if no new file was uploaded
                $submissionOutput[$fieldName] = $this->taskWorker->submissions[$fieldName];
            } else {
                $submissionOutput[$fieldName] = $fieldValue;
            }
        }

        // Ensure all field keys are present in the output
        foreach ($this->submissionFields as $field) {
            if (!isset($submissionOutput[$field['name']])) {
                $submissionOutput[$field['name']] = null;
            }
        }

        $this->taskWorker->submissions = $submissionOutput;
        $this->taskWorker->submitted_at = now();
        $this->taskWorker->save();

        // Send job submission notification to task master
        $this->task->user->notify(new JobSubmissionNotification($this->task, Auth::user()));

        session()->flash('message', 'Task submitted successfully!');
        return redirect()->route('tasks.index');
    }

    public function render()
    {
        return view('livewire.tasks.view-task', [
            'existingSubmissions' => $this->taskWorker ? $this->taskWorker->submissions : [],
        ]);
    }
}
