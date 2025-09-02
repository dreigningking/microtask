<?php

namespace App\Livewire\LandingArea\ExploreTasks;

use App\Models\Task;
use Livewire\Component;
use App\Models\TaskWorker;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeoLocationTrait;

#[Layout('components.layouts.landing')]
class ExploreTaskShow extends Component
{
    use GeoLocationTrait;

    public Task $task;
    public $agreementAccepted = false;
    public $isSaved = false;
    public $hasStarted = false;
    public $countryId;
    public $canStartOrSave = true;
    public $isHidden = false;

    public function mount(Task $task)
    {
        $this->task = $task->load(['user.country', 'platform', 'template', 'workers']);
        if (Auth::check()) {
            $this->countryId = Auth::user()->country_id;
        } else {
            $location = $this->getLocation();
            $this->countryId = $location ? $location->country_id : null;
        }

        // Check if task is hidden by current user
        if (Auth::check()) {
            $this->isHidden = Auth::user()->hiddenTasks()->where('task_id', $task->id)->exists();
        }

        // Block if not approved
        if (is_null($this->task->approved_at)) {
            abort(404, 'Task not found.');
        }
        // Block if expired
        if ($this->task->expiry_date && $this->task->expiry_date->isPast()) {
            abort(404, 'Task has expired.');
        }
        // Block if restricted
        if (is_array($this->task->restricted_countries) && in_array($this->countryId, $this->task->restricted_countries)) {
            abort(404, 'Task not available in your country.');
        }

        if (count($this->task->workers->whereNotNull('accepted_at')) >= $this->task->number_of_people) {
            // If all slots filled and all have submitted
            $allSubmitted = $this->task->taskSubmissions()
                ->whereNotNull('completed_at')
                ->count() >= $this->task->number_of_people;
            if ($allSubmitted) {
                $this->canStartOrSave = false;
            }
        }

        if (Auth::check()) {
            $worker = $this->task->workers()
                ->where('user_id', Auth::id())
                ->first();

            if ($worker) {
                $this->isSaved = $worker->saved_at !== null && $worker->accepted_at === null;
                $this->hasStarted = $worker->accepted_at !== null;
            }
        }
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
            ['task_id' => $this->task->id, 'user_id' => \Illuminate\Support\Facades\Auth::id()],
            ['saved_at' => null]
        );

        $worker->update(['accepted_at' => now(), 'saved_at' => null]);

        return redirect()->route('tasks.view', $this->task);
    }

    public function saveTask()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to save tasks.');
            return;
        }

        if ($this->task->expiry_date && $this->task->expiry_date->isPast()) {
            session()->flash('error', 'This task has expired and cannot be saved.');
            return;
        }

        if (!$this->canStartOrSave) {
            session()->flash('error', 'This task is full and cannot be saved.');
            return;
        }

        // Check if user is banned from taking tasks
        if (Auth::user()->isBannedFromTasks()) {
            session()->flash('error', 'You are currently banned from taking tasks. Please contact support for more information.');
            return;
        }

        TaskWorker::updateOrCreate(
            ['task_id' => $this->task->id, 'user_id' => \Illuminate\Support\Facades\Auth::id()],
            ['saved_at' => now()]
        );

        $this->isSaved = true;
        session()->flash('message', 'Task saved successfully!');
    }

    public function unsaveTask()
    {
        $this->task->workers()
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->whereNotNull('saved_at')
            ->delete();

        $this->isSaved = false;
        session()->flash('message', 'Task has been unsaved.');
    }

    public function hideTask($taskId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to hide tasks.');
            return;
        }

        $task = Task::find($taskId);
        if (!$task) {
            session()->flash('error', 'Task not found.');
            return;
        }

        // Add task to user's hidden tasks
        Auth::user()->hiddenTasks()->sync($taskId);
        
        $this->isHidden = true;
        session()->flash('message', 'Task hidden successfully.');
        $this->dispatch('task-hidden');
    }

    public function unhideTask($taskId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to unhide tasks.');
            return;
        }

        $task = Task::find($taskId);
        if (!$task) {
            session()->flash('error', 'Task not found.');
            return;
        }

        // Remove task from user's hidden tasks
        Auth::user()->hiddenTasks()->detach($taskId);
        
        $this->isHidden = false;
        session()->flash('message', 'Task unhidden successfully.');
        $this->dispatch('task-unhidden');
    }

    public function reportTask($taskId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to report tasks.');
            return;
        }

        $this->dispatch('open-report-modal', taskId: $taskId);
    }
    
    public function render()
    {
        return view('livewire.landing-area.explore-tasks.explore-task-show');
    }
} 