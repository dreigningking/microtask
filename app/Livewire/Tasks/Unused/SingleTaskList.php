<?php

namespace App\Livewire\DashboardArea\Tasks;

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
        return view('livewire.dashboard-area.tasks.single-task-list');
    }
}
