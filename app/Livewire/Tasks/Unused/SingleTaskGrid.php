<?php

namespace App\Livewire\DashboardArea\Tasks;

use Livewire\Component;

class SingleTaskGrid extends Component
{
    public $task;

    public function mount($task)
    {
        $this->task = $task->load('user.country');
    }

    public function render()
    {
        return view('livewire.dashboard-area.tasks.single-task-grid');
    }
}
