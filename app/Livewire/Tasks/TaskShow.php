<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Moderation;
use Livewire\Component;
use App\Models\TaskWorker;
use App\Models\TaskDispute;
use Livewire\WithFileUploads;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;
use App\Http\Traits\HelperTrait;
use App\Models\Trail;

class TaskShow extends Component
{
    use GeoLocationTrait, WithFileUploads,HelperTrait;

    public Task $task;
    public $agreementAccepted = false;
    public $isSaved = false;
    public $hasStarted = false;
    public $countryId;
    public $canStartOrSave = true;
    public $user;
    public $userReported = false;

    // Dispute
    public $disputeSubmissionId = null;
    public $disputeReason = '';
    public $desiredOutcome = '';
    public $disputeFiles = [];

    
    // Availability tracking
    public $isTaskAvailable = false;
    public $unavailableReasons = [];
    
    // User state tracking
    public $userTaskWorker = null;
    public $userSubmissions;
    public $userSubmissionCount = 0;
    public $hasUserSubmitted = false;
    public $cannotSubmitReason = '';
    
    // Report functionality
    public $reportReason = '';

    // Moderation functionality
    public $rejectNotes = '';

    
    // Comments functionality
    public $question = '';
    public $comments;
    public $similarQuestions = [];

    // Submission functionality
    public $submissionData = [];
    public $submissionFiles = [];
    public $submissionFields = [];

    public function mount(Task $task)
    {
        /** @var \App\Models\User $user **/
        $this->user = Auth::user();
        $this->task = $task->load(['user.country', 'platform', 'platformTemplate', 'taskWorkers','latestModeration']);
        $this->submissionFields = $this->task->platformTemplate->submission_fields ?? [];
        if (Auth::check()) {
            $this->countryId = Auth::user()->country_id;
        } else {
            $location = $this->getLocation();
            $this->countryId = $location ? $location->country_id : null;
        }

        // Load comments
        $this->loadComments();

        // Check task availability first
        $this->isTaskAvailable = $this->task->available;
        if (!$this->isTaskAvailable) {
            $this->unavailableReasons = $this->getUnavailabilityReasons();
        }


        // Load user-specific data if logged in
        if (Auth::check()) {
            $this->loadUserState();

            // Check for blocklist issues (this would make task unavailable)
            $currentUser = Auth::user();
            $userBlockedCreator = $currentUser->blockedUsers->where('id', $this->task->user_id)->isNotEmpty();

            $creatorBlockedUser = $this->task->user->blockedUsers->where('id', $currentUser->id)->isNotEmpty();

            if($userBlockedCreator || $creatorBlockedUser) {
                if (!$this->isTaskAvailable) {
                    $this->unavailableReasons[] = 'You cannot view this task due to blocklist restrictions.';
                }
            }

            // Check if user has reported this task
            $this->userReported = $this->task->comments()
                ->where('is_flag', true)
                ->where('user_id', $currentUser->id)
                ->exists();

            // If user has reported the task, they cannot apply or submit
            if ($this->userReported && $this->isTaskAvailable) {
                $this->unavailableReasons[] = 'You have reported this task and cannot apply or submit work.';
                $this->isTaskAvailable = false;
            }
        }
    }
    
    /**
     * Load user's task-related state
     */
    public function loadUserState()
    {
        if (!$this->user) {
            return;
        }
        // Check if user has applied for this task
        $this->userTaskWorker = TaskWorker::where('task_id', $this->task->id)
            ->where('user_id', $this->user->id)
            ->first();

        $this->hasStarted = $this->userTaskWorker !== null;

        // Load user's submissions for this task
        $this->userSubmissions = $this->task->taskSubmissions()
            ->where('user_id', $this->user->id)
            ->get();

        $this->userSubmissionCount = $this->userSubmissions->count();
        $this->hasUserSubmitted = $this->userSubmissionCount > 0;

        // Collect reasons why user cannot submit
        $cannotSubmitReasons = [];

        if (!$this->task->allow_multiple_submissions && $this->hasUserSubmitted) {
            $cannotSubmitReasons[] = 'Only one submission is allowed for this task.';
        }

        if ($this->userTaskWorker && $this->userTaskWorker->submission_restricted_at) {
            $cannotSubmitReasons[] = 'Your submissions are restricted for this task.';
        }

        $submitTaskReason = $this->canSubmitTask($this->task);
        if ($submitTaskReason) {
            $cannotSubmitReasons[] = $submitTaskReason;
        }

        $this->cannotSubmitReason = $cannotSubmitReasons[0] ?? '';
    }

