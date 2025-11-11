<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Models\Settlement;
use App\Models\TaskWorker;


class TaskSubmissionReview extends Component
{
    public Task $task;
    public $showSubmissionModal = false;
    public $showWorkerDetailsModal = false;
    public $showDisburseConfirmModal = false;
    public $selectedWorker = null;
    public $selectedSubmission = null;

    protected $listeners = [
        'submissionClicked' => 'displaySubmissionData',
    ];


    public function displaySubmissionData(){

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
        $this->selectedSubmission = $this->task->taskSubmissions()->with('task_worker.user')->find($submissionId);
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

    public function reviewSubmission()
    {
        $this->validate([
            'reviewReason' => 'required|in:1,2,3',
            'reviewText' => 'required|string|min:10',
        ]);

        if ($this->selectedSubmission) {
            $this->selectedSubmission->update([
                'review' => $this->reviewText,
                'review_reason' => $this->reviewReason,
                'reviewed_at' => now(),
            ]);

            // Handle different review decisions
            switch ($this->reviewReason) {
                case 1: // Approved
                    $this->selectedSubmission->update([
                        'reviewed_at' => now(),
                    ]);
                    $message = 'Submission approved successfully!';
                    break;
                case 2: // Needs Revision
                    $message = 'Submission marked for revision.';
                    break;
                case 3: // Rejected
                    $message = 'Submission rejected.';
                    break;
                default:
                    $message = 'Submission reviewed successfully!';
            }

            // Reset form
            $this->reset(['reviewReason', 'reviewText']);
            
            // Refresh the submission data
            $this->selectedSubmission->refresh();
            
            session()->flash('message', $message);
        }
    }

    public function resetSubmissionForRevision($submissionId)
    {
        $submission = $this->task->taskSubmissions()->find($submissionId);
        
        if ($submission && $submission->review_reason == 2) {
            // Reset the submission for revision
            $submission->update([
                'reviewed_at' => null,
                'review' => null,
                'review_reason' => null,
                'completed_at' => null,
            ]);
            
            // Refresh the submission data
            $this->selectedSubmission->refresh();
            
            session()->flash('message', 'Submission reset for revision. Worker can now resubmit their work.');
        }
    }

    public function disbursePayment($workerId)
    {
        $worker = TaskWorker::with('user')->find($workerId);
        
        // Check if worker has completed submissions
        $completedSubmission = $worker->taskSubmissions()->whereNotNull('reviewed_at')->whereNull('paid_at')->first();
        
        if ($worker && $completedSubmission) {
            // Create settlement record
            $settlement = Settlement::create([
                'user_id' => $worker->user_id,
                'settlementable_id' => $this->task->id,
                'settlementable_type' => get_class($this->task),
                'amount' => $this->task->budget_per_submission,
                'currency' => $this->task->user->country->currency,
                'status' => 'pending'
            ]);

            // Mark submission as paid
            $completedSubmission->paid_at = now();
            $completedSubmission->save();
            
            // TODO: Implement actual payment processing logic here
            
            $this->closeDisburseConfirmModal();
            session()->flash('message', 'Payment disbursed successfully!');
        }
    }

    public function disbursePaymentFromSubmission($submissionId)
    {
        $submission = $this->task->taskSubmissions()->find($submissionId);
        
        if ($submission && $submission->reviewed_at && !$submission->paid_at) {
            $worker = $submission->task_worker;
            
            if ($worker) {
                // Create settlement record
                $settlement = Settlement::create([
                    'user_id' => $worker->user_id,
                    'settlementable_id' => $this->task->id,
                    'settlementable_type' => get_class($this->task),
                    'amount' => $this->task->budget_per_submission,
                    'currency' => $this->task->user->country->currency,
                    'status' => 'pending'
                ]);

                // Mark submission as paid
                $submission->paid_at = now();
                $submission->save();
                
                // TODO: Implement actual payment processing logic here
                
                // Refresh the submission data
                $this->selectedSubmission->refresh();
                
                session()->flash('message', 'Payment disbursed successfully!');
            }
        }
    }

    public function render()
    {
        return view('livewire.tasks.task-submission-review');
    }
}
