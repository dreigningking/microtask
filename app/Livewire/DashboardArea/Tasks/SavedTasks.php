<?php

namespace App\Livewire\DashboardArea\Tasks;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TaskWorker;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class SavedTasks extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'all'; // 'all', 'accepted', 'saved', 'submitted', 'completed', 'cancelled'
    public $sortBy = 'latest';
    public $userData;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'sortBy' => ['except' => 'latest'],
    ];

    public function mount()
    {
        $this->userData = Auth::user();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'status',
            'sortBy',
        ]);
        $this->resetPage();
    }

    public function getTasksQuery()
    {
        $query = TaskWorker::where('user_id', $this->userData->id)
                           ->with(['task.user.country', 'task.platform', 'task.template']);

        if ($this->search) {
            $query->whereHas('task', function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        switch ($this->status) {
            case 'accepted':
                $query->whereNotNull('accepted_at')->whereDoesntHave('taskSubmissions');
                break;
            case 'saved':
                $query->whereNotNull('saved_at')->whereNull('accepted_at')->whereDoesntHave('taskSubmissions');
                break;
            case 'submitted':
                $query->whereHas('taskSubmissions')->whereDoesntHave('taskSubmissions', function($q) {
                    $q->whereNotNull('completed_at');
                });
                break;
            case 'completed':
                $query->whereHas('taskSubmissions', function($q) {
                    $q->whereNotNull('completed_at');
                });
                break;
            case 'cancelled':
                $query->whereNotNull('rejected_at');
                break;
            case 'all':
            default:
                // No additional status filter for 'all'
                break;
        }

        switch ($this->sortBy) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'budget_desc':
                $query->orderBy(Task::select('budget_per_person')->whereColumn('tasks.id', 'task_workers.task_id'), 'desc');
                break;
            case 'budget_asc':
                $query->orderBy(Task::select('budget_per_person')->whereColumn('tasks.id', 'task_workers.task_id'), 'asc');
                break;
        }

        return $query;
    }

    public function render()
    {
        $tasks = $this->getTasksQuery()->paginate(10);

        // Get stats
        $userId = $this->userData->id;
        $totalTasks = TaskWorker::where('user_id', $userId)->count();
        $acceptedTasks = TaskWorker::where('user_id', $userId)->whereNotNull('accepted_at')->whereDoesntHave('taskSubmissions')->count();
        $savedTasks = TaskWorker::where('user_id', $userId)->whereNotNull('saved_at')->whereNull('accepted_at')->whereDoesntHave('taskSubmissions')->count();
        $submittedTasks = TaskWorker::where('user_id', $userId)->whereHas('taskSubmissions')->whereDoesntHave('taskSubmissions', function($q) {
            $q->whereNotNull('completed_at');
        })->count();
        $completedTasks = TaskWorker::where('user_id', $userId)->whereHas('taskSubmissions', function($q) {
            $q->whereNotNull('completed_at');
        })->count();
        $cancelledTasks = TaskWorker::where('user_id', $userId)->whereNotNull('rejected_at')->count();

        $stats = [
            'total' => $totalTasks,
            'accepted' => $acceptedTasks,
            'saved' => $savedTasks,
            'submitted' => $submittedTasks,
            'completed' => $completedTasks,
            'cancelled' => $cancelledTasks,
        ];

        return view('livewire.dashboard-area.tasks.list-tasks', [
            'tasks' => $tasks,
            'stats' => $stats,
        ]);
    }
}