    /**
     * Load comments for this task
     */
    private function loadComments()
    {
        $this->comments = $this->task->comments()->where('is_flag', false)->whereNull('parent_id')->with(['user', 'children' => function($q) { $q->with('user')->orderBy('created_at'); }])->orderBy('created_at', 'desc')->get();
    }
    
    /**
     * Get reasons why task is unavailable
     */
    public function getUnavailabilityReasons(): array
    {
        $reasons = [];
        if (!$this->task->is_active) {
            $reasons[] = 'Task is not active';
        }
        
        if (!$this->task->latestModeration || $this->task->latestModeration->status !== 'approved') {
            $reasons[] = 'Task is not approved';
        }
        
        if ($this->task->expiry_date && $this->task->expiry_date->isPast()) {
            $reasons[] = 'Task has expired';
        }
        
        // Check completion status
        if ($this->task->completed_at !== null) {
            $reasons[] = 'Task has been completed (all required submissions received)';
        }
        
        // Check if user is banned
        if ($this->user && $this->user->isBannedFromTasks()) {
            $reasons[] = 'You are currently banned from taking tasks';
        }
        
        return $reasons;
    }

    public function startTask()
    {

        if (!$this->user) {
            session()->flash('error', 'You must be logged in to start tasks.');
            return;
        }

        if (!$this->agreementAccepted) {
            session()->flash('error', 'You must accept the terms to start the task.');
            return;
        }

        if ($this->task->completed_at !== null) {
            session()->flash('error', 'This task is full and cannot be started.');
            return;
        }

        if ($this->task->expiry_date && $this->task->expiry_date->isPast()) {
            session()->flash('error', 'This task has expired and can no longer be started.');
            return;
        }

        // Check if user is banned from taking tasks
        
        if ($this->user->isBannedFromTasks()) {
            session()->flash('error', 'You are currently banned from taking tasks. Please contact support for more information.');
            return;
        }

        // Check if user can take tasks based on subscription limits
        $cannotTakeReason = $this->canTakeTask();
        if ($cannotTakeReason) {
            session()->flash('error', 'You cannot start this task: ' . $cannotTakeReason);
            return;
        }

        $worker = TaskWorker::firstOrCreate(
            ['task_id' => $this->task->id, 'user_id' => Auth::id()]
        );
        session()->flash('success', 'Tasks Started.');
        
        // Refresh user state to show the Submit Your Work section
        $this->loadUserState();
    }

    public function submitReport()
    {
        $this->validate([
            'reportReason' => 'required|min:10|max:1000'
        ]);

        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to report tasks.');
            return;
        }

        // Check if user has already reported this task
        $existingReport = $this->task->comments()
            ->where('is_flag', true)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($existingReport) {
            session()->flash('error', 'You have already reported this task.');
            return;
        }

        // Create a flagged comment with the user's reason
        Comment::create([
            'user_id' => Auth::id(),
            'commentable_id' => $this->task->id,
            'commentable_type' => Task::class,
            'body' => $this->reportReason,
            'is_flag' => true,
        ]);

        // Update user reported status
        $this->userReported = true;
        
        // Clear the form
        $this->reportReason = '';
        
        // Refresh user state to apply restrictions
        $this->loadUserState();

