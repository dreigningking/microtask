<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\TaskWorker;
use Livewire\Component;
use App\Http\Traits\GeoLocationTrait;
use Illuminate\Support\Facades\Auth;

class ShowPage extends Component
{
    use GeoLocationTrait;

    public Task $task;
    public $agreementAccepted = false;
    public $isSaved = false;
    public $hasStarted = false;
    public $countryId;
    public $canStartOrSave = true;

    public function mount(Task $task)
    {
        $this->task = $task->load(['user.country', 'platform', 'template', 'workers']);
        if (Auth::check()) {
            $this->countryId = Auth::user()->country_id;
        } else {
            $location = $this->getLocation();
            $this->countryId = $location ? $location->country_id : null;
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
            $allSubmitted = $this->task->workers->whereNotNull('accepted_at')->every(function($w) { return $w->submitted_at !== null; });
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

        $worker = TaskWorker::firstOrCreate(
            ['task_id' => $this->task->id, 'user_id' => \Illuminate\Support\Facades\Auth::id()],
            ['saved_at' => null]
        );

        $worker->update(['accepted_at' => now(), 'saved_at' => null]);

        return redirect()->route('my_tasks.view', $this->task);
    }

    public function saveTask()
    {
        if ($this->task->expiry_date && $this->task->expiry_date->isPast()) {
            session()->flash('error', 'This task has expired and cannot be saved.');
            return;
        }
        if (!$this->canStartOrSave) {
            session()->flash('error', 'This task is full and cannot be saved.');
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
    
    public function render()
    {
        return view('livewire.tasks.show-page');
    }
} 