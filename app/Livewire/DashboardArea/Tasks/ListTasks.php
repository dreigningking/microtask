<?php

namespace App\Livewire\DashboardArea\Tasks;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TaskWorker;
use App\Models\Task;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;


class ListTasks extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'all'; // 'all', 'accepted', 'saved', 'submitted', 'completed', 'cancelled'
    public $sortBy = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'sortBy' => ['except' => 'latest'],
    ];

    public function mount()
    {
        // Set status based on the current route
        $routeName = request()->route()->getName();
        switch ($routeName) {
            case 'tasks.ongoing':
                $this->status = 'accepted';
                break;
            case 'tasks.completed':
                $this->status = 'completed';
                break;
            case 'tasks.submitted':
                $this->status = 'submitted';
                break;
            case 'tasks.saved':
                $this->status = 'saved';
                break;
            default:
                $this->status = 'all';
                break;
        }
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
        $query = TaskWorker::where('user_id', Auth::id())
                           ->with(['task.user.country', 'task.platform', 'task.template']);

        if ($this->search) {
            $query->whereHas('task', function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        switch ($this->status) {
            case 'accepted':
                $query->whereNotNull('accepted_at')
                      ->whereDoesntHave('taskSubmissions', function($q) {
                          $q->whereNotNull('completed_at');
                      });
                break;
            case 'saved':
                $query->whereNotNull('saved_at')
                      ->whereNull('accepted_at')
                      ->whereDoesntHave('taskSubmissions', function($q) {
                          $q->whereNotNull('completed_at');
                      });
                break;
            case 'submitted':
                $query->whereNotNull('accepted_at')
                      ->whereHas('taskSubmissions', function($q) {
                          $q->whereNull('completed_at');
                      });
                break;
            case 'completed':
                $query->whereHas('taskSubmissions', function($q) {
                    $q->whereNotNull('completed_at');
                });
                break;
            case 'cancelled':
                // Cancelled tasks are soft deleted records, so we need to include them
                $query->withTrashed()->whereNotNull('deleted_at');
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

        // Get stats using the new TaskSubmission structure
        $totalTasks = TaskWorker::where('user_id', Auth::id())->count();
        
        $acceptedTasks = TaskWorker::where('user_id', Auth::id())
            ->whereNotNull('accepted_at')
            ->whereDoesntHave('taskSubmissions', function($q) {
                $q->whereNotNull('completed_at');
            })
            ->count();
            
        $savedTasks = TaskWorker::where('user_id', Auth::id())
            ->whereNotNull('saved_at')
            ->whereNull('accepted_at')
            ->whereDoesntHave('taskSubmissions', function($q) {
                $q->whereNotNull('completed_at');
            })
            ->count();
            
        $submittedTasks = TaskWorker::where('user_id', Auth::id())
            ->whereNotNull('accepted_at')
            ->whereHas('taskSubmissions', function($q) {
                $q->whereNull('completed_at');
            })
            ->count();
            
        $completedTasks = TaskWorker::where('user_id', Auth::id())
            ->whereHas('taskSubmissions', function($q) {
                $q->whereNotNull('completed_at');
            })
            ->count();
            
        $cancelledTasks = TaskWorker::where('user_id', Auth::id())
            ->withTrashed()
            ->whereNotNull('deleted_at')
            ->count();

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
