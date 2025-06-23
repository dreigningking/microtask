<?php

namespace App\Livewire\Tasks;

use Livewire\Component;

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
    
    public function render()
    {
        return view('livewire.tasks.single-task-list');
    }
}
