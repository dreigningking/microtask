<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use Livewire\Component;
use App\Models\TaskWorker;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;


class TaskShow extends Component
{
    use GeoLocationTrait;

    public Task $task;
    public $agreementAccepted = false;
    public $isSaved = false;
    public $hasStarted = false;
    public $countryId;
    public $canStartOrSave = true;
    public $userReported = false;
    
    // Availability tracking
    public $isTaskAvailable = false;
    public $unavailableReasons = [];
    
    // User state tracking
    public $userTaskWorker = null;
    public $userSubmissions;
    public $userSubmissionCount = 0;
    public $hasUserSubmitted = false;
    public $canSubmitMore = true;
    
    // Report functionality
    public $reportReason = '';

    // Comments functionality
    public $question = '';
    public $comments;
    public $similarQuestions = [];

    public function mount(Task $task)
    {

        $this->task = $task->load(['user.country', 'platform', 'platformTemplate', 'taskWorkers','latestModeration']);
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
        if (!Auth::check()) {
            return;
        }

        $userId = Auth::id();

        // Check if user has applied for this task
        $this->userTaskWorker = TaskWorker::where('task_id', $this->task->id)
            ->where('user_id', $userId)
            ->first();

        $this->hasStarted = $this->userTaskWorker !== null;

        // Load user's submissions for this task
        $this->userSubmissions = $this->task->taskSubmissions()
            ->where('user_id', $userId)
            ->get();

        $this->userSubmissionCount = $this->userSubmissions->count();
        $this->hasUserSubmitted = $this->userSubmissionCount > 0;

        // Check if user can submit more (for multiple submissions)
        if ($this->task->allow_multiple_submissions == 1) {
            $this->canSubmitMore = true; // Allow multiple
        } else {
            $this->canSubmitMore = !$this->hasUserSubmitted; // Only if no submission yet
        }
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
        dd('bla');
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
        $acceptedSubmissions = $this->task->taskSubmissions()->where('accepted', true)->count();
        if ($acceptedSubmissions >= $this->task->number_of_submissions) {
            $reasons[] = 'Task has been completed (all required submissions received)';
        }
        
        // Check if user is banned
        if (Auth::check() && Auth::user()->isBannedFromTasks()) {
            $reasons[] = 'You are currently banned from taking tasks';
        }
        
        return $reasons;
    }

    public function startTask()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to start tasks.');
            return;
        }

        if (!$this->agreementAccepted) {
            session()->flash('error', 'You must accept the terms to start the task.');
            return;
        }

        if (!$this->canStartOrSave) {
            session()->flash('error', 'This task is full and cannot be started.');
            return;
        }

        if ($this->task->expiry_date && $this->task->expiry_date->isPast()) {
            session()->flash('error', 'This task has expired and can no longer be started.');
            return;
        }

        // Check if user is banned from taking tasks
        /** @var \App\Models\User $user */
        if (Auth::user()->isBannedFromTasks()) {
            session()->flash('error', 'You are currently banned from taking tasks. Please contact support for more information.');
            return;
        }

        // Check if user can take tasks based on subscription limits
        // Note: canTakeTask method doesn't exist, removing this check for now
        // if (!Auth::user()->canTakeTask()) {
        //     session()->flash('error', 'You have reached your hourly task limit or do not have an active worker subscription.');
        //     return;
        // }

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
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to withdraw submissions.');
            return;
        }

        $submission = TaskSubmission::where('id', $submissionId)
            ->where('user_id', Auth::id())
            ->where('task_id', $this->task->id)
            ->where('accepted', false)
            ->whereNull('reviewed_at')
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
    
    public function render()
    {
        return view('livewire.tasks.task-show');
    }
}