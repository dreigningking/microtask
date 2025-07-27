<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SingleTaskList extends Component
{
    public $task;

    public function mount($task)
    {
        $this->task = $task->load(['user.country', 'platform', 'template']);
    }
    
    public function showTaskDetails($taskId)
    {
        $this->dispatch('showTaskDetails', taskId: $taskId);
    }

    public function hideTask($taskId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to hide tasks.');
            return;
        }

        $task = \App\Models\Task::find($taskId);
        if (!$task) {
            session()->flash('error', 'Task not found.');
            return;
        }

        // Add task to user's hidden tasks
        Auth::user()->hiddenTasks()->attach($taskId);
        
        session()->flash('message', 'Task hidden successfully.');
        $this->dispatch('task-hidden');
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
        return view('livewire.tasks.single-task-list');
    }
}
