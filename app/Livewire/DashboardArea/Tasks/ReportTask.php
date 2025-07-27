<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\TaskReport;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReportTask extends Component
{
    public $taskId;
    public $task;
    public $reason = '';
    public $description = '';
    public $showModal = false;

    protected $rules = [
        'reason' => 'required|in:broken_link,unclear_instructions,takes_longer_than_2_hours,other',
        'description' => 'nullable|string|max:1000',
    ];

    protected $listeners = ['open-report-modal' => 'openModal'];

    public function openModal($taskId)
    {
        $this->taskId = $taskId;
        $this->task = Task::find($taskId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['taskId', 'task', 'reason', 'description']);
    }

    public function submitReport()
    {
        $this->validate();

        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to report tasks.');
            return;
        }

        // Check if user has already reported this task
        $existingReport = TaskReport::where('task_id', $this->taskId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReport) {
            session()->flash('error', 'You have already reported this task.');
            return;
        }

        // Create the report
        TaskReport::create([
            'task_id' => $this->taskId,
            'user_id' => Auth::id(),
            'reason' => $this->reason,
            'description' => $this->description,
            'status' => 'pending'
        ]);

        session()->flash('message', 'Task reported successfully. Our team will review it shortly.');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.tasks.report-task');
    }
} 