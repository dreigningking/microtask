<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use App\Models\TaskWorker;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PostedTasks extends Component
{
    use WithPagination;

    public $search = '';
    public $activeTab = 'active';
    public $activePage = 1;
    public $completedPage = 1;
    public $draftsPage = 1;
    public $stats = [
        'total' => 0,
        'in_progress' => 0,
        'pending_review' => 0,
        'rejected' => 0,
        'drafts' => 0,
        'completed' => 0
    ];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = Auth::id();

        // Get all tasks for the user
        $tasks = Task::where('user_id', $userId)->with(['taskWorkers', 'taskSubmissions', 'latestModeration'])->get();

        $this->stats['total'] = $tasks->count();
        $this->stats['in_progress'] = $tasks->where('inProgress', true)->count();
        $this->stats['pending_review'] = $tasks->where('isPendingReview', true)->count();
        $this->stats['rejected'] = $tasks->where('isRejected', true)->count();
        $this->stats['drafts'] = $tasks->where('is_active', false)->count();
        $this->stats['completed'] = $tasks->where('isCompleted', true)->count();
    }


    public function getTasksQuery()
    {
        $query = Task::where('user_id', Auth::id())
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            });

        switch($this->activeTab) {
            case 'active':
                $query->where('is_active', true)->where('inProgress', true);
                break;
            case 'completed':
                $query->where('isCompleted', true);
                break;
            case 'drafts':
                $query->where('is_active', false);
                break;
        }

        return $query;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $activeTasks = Task::where('user_id', Auth::id())
            ->progressing()
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->with(['platform', 'taskWorkers', 'taskSubmissions'])
            ->latest()
            ->paginate(10, ['*'], 'activePage');

        $pendingReviewTasks = Task::where('user_id', Auth::id())
            ->pendingReview()
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->with(['platform', 'taskWorkers', 'taskSubmissions'])
            ->latest()
            ->paginate(10, ['*'], 'pendingPage');

        $completedTasks = Task::where('user_id', Auth::id())
            ->completed()
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->with(['platform', 'taskWorkers', 'taskSubmissions'])
            ->latest()
            ->paginate(10, ['*'], 'completedPage');

        $draftTasks = Task::where('user_id', Auth::id())
            ->where('is_active', false)
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->with(['platform', 'taskWorkers', 'taskSubmissions'])
            ->latest()
            ->paginate(10, ['*'], 'draftsPage');

        return view('livewire.tasks.posted-tasks', [
            'activeTasks' => $activeTasks,
            'pendingTasks' => $pendingReviewTasks,
            'completedTasks' => $completedTasks,
            'draftTasks' => $draftTasks
        ]);
    }
}