        session()->flash('success', 'Task has been reported to admins for review.');
    }
    
    public function withdrawSubmission($submissionId)
    {
        if (!$this->user) {
            session()->flash('error', 'You must be logged in to withdraw submissions.');
            return;
        }


        $submission = TaskSubmission::where('id', $submissionId)
            ->where('user_id', $this->user->id)
            ->where('task_id', $this->task->id)
            ->where('accepted', false)
            ->first();

        if (!$submission) {
            session()->flash('error', 'Submission not found or cannot be withdrawn.');
            return;
        }

        // Delete the submission (since it can't be edited)
        $submission->delete();

        session()->flash('success', 'Submission withdrawn successfully.');

        // Refresh user state
        $this->loadUserState();
    }

    public function updatedQuestion()
    {
        if (strlen($this->question) > 3) {
            $this->similarQuestions = Comment::where('commentable_id', $this->task->id)
                ->where('commentable_type', Task::class)
                ->where('is_flag', false)
                ->where('body', 'like', '%' . $this->question . '%')
                ->with('user')
                ->limit(5)
                ->get();
        } else {
            $this->similarQuestions = [];
        }
    }

    public function askQuestion()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to ask questions.');
            return;
        }

        $this->validate([
            'question' => 'required|min:10|max:1000'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'commentable_id' => $this->task->id,
            'commentable_type' => Task::class,
            'body' => $this->question,
            'is_flag' => false,
        ]);

        session()->flash('success', 'Your question has been submitted successfully.');

        $this->question = '';
        $this->similarQuestions = [];
        $this->loadComments();
    }

    public function submitWork()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to submit work.');
            return;
        }

        // Check 1: task is available
        if (!$this->task->available) {
            session()->flash('error', 'This task is not available for submission.');
            return;
        }

        // Check 2: if user has submitted this task before and task allows multiple submissions
        $hasSubmittedBefore = $this->userSubmissions->isNotEmpty();
        if ($hasSubmittedBefore && !$this->task->allow_multiple_submissions) {
            session()->flash('error', 'You have already submitted for this task and multiple submissions are not allowed.');
            return;
        }

        // Check 3: if user can submit task
        $cannotSubmitReason = $this->canSubmitTask($this->task);
        if ($cannotSubmitReason) {
            session()->flash('error', 'You are not allowed to submit at this time: ' . $cannotSubmitReason);
            return;
        }

        // Validate submission fields
        $rules = [];
        foreach ($this->submissionFields as $field) {
            if ($field['type'] === 'file') {
                $key = 'submissionFiles.' . $field['slug'];
                $rules[$key] = $field['required'] ? 'required|file' : 'nullable|file';
            } else {
                $key = 'submissionData.' . $field['slug'];
                $rule = $field['required'] ? 'required' : '';
                if ($field['type'] === 'url') {
                    $rule .= ($rule ? '|' : '') . 'url';
                } elseif ($field['type'] === 'number') {
                    $rule .= ($rule ? '|' : '') . 'numeric';
                }
                if ($rule) {
                    $rules[$key] = $rule;
                }
            }
        }

        $this->validate($rules);

        // Handle files and prepare submission details
        $submissionDetails = [];
        foreach ($this->submissionFields as $field) {
            $fieldData = $field; // Copy the field structure
            if ($field['type'] === 'file') {
                if (isset($this->submissionFiles[$field['slug']])) {
                    $file = $this->submissionFiles[$field['slug']];
                    $path = $file->store('submissions', 'public');
                    $fieldData['value'] = $path;
                } else {
                    $fieldData['value'] = null;
                }
            } else {
                $fieldData['value'] = $this->submissionData[$field['slug']] ?? null;
            }
            $submissionDetails[] = $fieldData;
        }

        // Create submission
        TaskSubmission::create([
            'user_id' => Auth::id(),
            'task_id' => $this->task->id,
            'task_worker_id' => $this->userTaskWorker->id,
            'submission_details' => $submissionDetails,
        ]);

        session()->flash('success', 'Your work has been submitted successfully.');

        // Reset form
        $this->submissionData = [];
        $this->submissionFiles = [];

        // Refresh user state
        $this->loadUserState();
    }

    /**
     * Check if user can take tasks based on subscription limits
     */
    public function canTakeTask(): ?string
    {
        // Check if banned
        if ($this->user->isBannedFromTasks()) {
            return 'You are currently banned from taking tasks.';
        }

        // Obtain variables from database settings
        $taskApplicationLimitPerDaySetting = Setting::where('name', 'task_application_limit_per_day')->first();
        $taskApplicationLimitPerDay = $taskApplicationLimitPerDaySetting ? (int) $taskApplicationLimitPerDaySetting->value : 10;

        $maximumTasksAtHandSetting = Setting::where('name', 'maximum_tasks_at_hand')->first();
        $maximumTasksAtHand = $maximumTasksAtHandSetting ? (int) $maximumTasksAtHandSetting->value : 5;

        // Get active subscriptions
        $activeSubscriptions = $this->user->activeSubscriptions();

        // Initialize multipliers
        $taskLimitMultiplier = 1;
        $taskVolumeMultiplier = 1;

        // Check for task-limit-booster subscription
        $taskLimitBoosterSub = $activeSubscriptions->whereHas('booster', function($q) {
            $q->where('slug', 'task-limit-booster');
        })->first();
        if ($taskLimitBoosterSub) {
            $taskLimitMultiplier = $taskLimitBoosterSub->multiplier ?? 1;
        }

        // Check for task-volume-booster subscription
        $taskVolumeBoosterSub = $activeSubscriptions->whereHas('booster', function($q) {
            $q->where('slug', 'task-volume-booster');
        })->first();
        if ($taskVolumeBoosterSub) {
            $taskVolumeMultiplier = $taskVolumeBoosterSub->multiplier ?? 1;
        }

        // Apply multipliers
        $taskApplicationLimitPerDay *= $taskLimitMultiplier;
        $maximumTasksAtHand *= $taskVolumeMultiplier;

        // Check number of tasks applied for today
        $appliedToday = $this->user->taskWorkers()->whereDate('created_at', today())->count();
        if ($appliedToday >= $taskApplicationLimitPerDay) {
            return "You have reached your daily task application limit of {$taskApplicationLimitPerDay}.";
        }

        // Check number of tasks applied for and not submitted
        $tasksAtHand = $this->user->taskWorkers()
            ->whereDoesntHave('taskSubmissions', function($q) {
                $q->whereNotNull('accepted');
            })
            ->count();
        if ($tasksAtHand >= $maximumTasksAtHand) {
            return "You have reached your maximum tasks at hand limit of {$maximumTasksAtHand}.";
        }

        return null;
    }

    /**
     * Check if user can submit tasks based on subscription limits
     */
    public function canSubmitTask(Task $task): ?string
    {
        // Check if banned
        if ($this->user->isBannedFromTasks()) {
            return 'You are currently banned from taking tasks.';
        }

        // Obtain multiple_submission_interval_minutes from settings
        $intervalSetting = Setting::where('name', 'multiple_submission_interval_minutes')->first();
        $interval = $intervalSetting ? (int) $intervalSetting->value : 60;

        // Check if user has not submitted this task before
        $lastSubmission = $this->user->taskSubmissions()->where('task_id', $task->id)->latest('created_at')->first();
        if ($lastSubmission) {
            // If submitted before, check if difference between created_at and now is more than interval minutes
            $diffMinutes = $lastSubmission->created_at->diffInMinutes(now());
            if ($diffMinutes <= $interval) {
                return "You must wait {$interval} minutes between submissions for this task.";
            }
        }

        return null;
    }

    public function openDispute($submissionId){
        $this->disputeSubmissionId = $submissionId;
        $this->disputeReason = '';
        $this->desiredOutcome = '';
        $this->disputeFiles = [];
    }

    public function submitDispute(){
        $this->validate([
            'disputeReason' => 'required|string|min:10',
            'desiredOutcome' => 'nullable|string',
            'disputeFiles.*' => 'nullable|file|max:10240', // 10MB max per file
        ]);

        if (!$this->user) {
            session()->flash('error', 'You must be logged in to submit a dispute.');
            return;
        }

        $submission = TaskSubmission::find($this->disputeSubmissionId);
        if (!$submission || $submission->user_id !== $this->user->id) {
            session()->flash('error', 'Submission not found or access denied.');
            return;
        }

        // Handle file uploads
        $uploadedFiles = [];
        if ($this->disputeFiles) {
            foreach ($this->disputeFiles as $file) {
                $path = $file->store('disputes', 'public');
                $uploadedFiles[] = $path;
            }
        }
        $dispute = TaskDispute::create(['task_submission_id'=> $this->disputeSubmissionId,'desired_outcome'=> $this->desiredOutcome]);
        Trail::create(['trailable_id'=> $dispute->id,'trailable_type'=> get_class($dispute),'user_id'=> $this->getAdmin()->id]);
        $comment = Comment::create([
            'user_id'=> $this->user->id,
            'commentable_id'=> $dispute->id,
            'commentable_type'=> get_class($dispute),
            'body'=> $this->disputeReason,
            'attachments'=> $uploadedFiles,
        ]);

        return redirect()->route('tasks.dispute', $submission);
    }

    public function approveTask()
    {
        if (!auth()->user()->hasPermission('task_management')) {
            session()->flash('error', 'Unauthorized.');
            return;
        }

        $moderation = $this->task->latestModeration;
        if (!$moderation) {
            $moderation = new Moderation([
                'moderatable_id' => $this->task->id,
                'moderatable_type' => Task::class,
                'purpose' => 'task_approval',
            ]);
        }
        $moderation->moderator_id = auth()->id();
        $moderation->status = 'approved';
        $moderation->notes = 'Task approved';
        $moderation->moderated_at = now();
        $moderation->save();

        session()->flash('success', 'Task approved successfully.');
        $this->task->refresh();
    }

    public function confirmReject()
    {
        if (!auth()->user()->hasPermission('task_management')) {
            session()->flash('error', 'Unauthorized.');
            return;
        }

        $this->validate([
            'rejectNotes' => 'required|string|min:10',
        ]);

        $moderation = $this->task->latestModeration;
        if (!$moderation) {
            $moderation = new Moderation([
                'moderatable_id' => $this->task->id,
                'moderatable_type' => Task::class,
                'purpose' => 'task_approval',
            ]);
        }
        $moderation->moderator_id = auth()->id();
        $moderation->status = 'rejected';
        $moderation->notes = $this->rejectNotes;
        $moderation->moderated_at = now();
        $moderation->save();

        session()->flash('success', 'Task rejected successfully.');
        $this->rejectNotes = '';
        $this->task->refresh();
    }

    public function render()
    {
        return view('livewire.tasks.task-show');
    }
}
