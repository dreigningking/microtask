<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Models\Settlement;
use App\Models\TaskSubmission;
use App\Models\TaskWorker;
use App\Models\Wallet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class TaskSubmissionReview extends Component
{
    public $task;
    public $showSubmissionModal = false;
    public $showWorkerDetailsModal = false;
    public $showDisburseConfirmModal = false;
    public $selectedWorker = null;
    public $selectedSubmission = null;
    public $password;

    // Review form properties
    public $reviewText = '';
    public $preventFurtherSubmissions = false;

    protected $listeners = [
        'submissionClicked' => 'displaySubmissionData',
    ];


    public function displaySubmissionData($submissionId)
    {
        $this->selectedSubmission = TaskSubmission::find($submissionId);
        if ($this->selectedSubmission) {
            $this->selectedWorker = $this->selectedSubmission->taskWorker;
            $this->task = $this->selectedSubmission->task;
        }
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

    public function viewSubmissionDetails($submissionId)
    {
        $this->selectedSubmission = $this->task->taskSubmissions()->with('taskWorker.user')->find($submissionId);
        $this->reset(['reviewReason', 'reviewText']);
        $this->dispatch('openSubmissionDetailsModal');
    }

    public function closeSubmissionDetailsModal()
    {
        $this->selectedSubmission = null;
        $this->reset(['reviewReason', 'reviewText']);
        session()->forget('message');
        $this->dispatch('closeSubmissionDetailsModal');
    }

    public function approveSubmission()
    {
        $this->validate([
            'reviewText' => 'nullable|string|min:10',
            'password' => 'required',
        ]);

        // Check if password matches current user's password
        if (!Hash::check($this->password, Auth::user()->password)) {
            $this->addError('password', 'The password is incorrect.');
            return;
        }

        if ($this->selectedSubmission) {
            
            $wallet = Wallet::firstOrNew(
                [
                    'user_id' => $this->selectedSubmission->user_id,
                    'currency' => $this->task->user->country->currency
                ]
            );
            if ($wallet) {
                $old_balance = $wallet->balance ?? 0;
                $new_balance = $old_balance + $this->task->budget_per_submission;
                $wallet->balance = $new_balance;
                $wallet->save();
            }
            Settlement::create([
                'user_id' => $this->selectedSubmission->user_id,
                'settlementable_id' => $this->selectedSubmission->id,
                'settlementable_type' => get_class($this->selectedSubmission),
                'amount' => $this->task->budget_per_submission,
                'description' => 'Task Submission Reward',
                'currency' => $this->task->user->country->currency,
                'status' => 'paid'
            ]);
            $this->selectedSubmission->accepted = true;
            $this->selectedSubmission->reviewed_at = now();
            $this->selectedSubmission->paid_at = now();
            $this->selectedSubmission->review_body = $this->reviewText;
            $this->selectedSubmission->save();

            // Reset form
            $this->reset(['reviewText', 'password']);

            // Refresh the submission data
            $this->selectedSubmission->refresh();

            $this->redirectRoute('tasks.manage', ['task' => $this->selectedSubmission->task]);
        }
    }

    public function rejectSubmission()
    {
        $this->validate([
            'reviewText' => 'required|string|min:10',
        ]);

        if ($this->selectedSubmission) {
            $this->selectedSubmission->update([
                'accepted' => false,
                'reviewed_at' => now(),
                'review_body' => $this->reviewText,
            ]);

            // If prevent further submissions, restrict the worker
            if ($this->preventFurtherSubmissions) {
                $this->selectedSubmission->taskWorker->update([
                    'submission_restricted_at' => now(),
                ]);
            }

            // Reset form
            $this->reset(['reviewText', 'preventFurtherSubmissions']);

            // Refresh the submission data
            $this->selectedSubmission->refresh();

            $this->redirectRoute('tasks.manage', ['task' => $this->selectedSubmission->task]);
        }
    }

    public function render()
    {
        return view('livewire.tasks.task-submission-review');
    }
}
