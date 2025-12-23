<?php

namespace App\Livewire\Tasks;

use App\Models\Support;
use App\Models\Comment;
use App\Models\Trail;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Settlement;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TaskSubmissionDispute extends Component
{
    use WithPagination, WithFileUploads;

    public TaskSubmission $taskSubmission;
    public $task;
    public $dispute;
    // Dispute form properties
    public $disputeMessage = '';
    public $disputeAttachments = [];
    
    // Form properties for creating tickets
    public $subject = '';
    public $description = '';
    public $priority = 'normal';
    public $attachments = [];

    // Escalation properties
    public $selectedStaff = '';
    public $escalationNote = '';

    // Resolution properties
    public $resolution = '';
    public $resolutionDetails = '';
    public $percentToWorker = 0;

    protected $rules = [
        'disputeMessage' => 'required|min:5',
    ];

    protected $messages = [
        'subject.required' => 'Please enter a ticket subject',
        'subject.min' => 'Subject must be at least 5 characters',
        'description.required' => 'Please provide a detailed description',
        'description.min' => 'Description must be at least 20 characters',
        'priority.required' => 'Please select a priority level',
    ];

    public function mount($taskSubmission)
    {
        $this->taskSubmission = $taskSubmission;
        $this->dispute = $this->taskSubmission->dispute;
        $this->task = $this->taskSubmission->task;
    }

    public function submitDisputeResponse()
    {
        $this->validate();

        // Process attachments if any
        $attachmentPaths = [];
        if (!empty($this->disputeAttachments)) {
            $processedAttachments = $this->processAttachments($this->disputeAttachments);
            $attachmentPaths = array_column($processedAttachments, 'path');
        }

        // Create comment
        Comment::create([
            'user_id' => Auth::id(),
            'commentable_type' => 'App\Models\TaskDispute',
            'commentable_id' => $this->taskSubmission->dispute->id,
            'body' => $this->disputeMessage,
            'attachments' => !empty($attachmentPaths) ? $attachmentPaths : null,
        ]);

        // Reset form
        $this->disputeMessage = '';
        $this->disputeAttachments = [];

        session()->flash('success', 'Response added successfully!');
    }

    public function escalateDispute()
    {
        $this->validate([
            'selectedStaff' => 'required|exists:users,id',
            'escalationNote' => 'nullable|string|max:1000',
        ]);

        Trail::create([
            'trailable_id' => $this->dispute->id,
            'trailable_type' => get_class($this->dispute),
            'user_id' => $this->selectedStaff,
            'assigned_by' => Auth::id(),
            'note' => $this->escalationNote,
        ]);

        $staff = User::find($this->selectedStaff);
        Notification::send($staff, new \App\Notifications\Admin\DisputeEscalatedNotification($this->dispute, $this->taskSubmission));

        $this->selectedStaff = '';
        $this->escalationNote = '';

        session()->flash('success', 'Dispute escalated successfully!');
    }

    public function resolveDispute()
    {
        $this->validate([
            'resolution' => 'required|in:full-payment,partial-payment,resubmission,do-nothing',
            'resolutionDetails' => 'required|string|min:10',
            'percentToWorker' => 'required|numeric|min:0|max:100',
        ]);

        // Update the dispute
        $this->dispute->update([
            'resolved_at' => now(),
            'resolution' => $this->resolution,
            'resolution_value' => $this->percentToWorker,
        ]);

        // Create comment with resolution details
        Comment::create([
            'user_id' => Auth::id(),
            'commentable_type' => 'App\Models\TaskDispute',
            'commentable_id' => $this->dispute->id,
            'body' => $this->resolutionDetails,
        ]);

        // Implement the resolution
        if ($this->resolution === 'resubmission') {
            $this->taskSubmission->taskWorker->update(['submission_restricted_at' => null]);
        } elseif (in_array($this->resolution, ['full-payment', 'partial-payment'])) {
            $amount = ($this->percentToWorker / 100) * $this->task->budget_per_submission;

            $wallet = Wallet::firstOrNew([
                'user_id' => $this->taskSubmission->user_id,
                'currency' => $this->task->user->country->currency
            ]);
            if ($wallet) {
                $old_balance = $wallet->balance ?? 0;
                $new_balance = $old_balance + $amount;
                $wallet->balance = $new_balance;
                $wallet->save();
            }

            Settlement::create([
                'user_id' => $this->taskSubmission->user_id,
                'settlementable_id' => $this->taskSubmission->id,
                'settlementable_type' => get_class($this->taskSubmission),
                'amount' => $amount,
                'description' => 'Task Submission Reward',
                'currency' => $this->task->user->country->currency,
                'status' => 'paid'
            ]);

            $this->taskSubmission->accepted = true;
            $this->taskSubmission->reviewed_at = now();
            $this->taskSubmission->reviewed_by = Auth::id();
            $this->taskSubmission->paid_at = now();
            $this->taskSubmission->review_body = $this->resolutionDetails;
            $this->taskSubmission->save();
        } elseif ($this->resolution === 'do-nothing') {
            // do nothing
        }

        // Reset form
        $this->resolution = '';
        $this->resolutionDetails = '';
        $this->percentToWorker = 0;

        session()->flash('success', 'Dispute resolved successfully!');
    }

    private function validateFiles()
    {
        $errors = [];
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt'];
        $maxSize = 5 * 1024 * 1024; // 5MB in bytes

        Log::info('Validating files:', [
            'count' => count($this->attachments),
            'attachments' => $this->attachments
        ]);

        foreach ($this->attachments as $index => $file) {
            Log::info('Processing file:', [
                'index' => $index,
                'file_class' => get_class($file),
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_extension' => $file->getClientOriginalExtension(),
                'file_mime' => $file->getMimeType()
            ]);

            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                // Check file size
                if ($file->getSize() > $maxSize) {
                    $errors[] = "File '{$file->getClientOriginalName()}' exceeds the maximum size of 5MB.";
                }

                // Check file extension
                $extension = strtolower($file->getClientOriginalExtension());
                if (!in_array($extension, $allowedTypes)) {
                    $errors[] = "File '{$file->getClientOriginalName()}' is not a supported file type. Allowed types: " . implode(', ', $allowedTypes);
                }
            } else {
                $errors[] = "File '{$file->getClientOriginalName()}' is not a valid file upload.";
            }
        }

        Log::info('File validation result:', [
            'errors' => $errors
        ]);

        return $errors;
    }

    private function processAttachments($files, $folder = 'dispute-attachments')
    {
        $processedFiles = [];

        foreach ($files as $file) {
            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                // Store the file and get the path
                $path = $file->store($folder, 'public');

                $processedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => 'storage/' . $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'uploaded_at' => now()->toISOString()
                ];
            }
        }

        return $processedFiles;
    }

    public function render()
    {
        $disputeComments = Comment::where('commentable_type', 'App\Models\TaskDispute')
            ->where('commentable_id', $this->taskSubmission->dispute->id)
            ->with('user')
            ->latest()
            ->get();

        return view('livewire.tasks.task-submission-dispute', [
            'disputeComments' => $disputeComments,
            'staff' => $this->getStaff()
        ]);
    }

    private function getStaff()
    {
        return User::whereNotNull('role_id')
            ->where(function($query) {
                $query->whereNull('country_id')
                      ->orWhere('country_id', $this->taskSubmission->user->country_id);
            })
            ->get();
    }
}
